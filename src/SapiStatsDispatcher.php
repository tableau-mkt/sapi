<?php

namespace Drupal\sapi;

use Drupal\Core\Config\ConfigManager;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Routing\CurrentRouteMatch;

/**
 * Class SapiStatsDispatcher.
 *
 * @package Drupal\sapi
 */
class SapiStatsDispatcher implements SapiStatsDispatcherInterface {

  /**
   * Drupal\Core\Config\ConfigManager definition.
   *
   * @var Drupal\Core\Config\ConfigManager
   */
  protected $config_manager;

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var Drupal\Core\Session\AccountProxy
   */
  protected $current_user;

  /**
   * Drupal\Core\Routing\CurrentRouteMatch definition.
   *
   * @var Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $current_route_match;
  /**
   *
   * @param \Drupal\Core\Config\ConfigManager $configManager
   * @param \Drupal\Core\Session\AccountProxy $currentUser
   * @param \Drupal\Core\Routing\CurrentRouteMatch $currentRouteMatch
   */
  public function __construct(ConfigManager $config_manager, AccountProxy $current_user, CurrentRouteMatch $current_route_match) {
    $this->config_manager = $config_manager;
    $this->current_user = $current_user;
    $this->current_route_match = $current_route_match;
  }

   /**
    * Receives event data and creates plugin instances.
    * 
    * @param array $data
   */
  public function dispatch(array $data){

  }

}
