<?php

namespace Drupal\sapi\Plugin\Statistics\ActionType;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\sapi\ActionTypeBase;

/**
 * EntityInteraction action type that defines actions on any entity.
 *
 * @ActionType(
 *  id = "entity_interaction",
 *  label = "Entity Interaction",
 *  description = "An interaction with an entity occurred",
 *  context = {
 *     "action" = @ContextDefinition("string", label = @Translation("Tags")),
 *     "entity" = @ContextDefinition("entity", label = @Translation("Entity") ),
 *     "account" = @ContextDefinition("any", label = @Translation("Entity") )
 *  }
 * )
 *
 * This actiontype holds information about an account interaction with an
 * entity, and keeps the entity, the account, and a string interaction type
 * value, which can be retrieved by any handler.
 *
 * To Create pass
 *  $configuration = [
 *    'context' => [
 *      'entity' => \Drupal\Core\Entity\EntityInterface
 *      'account' => \Drupal\Core\Session\AccountProxyInterface
 *      'action' => string
 *    ]
 *  ];
 *
 */
class EntityInteraction extends ActionTypeBase {

  /**
   * {@inheritdoc}
   */
  public function describe() {
    return 'Entity event: [entity:' . (($this->getEntity() instanceof EntityInterface) ? $this->getEntity()->label() . '(' . $this->getEntity()->id() . ')' : 'none') . '][account:' . (($this->getAccount() instanceof AccountProxyInterface) ? $this->getAccount()->getDisplayName() . '(' . $this->getAccount()->id() . ')' : 'none') . '][action:' . $this->getAction() . ']';
  }

}
