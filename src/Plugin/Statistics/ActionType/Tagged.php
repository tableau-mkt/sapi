<?php

namespace Drupal\sapi\Plugin\Statistics\ActionType;

use Drupal\sapi\ActionTypeBase;
use Drupal\sapi\ActionTypeInterface;

/**
 * @ActionType (
 *   id = "tagged",
 *   label = "Tagged action item",
 *   context = {
 *     "tag" = @ContextDefinition("string", label = @Translation("Tags"), multiple = true)
 *   }
 * )
 *
 * A taggeable action type, where a handler can compare tags to determine if
 * it should process.  This action type holds no data other than the tag.
 *
 * This is a fallback action that you can use, to easily tie a trigger to a
 * handler, as you can assign any tag when the action is created, and any
 * handler can easily try to match it as a test when running.
 *
 */
class Tagged extends ActionTypeBase implements ActionTypeInterface {

  /**
   * {@inheritdoc}
   */
  public function describe() {
    return '['.__class__.'] I am tagged with: '. implode(', ',$this->tags());
  }

  /**
   * Return a boolean if the passed tag has been assigned to this plugin
   *
   * @param string $tag
   *   A string tag to try to match to the plugin tags
   * @return boolean
   *   true if the tag parameter was found in the tag array
   */
  function hasTag($tag) {
    return in_array($tag, $this->tags());
  }

  /**
   * Retrieve all of the tags
   *
   * @return string[]
   *   array of string tag values
   */
  function tags() {
    $tags = $this->getContextValue('tag');
    return is_array($tags) ? $tags : [];
  }
}