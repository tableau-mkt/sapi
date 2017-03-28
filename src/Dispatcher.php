<?php

namespace Drupal\sapi;

use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Class Dispatcher.
 *
 * @package Drupal\sapi
 */
class Dispatcher implements DispatcherInterface {

  /**
   * Drupal\Component\Plugin\PluginManagerInterface definition.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $sapiActionHandlerPluginManager;

  /**
   * Dispatcher constructor.
   *
   * @param \Drupal\Component\Plugin\PluginManagerInterface $sapiActionHandlerPluginManager
   *   Plugin manager for Action handler plugins.
   */
  public function __construct(PluginManagerInterface $sapiActionHandlerPluginManager) {
    $this->sapiActionHandlerPluginManager = $sapiActionHandlerPluginManager;
  }

  /**
   * {@inheritdoc}
   */
  public function dispatch(ActionTypeInterface $action) {
    /** @var []string $enabled */
    $enabled = \Drupal::config('sapi.action_handlers')->get('enabled');
    foreach ($enabled as $id) {
      try {
        /** @var \Drupal\sapi\ActionHandlerInterface $instance */
        $instance = $this->sapiActionHandlerPluginManager->createInstance($id);
        $instance->process($action);
      }
      catch (\Exception $e) {
        \Drupal::logger('default')
          ->error("Error during SAPI dispatch : " . $e->getMessage());
      }
    }
  }

}
