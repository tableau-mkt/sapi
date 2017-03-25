# SAPI

The statistics API Drupal 8 module is intended simplify and centralize event 
recording (tracking) and statistical evaluations of events, and to make it easy
to feed that data back into Drupal 

The module can be found at http://drupal.org/project/sapi

This repository main branch corresponds to the 3.x module effort, as seen in
drupal.org 

Consider also checking out our demo SAPI extension module: 
https://github.com/james-nesbitt/sapi-demo

## Current status

The core 3.x functionality works well, and is considered reliable, but it quite
abstract, and does little on it's own.

The submodule: sapi_entity_interaction effectively tracks all user interactions
 with entities, which can be used to
 build views based on those interactions (some demo views exaist already in the
  module)

###Incoming modules:

#### sapi_user_journey

Track a user's journey from page to page of your site, to see what navigation
 is commin, and what elements are not used.

## to use

To install the sapi module into your site, use the typical process:

- download the package to modules/contrib/
- use composer require

### Site admins

- The core moduile provides some administrative pages to enable and disable
 handler plugins /admin/config/sapi
- The data storage custom entitiy can be confiugred and managed at
 admin/strucutre/sapi

### developers

The most common ay to extend sapi is to write handcler plugins, and triggers

#### white a new trigger when you want to send data to be tracked:

1. write come custom code wherever you want to start a trigger
2. incllude the dispatcher service in scope
3. include the ActionTypePluginManager in scope
3. create an  action (ActionType plugin) instance using the plugin manager
4. dispatch the action using the dispatcher

* choose with actiontype plugin you want to use, based on whhat data you need
 to send.  Perhaps you will need to
 creata a new plugin.

#### handle a SAPI event with a new response

1. create a new handler plugin

#### store/retriecve SAPI data

SAPI data is typically stored using the custom content entity provided in
 the submodule "sapi_data".
You can interact with this data using any entity applications such as views.

## TO join us

Come and visit out Trello board: https://trello.com/b/fiBWGqdo/sapi2
