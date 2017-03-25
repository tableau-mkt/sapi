<?php

namespace Drupal\sapi\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Configuration exception for plugin.
 *
 * Should be thrown when plugin did not receive expected parameters during
 * construction, in the configuration array.
 */
class MissingConfigurationObject extends BadRequestHttpException {

}
