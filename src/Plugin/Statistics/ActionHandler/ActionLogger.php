<?php

namespace Drupal\sapi\Plugin\Statistics\ActionHandler;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\sapi\ActionHandlerBase;
use Drupal\sapi\ActionHandlerInterface;
use Drupal\sapi\ActionTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Test action handler plugin that logs items using Drupal logger.
 *
 * @ActionHandler (
 *  id = "action_logger",
 *  label = "Log any received actions"
 * )
 *
 * Testing action handler, which only logs the ->describe() string of every
 * received plugin, so that you can check the Drupal logs to see if actions
 * are being sent properly.
 */
class ActionLogger extends ActionHandlerBase implements ActionHandlerInterface, ContainerFactoryPluginInterface {

  /**
   * Logger used to track handling.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * ActionLogger constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   Logger factory to log action types.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerChannelFactoryInterface $loggerFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    // don't keep the whole factory, just the one logger.
    $this->logger = $loggerFactory->get('sapi');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,

      $container->get('logger.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function process(ActionTypeInterface $action) {
    // Just throw the action at the log for now.
    $this->logger->info($action->describe());
  }

}
