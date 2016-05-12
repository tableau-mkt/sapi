<?php

namespace Drupal\sapi\Plugin\StatisticsPlugin;

use Drupal\sapi\Plugin\StatisticsPluginInterface;

/**
 * @StatisticsPlugin(
 *  id = "dummy",
 *  label = "Dummy label"
 * )
 */
class Dummmy implements StatisticsPluginInterface {

    public function process(StatisticsItemIterface $item){
      $message = $item->getAction();
      \Drupal::logger('SAPI')->notice($message);
    }
}
