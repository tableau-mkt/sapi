<?php

namespace Drupal\sapi_data;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining SAPI Data entry entities.
 *
 * @ingroup sapi_data
 */
interface SAPIDataInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.
  /**
   * Gets the SAPI Data entry type.
   *
   * @return string
   *   The SAPI Data entry type.
   */
  public function getType();

  /**
   * Gets the SAPI Data entry name.
   *
   * @return string
   *   Name of the SAPI Data entry.
   */
  public function getName();

  /**
   * Sets the SAPI Data entry name.
   *
   * @param string $name
   *   The SAPI Data entry name.
   *
   * @return \Drupal\sapi_data\SAPIDataInterface
   *   The called SAPI Data entry entity.
   */
  public function setName($name);

  /**
   * Gets the SAPI Data entry creation timestamp.
   *
   * @return int
   *   Creation timestamp of the SAPI Data entry.
   */
  public function getCreatedTime();

  /**
   * Sets the SAPI Data entry creation timestamp.
   *
   * @param int $timestamp
   *   The SAPI Data entry creation timestamp.
   *
   * @return \Drupal\sapi_data\SAPIDataInterface
   *   The called SAPI Data entry entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the SAPI Data entry published status indicator.
   *
   * Unpublished SAPI Data entry are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the SAPI Data entry is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a SAPI Data entry.
   *
   * @param bool $published
   *   TRUE to set this SAPI Data entry to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\sapi_data\SAPIDataInterface
   *   The called SAPI Data entry entity.
   */
  public function setPublished($published);

}
