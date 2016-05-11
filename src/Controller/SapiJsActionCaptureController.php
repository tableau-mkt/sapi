<?php

namespace Drupal\sapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class SapiJsActionCaptureController.
 *
 * @package Drupal\sapi
 */
class SapiJsActionCaptureController extends ControllerBase implements ContainerInjectionInterface {

  /** @var \Symfony\Component\HttpFoundation\RequestStack $requestStack */
  protected $requestStack;

  /**
   * SapiJsActionCaptureController constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   */
  public function __construct(RequestStack $request_stack) {
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack')
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
        // @todo Call the service.
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
