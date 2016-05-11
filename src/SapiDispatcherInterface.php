<?php

namespace Drupal\sapi;

use \Drupal\sapi\StatisticsItemInterface;

/**
 * Interface SapiDispatcherInterface.
 *
 * @package Drupal\sapi
 */
interface SapiDispatcherInterface {

   /**
    * Creates plugin instances.
    * 
    * @param StatisticsItemInterface $item
   */
  public function dispatch(StatisticsItemInterface $item);

}
