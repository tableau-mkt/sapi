<?php

namespace Drupal\sapi;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Statistics action handler plugin manager.
 */
class ActionHandlerManager extends DefaultPluginManager {

  /**
   * Constructor for ActionHandlerManager objects.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Statistics/ActionHandler', $namespaces, $module_handler, 'Drupal\sapi\ActionHandlerInterface', 'Drupal\sapi\Annotation\ActionHandler');

    $this->alterInfo('sapi_sapi_action_handler_info');
    $this->setCacheBackend($cache_backend, 'sapi_sapi_action_handler_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    $definitions = parent::getDefinitions();

    // Sort the defintions.
    ksort($definitions);

    return $definitions;
  }

}
