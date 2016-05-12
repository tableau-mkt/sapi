<?php

namespace Drupal\sapi\Form;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class StatisticsPluginListForm.
 *
 * @package Drupal\sapi\Form
 */
class StatisticsPluginListForm extends ConfigFormBase {

  /**
   * The statistics plugin manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface $statisticsPluginManager
   */
  protected $statisticsPluginManager;

  /**
   * Constructs a new StatisticsPluginListForm form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\Component\Plugin\PluginManagerInterface $statistics_plugin_manager
   */
  public function __construct(ConfigFactoryInterface $config_factory, PluginManagerInterface $statistics_plugin_manager) {
    parent::__construct($config_factory);
    $this->statisticsPluginManager = $statistics_plugin_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('plugin.manager.statisticsplugin')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'sapi.statistics_plugins',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'statistics_plugin_list_form';
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

    $form['plugins']['statistics_plugins'] = [
      '#type' => 'table',
      '#header' => [
        $this->t('ID'),
      ],
      '#empty' => $this->t('There are no plugins yet.'),
      '#tableselect' => TRUE,
      '#default_value' => $this->config('sapi.statistics_plugins')->get('enabled'),
    ];

    /** @var \Drupal\sapi\Plugin\StatisticsPluginInterface $instance */
    foreach ($this->statisticsPluginManager->getDefinitions() as $pluginDefinition) {
      $id = $pluginDefinition['id'];
      $form['plugins']['statistics_plugins'][$id]['id'] = array(
        '#plain_text' => $id,
      );
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('sapi.statistics_plugins')
      ->set('enabled', array_filter($form_state->getValue('statistics_plugins')))
      ->save();
  }

}
