<?php

namespace Drupal\sapi\Plugin\Statistics\ActionType;

use Drupal\sapi\ActionTypeBase;
use Drupal\sapi\ActionTypeInterface;

/**
 * Test action type plugin that returns dummy description.
 *
 * @ActionType (
 *   id = "dummy",
 *   label = "Dummy action item",
 *   description = "Dummy action item for testing",
 * )
 *
 * A zero-requirements action plugin that can be used to test if actions are
 * being sent properly to handlers.  You could use this for generic action
 * triggers, but really actions should be more conservative.
 */
class Dummy extends ActionTypeBase implements ActionTypeInterface {

  /**
   * {@inheritdoc}
   */
  public function describe() {
    return '[' . __class__ . '] I am a dummy';
  }

}
