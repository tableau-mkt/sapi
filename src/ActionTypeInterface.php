<?php

namespace Drupal\sapi;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Plugin\ContextAwarePluginInterface;

/**
 * Defines an interface for Statistics action type plugins.
 */
interface ActionTypeInterface extends PluginInspectionInterface, ContextAwarePluginInterface {

  /**
   * Describe yourself in one line, typically used for logging.
   *
   * @return string
   *   1-line description of what this plugin contains.
   */
  public function describe();

}
