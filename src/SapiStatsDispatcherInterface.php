<?php

namespace Drupal\sapi;

/**
 * Interface SapiStatsDispatcherInterface.
 *
 * @package Drupal\sapi
 */
interface SapiStatsDispatcherInterface {

   /**
    * Receives event data and creates plugin instances.
    * 
    * @param array $data
   */
  public function dispatch(array $data);


}
