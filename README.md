# SAPI

The Statistics API Drupal 8 module is intended simplify and centralize event
recording (tracking) and statistical evaluations of events, and to make it easy
to log the data.

The module can be found at http://drupal.org/project/sapi

This repository main branch corresponds to the 3.x module effort, as seen in
drupal.org

## Current status

The core 3.x functionality works well, and is considered reliable, but it quite
abstract, and does little on its own.

## Submodules
The provided submodule sapi_data provides a storage facility to log events to a Drupal
entity.

Other separate contributed modules such as Better Statistics or New Relic Insights
use SAPI to capture and log events.

## Installation

To install the SAPI module into your site, use the typical methods:

- Download the package to modules/contrib/
- Use "composer require drupal/sapi"

### Site admins

- The core module provides administrative pages to enable and disable handler
plugins /admin/config/sapi
- The sapi_data storage custom entity can be configured and managed at
admin/structure/sapi

### Developers

The most common way to extend SAPI is to write action handler plugins for custom
storage of events.

#### Creating new event triggers to send data to be tracked:

1. Use a Drupal hook or EventSubscriber to trigger the event and provide
context.  See the 8.x version of the Better Statistics module for examples of
both.  For front-end events, you can use JavaScript to post data to a Drupal
service callback.
2. Create an ActionType plugin instance, e.g. EntityInteraction.php, using the
ActionTypePluginManager manager.  (For more complex scenarios, custom ActionType
plugins can be created.)
3. Include the SAPI Dispatcher service in scope and pass the action data to the
Dispatcher, which in turn passes the action to all the enabled SAPI handlers.

#### Creating new SAPI handlers

1. Create a new action handler plugin to manipulate the data and send it to a
storage facility.  See ActionFileLogger.php, ActionLogger.php, and
SapiDataHandler.php as examples.
2. Enable the handler at /admin/config/sapi/statistics-plugins.

#### Adding additional fields

1. Additional data can be provided by adding contexts to the triggering hook,
EventSubscriber, or service callback.
2. The contexts are used in the handlers to derive useful data and map the data
to a storage facility, e.g. the SAPI data entity.

#### Store & Retrieve SAPI data

SAPI data is stored using the custom content entity provided in the submodule
"sapi_data". You can interact with this data using any entity tool such as Views.

## Credits
Most of the architectural development of the 8.x version was done by
https://www.drupal.org/u/james-nesbitt and colleagues.

https://www.drupal.org/u/papagrande extended the architecture and prepared the
module for initial release.