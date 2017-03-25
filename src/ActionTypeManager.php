<?php

namespace Drupal\sapi;

use Drupal\Core\Plugin\Context\ContextAwarePluginManagerInterface;
use Drupal\Core\Plugin\Context\ContextAwarePluginManagerTrait;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\sapi\Exception\MissingPluginConfiguration;

/**
 * Provides the Statistics action type plugin manager.
 */
class ActionTypeManager extends DefaultPluginManager implements ContextAwarePluginManagerInterface {

  // Use the CAPM trait to satisfy the ContextAware plugin manager interface.
  use ContextAwarePluginManagerTrait;

  /**
   * Constructor for ActionTypeManager objects.
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
    parent::__construct('Plugin/Statistics/ActionType', $namespaces, $module_handler, 'Drupal\sapi\ActionTypeInterface', 'Drupal\sapi\Annotation\ActionType');

    $this->alterInfo('sapi_sapi_action_type_info');
    $this->setCacheBackend($cache_backend, 'sapi_sapi_action_type_plugins');
  }

  /**
   * Creates a pre-configured instance of a plugin.
   *
   * @param string $plugin_id
   *   ID of plugin.
   * @param array $configuration
   *   Configurations for creating instance.
   *
   * @return \Drupal\sapi\ActionTypeInterface
   *   Returns plugin that implements ActionTypeInterface.
   *
   * @throws \Drupal\sapi\Exception\MissingPluginConfiguration
   */
  public function createInstance($plugin_id, array $configuration = []) {
    /*
     * @see https://www.drupal.org/node/2753585
     *
     * Drupal 8.x has a bug which prevents setting of contexts during
     * plugin construction of ContextAwarePluginBase plugins.
     *
     * Here we manually repeat that process.
     */

    /** @var [] $contexts */
    $contexts = isset($configuration['context']) ? $configuration['context'] : [];
    unset($configuration['context']);

    /** @var ActionTypeInterface $instance */
    $instance = parent::createInstance($plugin_id, $configuration);

    // Set any contexts.
    foreach ($contexts as $key => $value) {
      $instance->setContextValue($key, $value);
    }

    // Check any context constraints.
    /** @var \Symfony\Component\Validator\ConstraintViolationListInterface $violations */
    $violations = $instance->validateContexts();
    /** @var string[] $messages */
    if ($violations->count() > 0) {
      $messages = [];

      foreach ($violations as $violation) {
        // @todo these messages are actually pretty weak.
        /** @var \Symfony\Component\Validator\ConstraintViolationInterface $violation */
        $messages[] .= $violation->getMessage();
      }

      drupal_set_message('FAILED TO CREATE ACTION');
      throw new MissingPluginConfiguration('ActionType context constraint violation (check your plugin contexts): ' . implode(".\n ", $messages));
    }

    return $instance;
  }

}
