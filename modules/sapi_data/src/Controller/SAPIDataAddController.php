<?php

namespace Drupal\sapi_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SAPIDataAddController.
 *
 * @package Drupal\sapi_data\Controller
 */
class SAPIDataAddController extends ControllerBase {

  /**
   * Entity storage for sapi data type.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $typeStorage;

  /**
   * Entity storage for sapi data.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $storage;

  /**
   * SAPIDataAddController constructor.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   Entity storage for sapi data.
   * @param \Drupal\Core\Entity\EntityStorageInterface $typeStorage
   *   Entity storage for sapi data type.
   */
  public function __construct(EntityStorageInterface $storage, EntityStorageInterface $typeStorage) {
    $this->storage = $storage;
    $this->typeStorage = $typeStorage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    /** @var \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager */
    $entity_type_manager = $container->get('entity_type.manager');
    return new static(
    $entity_type_manager->getStorage('sapi_data'),
    $entity_type_manager->getStorage('sapi_data_type')
    );
  }

  /**
   * Displays add links for available bundles/types for entity sapi_data .
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object.
   *
   * @return array
   *   Array for a list of the sapi_data bundles/types that can be added
   *   or add page for that bundle/type.
   */
  public function add(Request $request) {
    $types = $this->typeStorage->loadMultiple();
    if ($types && count($types) == 1) {
      $type = reset($types);
      return $this->addForm($type, $request);
    }
    if (count($types) === 0) {
      return [
        '#markup' => $this->t('You have not created any %bundle types yet. @link to add a new type.', [
          '%bundle' => 'Statistics API Data entry',
          '@link' => $this->l($this->t('Go to the type creation page'), Url::fromRoute('entity.sapi_data_type.add_form')),
        ]),
      ];
    }
    return ['#theme' => 'sapi_data_content_add_list', '#content' => $types];
  }

  /**
   * Presents the creation form for sapi_data entities of given bundle/type.
   *
   * @param \Drupal\Core\Entity\EntityInterface $sapi_data_type
   *   The custom bundle to add.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object.
   *
   * @return array
   *   A form array as expected by drupal_render().
   */
  public function addForm(EntityInterface $sapi_data_type, Request $request) {
    $entity = $this->storage->create([
      'type' => $sapi_data_type->id(),
    ]);
    return $this->entityFormBuilder()->getForm($entity);
  }

  /**
   * Provides the page title for this controller.
   *
   * @param \Drupal\Core\Entity\EntityInterface $sapi_data_type
   *   The custom bundle/type being added.
   *
   * @return string
   *   The page title.
   */
  public function getAddFormTitle(EntityInterface $sapi_data_type) {
    return t('Create of bundle @label',
    ['@label' => $sapi_data_type->label()]
    );
  }

}
