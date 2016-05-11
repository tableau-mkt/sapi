/**
 * @file
 * JavaScript library for the Statistics API (sapi) module.
 */

(function ($, Drupal) {

  'use strict';

  /**
   * @namespace
   */
  Drupal.sapi = {

    /**
     * Sends the action on the URI.
     *
     * @param {string} action
     * @param {string} uri
     * @param {Object} options
     */
    send: function(action, uri, options) {
      options = $.extend({
        'completeCallback': function(){},
        'successCallback': function(){},
        'errorCallback': function(){}
      }, typeof options === 'object' ? options : {});

      $.ajax({
        url: Drupal.url('sapi/js/capture'),
        type: 'POST',
        data: {
          'action': action,
          'uri': uri
        },
        dataType: 'json',
        timeout: 2000,
        complete: options.completeCallback,
        success: options.successCallback,
        error: options.errorCallback
      });
    }

  };

})(jQuery, Drupal);
