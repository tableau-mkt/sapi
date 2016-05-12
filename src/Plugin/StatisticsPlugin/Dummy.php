<?php

namespace Drupal\sapi\Plugin\StatisticsPlugin;

use Drupal\sapi\Plugin\StatisticsPluginInterface;
use Drupal\sapi\Plugin\StatisticsPluginBase;

/**
 * @StatisticsPlugin(
 *  id = "dummy",
 *  label = "Dummy label"
 * )
 */
class Dummmy extends StatisticsPluginBase implements StatisticsPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function process(StatisticsItemIterface $item){
    $message = $item->getAction();
    \Drupal::logger('SAPI')->notice($message);
  }
}
