<?php

namespace Drupal\sapi;

/**
 * Interface DispatcherInterface.
 *
 * @package Drupal\sapi
 */
interface DispatcherInterface {

   /**
    * Dispatches the statistics item to interested parties.
    *
    * @param StatisticsItemInterface $item
   */
  public function dispatch(StatisticsItemInterface $item);

}
