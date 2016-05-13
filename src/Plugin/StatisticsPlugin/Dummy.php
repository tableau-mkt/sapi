<?php

namespace Drupal\sapi\Plugin\StatisticsPlugin;

use Drupal\sapi\Plugin\StatisticsPluginInterface;
use Drupal\sapi\Plugin\StatisticsPluginBase;
use Drupal\sapi\StatisticsItemInterface;

/**
 * @StatisticsPlugin(
 *  id = "dummy",
 *  label = "Dummy label"
 * )
 */
class Dummy extends StatisticsPluginBase implements StatisticsPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function process(StatisticsItemInterface $item){
    $message = $item->getAction();
    \Drupal::logger('SAPI')->notice($message);
  }

}
