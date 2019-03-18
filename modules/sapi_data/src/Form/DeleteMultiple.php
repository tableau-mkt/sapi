<?php

namespace Drupal\sapi_data\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\user\PrivateTempStoreFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Provides a sapi_data deletion confirmation form.
 */
class DeleteMultiple extends ConfirmFormBase {

  /**
   * The array of sapi data items to delete.
   *
   * @var string[]
   */
  protected $dataInfo = [];

  /**
   * The tempstore factory.
   *
   * @var \Drupal\user\PrivateTempStoreFactory
   */
  protected $tempStoreFactory;

  /**
   * The sapi data storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $manager;

  /**
   * Constructs a DeleteMultiple form object.
   *
   * @param \Drupal\user\PrivateTempStoreFactory $temp_store_factory
   *   The tempstore factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $manager
   *   The entity manager.
   */
  public function __construct(PrivateTempStoreFactory $temp_store_factory, EntityTypeManagerInterface $manager) {
    $this->tempStoreFactory = $temp_store_factory;
    $this->storage = $manager->getStorage('sapi_data');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.private_tempstore'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sapi_data_multiple_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->formatPlural(count($this->dataInfo), 'Are you sure you want to delete this item?', 'Are you sure you want to delete these items?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.sapi_data.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $this->dataInfo = $this->tempStoreFactory->get('sapi_data_multiple_delete_confirm')->get(\Drupal::currentUser()->id());
    if (empty($this->dataInfo)) {
      return new RedirectResponse($this->getCancelUrl()->setAbsolute()->toString());
    }
    /** @var \Drupal\sapi_data\Entity\SAPIData[] $data_entries */
    $data_entries = $this->storage->loadMultiple($this->dataInfo);

    $items = [];
    foreach ($data_entries as $id => $sapi_data) {
      $items[$id] = $sapi_data->label();
    }

    $form['sapi_data_entries'] = [
      '#theme' => 'item_list',
      '#items' => $items,
    ];
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('confirm') && !empty($this->dataInfo)) {
      /** @var \Drupal\sapi_data\Entity\SAPIData[] $entries */
      $entries = $this->storage->loadMultiple($this->dataInfo);

      $this->storage->delete($entries);
      $this->logger('SAPI')
        ->notice('Deleted @count entries.', ['@count' => count($entries)]);
      drupal_set_message($this->formatPlural(count($entries), 'Deleted 1 entries.', 'Deleted @count entries.'));

      $this->tempStoreFactory->get('sapi_data_multiple_delete_confirm')->delete(\Drupal::currentUser()->id());
    }

    $form_state->setRedirect('entity.sapi_data.collection');
  }

}
