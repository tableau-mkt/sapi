<?php

namespace Drupal\sapi\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\sapi\ConfigurableActionHandlerBase;
use Drupal\sapi\Exception\MissingConfigurationObject;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\sapi\ActionHandlerManager;
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
   * The action handler plugin manager to create sapi plugin instance.
   *
   * @var \Drupal\sapi\ActionHandlerManager
   */
  protected $sapiActionHandlerManager;

  /**
   * Requested plugin id.
   *
   * @var string
   */
  protected $id;

  /**
   * Requested plugin.
   *
   * @var \Drupal\sapi\ConfigurableActionHandlerBase
   */
  protected $instance;

  /**
   * PluginConfigureForm constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   *   Request stack that controls the lifecycle of requests.
   * @param \Drupal\sapi\ActionHandlerManager $sapiActionHandlerManager
   *   Plugin manager to create action handler instances.
   */
  public function __construct(
    RequestStack $requestStack,
    ActionHandlerManager $sapiActionHandlerManager
  ) {
    $this->requestStack = $requestStack;
    $this->sapiActionHandlerManager = $sapiActionHandlerManager;
    $this->id = $requestStack->getCurrentRequest()->get('plugin');
    try {
      $this->instance = $this->sapiActionHandlerManager->createInstance($this->id);
      if (!($this->instance instanceof ConfigurableActionHandlerBase)) {
        throw new PluginNotFoundException($this->id, 'Plugin: "' . $this->id . '" not instance of ConfigurableActionHandlerBase.');
      }
    }
    catch (\Exception $e) {
      \Drupal::logger('default')
        ->error("Error during SAPI plugin configure : " . $e->getMessage());
      if ($e instanceof PluginNotFoundException) {
        throw new NotFoundHttpException($e);
      }
    }
    if (!$this->instance->getConfiguration()) {
      throw new MissingConfigurationObject('Plugin: "' . $this->id . '" configuration object not found.');
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
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save configuration',
      '#button_type' => 'primary',
    ];
    if (!empty($this->instance->defaultConfiguration())) {
      $form['actions']['cancel'] = [
        '#type' => 'submit',
        '#value' => 'Reset to defaults',
        '#button_type' => 'secondary',
        '#name' => 'reset',
      ];
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement validateConfigurationForm() method.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getTriggeringElement()['#name'] == 'reset') {
      $this->instance->resetFormToDefaults();
    }
    else {
      $this->instance->submitConfigurationForm($form, $form_state);
    }

    $form_state->setRedirect('sapi.statistics_plugin_list_form');
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->instance->getTitle();
  }

}
