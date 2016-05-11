<?php

/**
 * @file
 * Contains \Drupal\sapi\Annotation\SapiHandlerAnnotation.
 */

namespace Drupal\sapi\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Sapi handler annotation item annotation object.
 *
 * @see \Drupal\sapi\Plugin\SapiHandlerAnnotationManager
 * @see plugin_api
 *
 * @Annotation
 */
class SapiHandlerAnnotation extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
