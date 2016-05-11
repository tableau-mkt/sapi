<?php

/**
 * @file
 * Contains \Drupal\sapi\Plugin\SapiHandlerAnnotationManager.
 */

namespace Drupal\sapi\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Sapi handler annotation plugin manager.
 */
class SapiHandlerAnnotationManager extends DefaultPluginManager {

  /**
   * Constructor for SapiHandlerAnnotationManager objects.
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
    parent::__construct('Plugin/SapiHandlerAnnotation', $namespaces, $module_handler, 'Drupal\sapi\Plugin\SapiHandlerAnnotationInterface', 'Drupal\sapi\Annotation\SapiHandlerAnnotation');

    $this->alterInfo('sapi_SapiHandlerAnnotation_info');
    $this->setCacheBackend($cache_backend, 'sapi_SapiHandlerAnnotation_plugins');
  }

}
