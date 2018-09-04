<?php

namespace Drupal\sapi\Form;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;

/**
 * Class StatisticsPluginListForm.
 *
 * @package Drupal\sapi\Form
 */
class StatisticsPluginListForm extends ConfigFormBase {

  /**
   * The statistics action type plugin manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $sapiActionTypeManager;

  /**
   * The statistics action handler plugin manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $sapiActionHandlerManager;

  /**
   * Constructs a new StatisticsPluginListForm form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Configuration factory required by ConfigFormBase.
   * @param \Drupal\Component\Plugin\PluginManagerInterface $sapiActionTypeManager
   *   Action type manager to load plugin definitions.
   * @param \Drupal\Component\Plugin\PluginManagerInterface $sapiActionHandlerManager
   *   Action handler manager to load plugin definitions.
   */
  public function __construct(ConfigFactoryInterface $configFactory,
                              PluginManagerInterface $sapiActionTypeManager,
                              PluginManagerInterface $sapiActionHandlerManager) {
    parent::__construct($configFactory);
    $this->sapiActionTypeManager = $sapiActionTypeManager;
    $this->sapiActionHandlerManager = $sapiActionHandlerManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('plugin.manager.sapi_action_type'),
      $container->get('plugin.manager.sapi_action_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'sapi.entity_events',
      'sapi.action_types',
      'sapi.action_handlers',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'statistics_handler_list_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['plugins'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Statistics plugins'),
      '#description' => $this->t('Select the statistics plugins that you want to have enabled.'),
    ];

    $form['plugins']['action_types'] = [
      '#type' => 'table',
      '#header' => [
        'label' => $this->t('Name'),
        'description' => $this->t('Description'),
      ],
      '#empty' => $this->t('There are no plugins yet.'),
      '#default_value' => $this->config('sapi.action_types')->get('enabled'),
      '#caption' => $this->t('Action Types'),
    ];

    // Loop through the statistics plugins.
    foreach ($this->sapiActionTypeManager->getDefinitions() as $pluginDefinition) {
      $id = $pluginDefinition['id'];

      $label = $pluginDefinition['label'];

      $description = $pluginDefinition['description'];

      $form['plugins']['action_types'][$id] = [
        'label' => ['#plain_text' => $label],
        'description' => ['#plain_text' => $description],
      ];
    }

    $form['plugins']['action_handlers'] = [
      '#type' => 'table',
      '#header' => [
        'label' => $this->t('Name'),
        'description' => $this->t('Description'),
        'operations' => $this->t('Operations'),
      ],
      '#empty' => $this->t('There are no plugins yet.'),
      '#tableselect' => TRUE,
      '#default_value' => $this->config('sapi.action_handlers')->get('enabled'),
      '#caption' => $this->t('Action Handlers'),
    ];

    // Loop through the statistics plugins.
    foreach ($this->sapiActionHandlerManager->getDefinitions() as $pluginDefinition) {
      $id = $pluginDefinition['id'];

      $label = $pluginDefinition['label'];

      $description = $pluginDefinition['description'];

      $form['plugins']['action_handlers'][$id] = [
        'label' => ['#plain_text' => $label],
        'description' => ['#plain_text' => $description],
      ];

      $form['plugins']['action_handlers'][$id]['operations'] = [
        '#type' => 'operations',
      ];

      if (isset(class_implements($pluginDefinition['class'])['Drupal\Core\Plugin\PluginFormInterface'])) {
        $form['plugins']['action_handlers'][$id]['operations']['#links']['edit'] = [
          'title' => $this->t('Edit'),
          'url' => new Url('sapi.plugin_configure_form', ['plugin' => $id]),
        ];
      }

    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('sapi.action_types')
      ->set('enabled', array_filter($form_state->getValue('action_types')))
      ->save();

    $this->config('sapi.action_handlers')
      ->set('enabled', array_filter($form_state->getValue('action_handlers')))
      ->save();
  }

}
