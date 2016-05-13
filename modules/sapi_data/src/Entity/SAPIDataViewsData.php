<?php

namespace Drupal\sapi_data\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for SAPI Data entry entities.
 */
class SAPIDataViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['sapi_data']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('SAPI Data entry'),
      'help' => $this->t('The SAPI Data entry ID.'),
    );

    return $data;
  }

}
