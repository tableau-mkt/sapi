<?php

namespace Drupal\sapi;

/**
 * Class StatisticsItem.
 *
 * @package Drupal\sapi
 */
class StatisticsItem implements StatisticsItemInterface {

  /**
   * Arbitrary action on a URI.
   *
   * @var string
   */
  protected $action;

  /**
   * Route name or other identification that can point to a content item.
   *
   * @var string
   */
  protected $uri;

  /**
   * Statistics item constructor.
   *
   * @param string $action
   *   String containing arbitrary action on a URI.
   *
   * @param string $uri
   *   String containing route name.
   */
  public function __construct($action, $uri) {
      if (!is_string($action) || !is_string($uri)) {
          throw new \InvalidArgumentException('Action and uri must be of type string.');
      }
      $this->action = $action;
      $this->uri = $uri;
  }

  /**
   * {@inheritdoc}
   */
    public function getAction() {
      return $this->action;
  }

  /**
   * {@inheritdoc}
   */
  public function getUri() {
    return $this->uri;
  }
}
