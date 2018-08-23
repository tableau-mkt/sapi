<?php

namespace Drupal\sapi\Plugin\Statistics\ActionHandler;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\sapi\ActionTypeInterface;
use Drupal\sapi\ConfigurableActionHandlerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Action handler plugin that logs items to a file.
 *
 * @ActionHandler (
 *  id = "action_file_logger",
 *  label = "Action File Logger",
 *  description = "Log any received actions to a file"
 * )
 *
 * Action handler, which logs the ->describe() string of every
 * received plugin to a file.
 */
class ActionFileLogger extends ConfigurableActionHandlerBase implements ContainerFactoryPluginInterface {

  /**
   * Default file path.
   *
   * @constant file path
   */
  const DEFAULT_FILE_PATH = "/tmp/file_logger.txt";

  /**
   * ActionFileLogger constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Config factory required by ConfigurableActionHandlerBase.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $configFactory);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,

      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function process(ActionTypeInterface $action) {
    try {
      // Write the action type data to a file with timestamp and new line.
      $log_file = isset($this->configuration['file_path']) ? $this->configuration['file_path'] : self::DEFAULT_FILE_PATH;
      $data = time() . ' ' . $action->describe() . PHP_EOL;

      $handle = fopen($log_file, 'a');
      fwrite($handle, $data);
      fclose($handle);
    }
    catch (\Exception $e) {
      watchdog_exception('sapi', $e);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['file_path'] = [
      '#type' => 'textfield',
      '#title' => 'File path',
      '#description' => 'Enter the full server path and file name for the log file.',
      '#default_value' => $this->configuration['file_path'],
    ];

    return $form;
  }

}
