<?php

namespace Drupal\sapi_entity_interaction\EventSubscriber;

use Drupal\sapi_entity_interaction\EntityInteractionCollector;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Routing\CurrentRouteMatch;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class EntityViewEventSubscriber.
 *
 * @package Drupal\sapi_entity_interaction
 */
class EntityViewEventSubscriber implements EventSubscriberInterface {

  /**
   * @constant for what entity interaction "action" is used for view
   */
  const ACTION_VIEW="view";

  /**
   * Drupal\Core\Routing\CurrentRouteMatch definition.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * Drupal\sapi_entity_interaction\
   *
   * @var \Drupal\sapi_entity_interaction\EntityInteractionCollector
   */
  protected $entityInteractionCollector;

  /**
   * Constructor.
   */
  public function __construct(CurrentRouteMatch $currentRouteMatch, EntityInteractionCollector $entityInteractionCollector) {
    $this->currentRouteMatch = $currentRouteMatch;
    $this->entityInteractionCollector = $entityInteractionCollector;
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    // Priority is set to 1 to avoid this listener from being stopped by other
    // listeners.
    // @see ContainerAwareEventDispatcher::dispatch()
    $events[KernelEvents::VIEW][] = ['onEventView', 1];
    return $events;
  }

  /**
   * Pass any entity view routes to the entity interaction collector for
   * dispatching.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent $event
   */
  public function onEventView(Event $event) {
    try {
      if (preg_match('/entity\.([\w]+)\.canonical/',$this->currentRouteMatch->getRouteName(), $matches)) {
        /** @var \Drupal\Core\Entity\EntityInterface $entity */
        $entity = $this->currentRouteMatch->getParameter($matches[1]);

        // pass the interaction to the collector
        $this->entityInteractionCollector->actionTypeTrigger($entity, self::ACTION_VIEW);
      }
    } catch (\Exception $e) {
      watchdog_exception('sapi_entity_interaction', $e);
    }
  }

}
