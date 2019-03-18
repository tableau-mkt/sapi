<?php

namespace Drupal\sapi\Controller;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\sapi\DispatcherInterface;
use Drupal\sapi\ActionTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class JsActionCaptureController.
 *
 * @package Drupal\sapi
 */
class JsActionCaptureController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Used to retrieve POST variables to create Action data.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Use to receive action items.
   *
   * @var \Drupal\sapi\DispatcherInterface
   */
  protected $sapiDispatcher;

  /**
   * Action type plugin manager used to create sapi items for dispatcher.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $sapiActionTypeManager;

  /**
   * Symfony Container which we may use to convert arguments to services.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $container;

  /**
   * JsActionCaptureController constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   *   Current request.
   * @param \Drupal\sapi\DispatcherInterface $sapiDispatcher
   *   Dispatcher for dispatching actions.
   * @param \Drupal\Component\Plugin\PluginManagerInterface $sapiActionTypeManager
   *   Plugin manager to create action instances.
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Dependency injection container.
   */
  public function __construct(RequestStack $requestStack,
                              DispatcherInterface $sapiDispatcher,
                              PluginManagerInterface $sapiActionTypeManager,
                              ContainerInterface $container) {
    $this->requestStack = $requestStack;
    $this->sapiDispatcher = $sapiDispatcher;
    $this->sapiActionTypeManager = $sapiActionTypeManager;
    $this->container = $container;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('sapi.dispatcher'),
      $container->get('plugin.manager.sapi_action_type'),
      $container
    );
  }

  /**
   * Captures JS action and informs the SAPI service.
   *
   * @param string $action_type
   *   Action type identifier.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Returns response if everything went ok.
   *
   * @throws BadRequestHttpException
   *   If an unknown handler is used.
   * @throws HttpException
   *   If a handler throws an exception.
   */
  public function action($action_type) {

    if (empty($action_type)) {
      throw new BadRequestHttpException('Action Parameter was not defined.');
    }

    // Get current request.
    $request = $this->requestStack->getCurrentRequest();

    // Unknown array of values that should make sense to the action type plugin.
    /** @var [] $configuration */
    $configuration = $request->get('action');

    // Convert any values to services if the value is a string, and it is marked
    // with an @ to denote a service.
    foreach ($configuration as $key => &$value) {
      if (is_string($value) && strlen($value) > 1 && substr($value, 0, 1) == '@') {
        $configuration[$key] = $this->container->get(substr($value, 1), ContainerInterface::NULL_ON_INVALID_REFERENCE);
      }
    }

    // Create new statistics item.
    /** @var \Drupal\sapi\ActionTypeInterface $action */
    $action = $this->sapiActionTypeManager->createInstance($action_type, $configuration);

    if (!($action instanceof ActionTypeInterface)) {
      throw new BadRequestHttpException('Action Parameter does not correspond to any know action type.');
    }

    try {

      // Send to SAPI dispatcher.
      $this->sapiDispatcher->dispatch($action);

      return new Response('OK', 200);
    }
    catch (\Exception $e) {
      throw new HttpException(500, 'Internal Server Error', $e);
    }

  }

}
