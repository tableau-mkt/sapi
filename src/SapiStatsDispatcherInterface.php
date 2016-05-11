<?php

namespace Drupal\sapi;

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
