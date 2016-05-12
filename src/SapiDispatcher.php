<?php

namespace Drupal\sapi;

use Drupal\Core\Config\ConfigManager;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\sapi\StatisticsItemInterface;

/**
 * Class SapiDispatcher.
 *
 * @package Drupal\sapi
 */
class SapiDispatcher implements SapiDispatcherInterface {

  /**
   * Drupal\Core\Config\ConfigManager definition.
   *
   * @var Drupal\Core\Config\ConfigManager
   */
  protected $configManager;

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * Drupal\Core\Routing\CurrentRouteMatch definition.
   *
   * @var Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;
  
  /**
   *
   * @param \Drupal\Core\Config\ConfigManager $configManager
   * @param \Drupal\Core\Session\AccountProxy $currentUser
   * @param \Drupal\Core\Routing\CurrentRouteMatch $currentRouteMatch
   */
  public function __construct(ConfigManager $configManager, AccountProxy $currentUser, CurrentRouteMatch $currentRouteMatch) {
    $this->configManager = $configManager;
    $this->currentUser = $currentUser;
    $this->currentRouteMatch = $currentRouteMatch;
  }

   /**
    * Dispatches the statistics item to interested parties.
    * 
    * @param StatisticsItemInterface $item
   */
  public function dispatch(StatisticsItemInterface $item){

  }

}
