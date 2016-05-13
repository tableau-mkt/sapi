SAPI DATA
---------

This module provided a custom content entity, meant for
SAPI plugins to use to record statistical information.

The primary component is a bundles custom content entity.
Any module that creates plugins can create a new bundle and
assign fields to it.  Plugins can then create data entries
by creating entity instances.

## Creating a Data Entry

````
<?php

/** var \Drupal\sapi\SAPIDataInterface $entry */
$entry = \Drupal::service('entity_type.manager')->getStorage('sapi_data')->create(['type'=>'MySAPIDataType']);

$entry->MyField = $value;

$entry->save();

````