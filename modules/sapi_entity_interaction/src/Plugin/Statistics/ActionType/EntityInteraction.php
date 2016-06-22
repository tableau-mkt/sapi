<?php
namespace Drupal\sapi_entity_interaction\Plugin\Statistics\ActionType;

use Drupal\Core\Annotation\ContextDefinition;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\sapi\ActionTypeBase;
use Drupal\sapi\Annotation\ActionType;

/**
 * @ActionType(
 *  id = "entity_interaction",
 *  label = "An interaction with an entity occurred",
 *  context = {
 *     "action" = @ContextDefinition("string", label = @Translation("Tags")),
 *     "mode" = @ContextDefinition("string", label = @Translation("Mode"), required = FALSE),
 *     "entity" = @ContextDefinition("entity", label = @Translation("Entity") ),
 *     "account" = @ContextDefinition("any", label = @Translation("Entity") ),
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
 * @TODO should we pass \Drupal\user\UserInterface instead of AccountProxy? it would give us a better context
 */
class EntityInteraction extends ActionTypeBase {

  /**
   * {@inheritdoc}
   */
  public function describe() {
    return 'Entity event: [entity:'.(($this->getEntity() instanceof EntityInterface)?$this->getEntity()->label().'('.$this->getEntity()->id().')':'none').'][account:'.(($this->getAccount() instanceof AccountProxyInterface)?$this->getAccount()->getDisplayName().'('.$this->getAccount()->id().')':'none').'][action:'.$this->getAction().']';
  }

  /**
   * Get the action performed on the entity
   *
   * @return string action
   */
  function getAction() {
    return $this->getContextValue('action');
  }
  /**
   * Get the entity acted on
   *
   * @return \Drupal\Core\Entity\EntityInterface
   */
  function getEntity() {
    return $this->getContextValue('entity');
  }

  /**
   * Get the account who performed the action
   *
   * @return \Drupal\Core\Session\AccountProxyInterface|null
   */
  function getAccount() {
    return $this->getContextValue('account');
  }

}