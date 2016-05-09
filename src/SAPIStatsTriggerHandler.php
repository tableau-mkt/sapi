<?php

namespace Drupal\sapi;

use Drupal\Core\Config\ConfigManager;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Routing\CurrentRouteMatch;

/**
 * Class SAPIStatsTriggerHandler.
 *
 * @package Drupal\sapi
 */
class SAPIStatsTriggerHandler implements SAPIStatsTriggerHandlerInterface {

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
   * Constructor.
   */
  public function __construct(ConfigManager $config_manager, AccountProxy $current_user, CurrentRouteMatch $current_route_match) {
    $this->config_manager = $config_manager;
    $this->current_user = $current_user;
    $this->current_route_match = $current_route_match;
  }

}
