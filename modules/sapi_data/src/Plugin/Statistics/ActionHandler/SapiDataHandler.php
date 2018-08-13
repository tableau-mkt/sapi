<?php

namespace Drupal\sapi_data\Plugin\Statistics\ActionHandler;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\sapi\ConfigurableActionHandlerBase;
use Drupal\sapi\ActionTypeInterface;
use Drupal\sapi\Plugin\Statistics\ActionType\EntityInteraction;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\Role;

/**
 * Action handler to track any entity interactions (view, update and create).
 *
 * @ActionHandler(
 *  id = "sapi_data_handler",
 *  label = "SAPI Data Handler",
 *  description = "Track entity interactions"
 * )
 */
class SapiDataHandler extends ConfigurableActionHandlerBase implements ContainerFactoryPluginInterface {

  /**
   * EntityTypeManager used to create and edit sapi_data items from tracking.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * EntityInteractionTracker constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Config factory required by ConfigurableActionHandlerBase.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   EntityTypeManager to load sapi data items.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory, EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $configFactory);

    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,

      $container->get('config.factory'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function process(ActionTypeInterface $action) {

    // Only acts if $action is an EntityInteraction plugin type.
    if (!($action instanceof EntityInteraction) ||
      empty(array_intersect($action->getAccount()->getRoles(), $this->configuration['roles']))) {
      return;
    }

    /** @var string $entity_type */
    $entity_type = $action->getEntity()->getEntityTypeId();

    /** @var string $entity_id */
    $entity_id = $action->getEntity()->id();

    /** @var string $interaction_type */
    $interaction_type = $action->getAction();

    /** @var string $user_id */
    $user_id = $action->getAccount()->id();

    /** @var \Drupal\Core\Entity\EntityStorageInterface $sapiDataStorage */
    $sapiDataStorage = $this->entityTypeManager->getStorage('sapi_data');

    // Creating a new interaction entity.
    /** @var \Drupal\sapi_data\SAPIDataInterface $sapiData */
    $sapiData = $sapiDataStorage->create([
      'type' => 'entity_interactions',
      'name' => $entity_type . ':' . $entity_id . ':' . $interaction_type,
      'field_interaction_type' => $interaction_type,
      'field_entity_reference' => ['target_id' => $entity_id, 'target_type' => $entity_type],
      'field_entity_user' => $user_id,
    ]);

    if (!$sapiData->save()) {
      \Drupal::logger('sapi')->warning('Could not create SAPI data');
    }

  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'roles' => ['authenticated'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    /** @var array $all_roles */
    $all_roles = [];
    foreach (Role::loadMultiple() as $role) {
      /** @var \Drupal\user\Entity\Role $role */
      $all_roles[$role->id()] = $role->label();
    }
    $form['roles'] = [
      '#type' => 'checkboxes',
      '#title' => 'Tracked roles',
      '#description' => 'User roles to track.',
      '#options' => $all_roles,
      '#default_value' => $this->configuration['roles'],
    ];

    return $form;
  }

}
