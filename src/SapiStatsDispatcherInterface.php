<?php

namespace Drupal\sapi;

use \Drupal\sapi\StatisticsItemInterface;

/**
 * Interface SapiStatsDispatcherInterface.
 *
 * @package Drupal\sapi
 */
interface SapiStatsDispatcherInterface {

   /**
    * Creates plugin instances.
    * 
    * @param StatisticsItemInterface $item
   */
  public function dispatch(StatisticsItemInterface $item);

}
