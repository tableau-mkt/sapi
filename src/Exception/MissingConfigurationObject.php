<?php

namespace Drupal\sapi\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * An exception for when a plugin did not receive expected parameters during
 * construction, in the configuration array.
 */
class MissingConfigurationObject extends BadRequestHttpException {

}