<?php

namespace Drupal\sapi\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\sapi;

/**
 * Defines an interface for Statistics plugin plugins.
 */
interface StatisticsPluginInterface extends PluginInspectionInterface {

  /**
   * process() method which analize the data received from dispatcher service
   */
  public function process(StatisticsItemIterface $item);

}
