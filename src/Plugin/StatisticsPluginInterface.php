<?php

namespace Drupal\sapi\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\sapi\StatisticsItemIterface;

/**
 * Defines an interface for Statistics plugin plugins.
 */
interface StatisticsPluginInterface extends PluginInspectionInterface {

  /**
   * process() method which analize and processed the data received
   * from StatisticsItemIterface
   *
   * @param StatisticsItemIterface $item
   *
   */
  public function process(StatisticsItemIterface $item);

}
