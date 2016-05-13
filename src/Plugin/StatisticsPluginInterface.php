<?php

namespace Drupal\sapi\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\sapi\StatisticsItemInterface;

/**
 * Interface StatisticsPluginInterface
 *
 * Defines an interface for plugins of type "StatisticsPlugin".
 */
interface StatisticsPluginInterface extends PluginInspectionInterface {

  /**
   * Processes the statistics item and performs an arbitrary action upon it
   * (e.g., logs, aggregates).
   *
   * @param StatisticsItemInterface $item
   *
   * @return void
   */
  public function process(StatisticsItemInterface $item);

}
