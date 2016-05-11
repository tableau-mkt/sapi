<?php

namespace Drupal\sapi;

use Drupal\sapi\StatisticsItemInterface;

/**
 * Interface SapiDispatcherInterface.
 *
 * @package Drupal\sapi
 */
interface SapiDispatcherInterface {

   /**
    * Dispatches the statistics item to interested parties.
    * 
    * @param StatisticsItemInterface $item
   */
  public function dispatch(StatisticsItemInterface $item);

}
