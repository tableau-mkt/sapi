<?php

namespace Drupal\sapi_data\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Statistics API Data entry entities.
 */
class SAPIDataViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['sapi_data']['table']['base'] = [
      'field' => 'id',
      'title' => $this->t('Statistics API Data entry'),
      'help' => $this->t('The Statistics API Data entry ID.'),
    ];

    $data['sapi_data']['sapi_data_bulk_form'] = [
      'title' => $this->t('Sapi data operations bulk form'),
      'help' => $this->t('Add a form element that lets you run operations on multiple sapi data.'),
      'field' => [
        'id' => 'sapi_data_bulk_form',
      ],
    ];

    return $data;
  }

}
