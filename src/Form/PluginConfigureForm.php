<?php

namespace Drupal\sapi\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\sapi\ActionHandlerManager;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Plugin\PluginFormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;

/**
 * Class PluginConfigureForm.
 *
 * @package Drupal\sapi\Form
 */
class PluginConfigureForm extends FormBase {

  /**
   * Symfony\Component\HttpFoundation\RequestStack definition.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $request_stack;

  /**
   * Drupal\sapi\ActionHandlerManager definition.
   *
   * @var \Drupal\sapi\ActionHandlerManager
   */
  protected $plugin_manager_sapi_action_handler;

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $config_factory;
  public function __construct(
    RequestStack $request_stack,
    ActionHandlerManager $plugin_manager_sapi_action_handler,
    ConfigFactory $config_factory
  ) {
    $this->request_stack = $request_stack;
    $this->plugin_manager_sapi_action_handler = $plugin_manager_sapi_action_handler;
    $this->config_factory = $config_factory;
  }

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
    $id = $this->request_stack->getCurrentRequest()->get('plugin');
    $form['#plugin_id'] = $id;
    try {
      /** @var \Drupal\Core\Plugin\PluginFormInterface $instance */
      $instance = $this->plugin_manager_sapi_action_handler->createInstance($id);
      if ($instance instanceof PluginFormInterface){
        $form += $instance->buildConfigurationForm($form, $form_state);
      }
    } catch (\Exception $e) {
      \Drupal::logger('default')
        ->error("Error during SAPI plugin configure : " . $e->getMessage());
      if ($e instanceof PluginNotFoundException) {
        throw new NotFoundHttpException('Plugin '.$id.' not found', $e);
      }
    }
    return $form;
  }

  /**
   *{@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    // TODO: Call plugin form validation;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Call plugin form submit;
  }


}
