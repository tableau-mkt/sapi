<?php

namespace Drupal\sapi;

/**
 * Interface StatisticsItemInterface.
 *
 * @package Drupal\sapi
 */
interface StatisticsItemInterface {

    /**
     * {@inheritdoc}
     */
    public function getAction();

    /**
     * {@inheritdoc}
     */
    public function getUri();
}
