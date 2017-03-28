<?php

namespace Drupal\sapi\Exception;

/**
 * Configuration exception for plugin.
 *
 * Should be thrown when a plugin did not receive expected parameters during
 * construction, in the configuration array.
 */
class MissingPluginConfiguration extends \Exception {

}
