<?php

namespace Drupal\sapi\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\sapi\ConfigurableActionHandlerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\sapi\ActionHandlerManager;
use Drupal\Core\Config\ConfigFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;

/**
 * Class PluginConfigureForm.
 *
 * @package Drupal\sapi\Form
 */
class PluginConfigureForm extends FormBase {

  /**
   * Current request.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * The statistics action handler plugin manager which will be used to create
   * sapi plugin instance.
   *
   * @var \Drupal\sapi\ActionHandlerManager
   */
  protected $SapiActionHandlerManager;

  /**
   * ConfigFactory used to store and retrieve plugin configurations.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Requested plugin id.
   *
   * @var String $id
   */
  protected $id;

  /**
   * Requested plugin.
   *
   * @var \Drupal\sapi\ConfigurableActionHandlerBase $instance
   */
  protected $instance;

  /**
   * PluginConfigureForm constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   * @param \Drupal\sapi\ActionHandlerManager $SapiActionHandlerManager
   * @param \Drupal\Core\Config\ConfigFactory $configFactory
   */
  public function __construct(
    RequestStack $requestStack,
    ActionHandlerManager $SapiActionHandlerManager,
    ConfigFactory $configFactory
  ) {
    $this->requestStack = $requestStack;
    $this->SapiActionHandlerManager = $SapiActionHandlerManager;
    $this->configFactory = $configFactory;
    $this->id = $requestStack->getCurrentRequest()->get('plugin');
    try {
      $this->instance = $this->SapiActionHandlerManager->createInstance($this->id);
      if (!($this->instance instanceof ConfigurableActionHandlerBase)){
        throw new PluginNotFoundException('Plugin '.$this->id.' not instance of ConfigurableActionHandlerBase.', $e);
      }
    } catch (\Exception $e) {
      \Drupal::logger('default')
        ->error("Error during SAPI plugin configure : " . $e->getMessage());
      if ($e instanceof PluginNotFoundException) {
        throw new NotFoundHttpException('Plugin '.$this->id.' not found', $e);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('plugin.manager.sapi_action_handler'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'plugin_configure_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form += $this->instance->buildConfigurationForm($form, $form_state);
    return $form;
  }

  /**
   *{@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement validateConfigurationForm() method.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    return $this->instance->submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->instance->getTitle();
  }


}
