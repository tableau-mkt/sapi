<?php

namespace Drupal\sapi;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Form\ConfigFormBaseTrait;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Form\FormStateInterface;

/**
 * Base class for Statistics action handler plugins that implements
 * PluginFormInterface and provides configuration form.
 */
abstract class ConfigurableActionHandlerBase extends PluginBase implements ActionHandlerInterface, PluginFormInterface {
  use ConfigFormBaseTrait;
  use StringTranslationTrait;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a \Drupal\sapi\ConfigurableActionHandlerBase object.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param array $plugin_definition
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory ) {
    parent:: __construct($configuration, $plugin_id, $plugin_definition);
      $this->setConfigFactory($config_factory);
    }

  /**
   * Sets the config factory for this form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   *
   * @return $this
   */
  public function setConfigFactory(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('The configuration options have been saved.'));
  }

}
