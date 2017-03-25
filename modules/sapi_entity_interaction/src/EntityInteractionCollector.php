<?php

namespace Drupal\sapi_entity_interaction;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\sapi\ActionTypeInterface;
use Drupal\sapi\Dispatcher;
use Drupal\sapi\ActionTypeManager;

/**
 * Class EntityInteractionCollector.
 *
 * @package Drupal\sapi_entity_interaction
 */
class EntityInteractionCollector {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * Drupal\sapi\Dispatcher definition.
   *
   * @var \Drupal\sapi\Dispatcher
   */
  protected $sapiDispatcher;

  /**
   * Drupal\sapi\ActionTypeManager definition.
   *
   * @var \Drupal\sapi\ActionTypeManager
   */
  protected $sapiActionTypeManager;

  /**
   * EntityInteractionCollector constructor.
   */
  public function __construct(AccountProxy $currentUser, Dispatcher $sapiDispatcher, ActionTypeManager $sapiActionTypeManager) {
    $this->currentUser = $currentUser;
    $this->sapiDispatcher = $sapiDispatcher;
    $this->sapiActionTypeManager = $sapiActionTypeManager;
  }

  /**
   * Initiates Drupal\sapi\ActionType plugin and hands it to dispatcher.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   Current actions entity.
   * @param string $operation
   *   Type of operation made on entity.
   */
  public function actionTypeTrigger(EntityInterface $entity, $operation) {
    $allowed_entities = ['node', 'user', 'comments', 'taxonomy_term'];
    if (!in_array($entity->getEntityTypeId(), $allowed_entities)) {
      return;
    }
    try {
      /** @var \Drupal\sapi\ActionTypeInterface $action */
      $action = $this->sapiActionTypeManager
        ->createInstance('entity_interaction', [
          'context' => [
            'entity' => $entity,
            'action' => $operation,
            'account' => $this->currentUser->getAccount(),
          ],
        ]);
      if (!($action instanceof ActionTypeInterface)) {
        throw new \Exception('No entity_interaction plugin was found');
      }
      $this->sapiDispatcher->dispatch($action);
    }
    catch (\Exception $e) {
      watchdog_exception('sapi_entity_interaction', $e);
    }
  }

}
