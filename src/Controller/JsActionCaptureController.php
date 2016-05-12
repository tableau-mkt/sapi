<?php

namespace Drupal\sapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\sapi\SapiDispatcherInterface;
use Drupal\sapi\StatisticsItem;
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

  /** @var \Symfony\Component\HttpFoundation\RequestStack $requestStack */
  protected $requestStack;
  /** @var \Drupal\sapi\SapiDispatcherInterface $sapiDispatcher */
  protected $sapiDispatcher;

  /**
   * JsActionCaptureController constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   * @param \Drupal\sapi\SapiDispatcherInterface $sapiDispatcher
   */
  public function __construct(RequestStack $requestStack, SapiDispatcherInterface $sapiDispatcher) {
    $this->requestStack = $requestStack;
    $this->sapiDispatcher = $sapiDispatcher;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('sapi.dispatcher')
    );
  }

  /**
   * Captures JS action and informs the SAPI service.
   *
   * @return string
   */
  public function capture() {
    // Get current request.
    $request = $this->requestStack->getCurrentRequest();

    // Get params.
    $action = $request->get('action');
    $uri = $request->get('uri');

    if (!empty($action) && !empty($uri)) {
      try {
        // Create new statistics item.
        $item = new StatisticsItem($action, $uri);
        // Send to SAPI dispatcher.
        $this->sapiDispatcher->dispatch($item);

        return new Response('OK', 200);
      } catch (\Exception $e) {
        throw new HttpException(500, 'Internal Server Error', $e);
      }
    }
    else {
      throw new BadRequestHttpException('Parameter is missing.');
    }
  }

}
