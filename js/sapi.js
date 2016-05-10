/**
 * @file
 * JavaScript library for the Statistics API (sapi) module.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * @namespace
   */
  Drupal.sapi = {

    /**
     * Records the action on the URL.
     *
     * @param {string} url
     * @param {string} action
     */
    record: function(url, action) {
      $.ajax({
        url: Drupal.url('sapi/js/store'),
        type: 'POST',
        data: {
          'url': url,
          'action': action
        },
        dataType: 'json',
        success: function() {},
        error: function() {}
      });
    }

  };

})(jQuery, Drupal, drupalSettings);
