<?php

namespace Drupal\sapi;

use Drupal\sapi\StatisticsItemInterface;

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
     * @param array $data
     *   An associative array containing the event data.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $data) {
        if (empty($data['action']) || empty($data['uri'])) {
            throw new \InvalidArgumentException('Action and/or uri can not be empty.');
        }
        $this->action = $data['action'];
        $this->uri = $data['uri'];
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
