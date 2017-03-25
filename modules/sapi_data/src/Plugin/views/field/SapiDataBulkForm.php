<?php

namespace Drupal\sapi_data\Plugin\views\field;

use Drupal\system\Plugin\views\field\BulkForm;

/**
 * Defines a node operations bulk form element.
 *
 * @ViewsField("sapi_data_bulk_form")
 */
class SapiDataBulkForm extends BulkForm {

  /**
   * {@inheritdoc}
   */
  protected function emptySelectedMessage() {
    return $this->t('No content selected.');
  }

}
