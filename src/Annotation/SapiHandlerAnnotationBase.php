<?php

/**
 * @file
 * Contains \Drupal\sapi\Annotation\SapiHandlerAnnotationBase.
 */

namespace Drupal\sapi\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Sapi handler annotation base item annotation object.
 *
 * @see \Drupal\sapi\Plugin\SapiHandlerAnnotationBaseManager
 * @see plugin_api
 *
 * @Annotation
 */
class SapiHandlerAnnotationBase extends Plugin {

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
