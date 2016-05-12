<?php

namespace Drupal\sapi;

/**
 * Interface StatisticsItemInterface.
 *
 * @package Drupal\sapi
 */
interface StatisticsItemInterface {
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
     * {@inheritdoc}
     */
    public function getAction();

    /**
     * {@inheritdoc}
     */
    public function getUri();
}
