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
   * The configuration manager.
   *
   * @var \Drupal\Core\Config\ConfigManager
   */
  protected $configManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * The current route match service.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * SAPIStatsTriggerHandler constructor.
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

}
