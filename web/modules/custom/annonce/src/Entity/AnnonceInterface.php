<?php

namespace Drupal\annonce\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Annonce entities.
 *
 * @ingroup annonce
 */
interface AnnonceInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Annonce name.
   *
   * @return string
   *   Name of the Annonce.
   */
  public function getName();

  /**
   * Sets the Annonce name.
   *
   * @param string $name
   *   The Annonce name.
   *
   * @return \Drupal\annonce\Entity\AnnonceInterface
   *   The called Annonce entity.
   */
  public function setName($name);

  /**
   * Gets the Annonce creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Annonce.
   */
  public function getCreatedTime();

  /**
   * Sets the Annonce creation timestamp.
   *
   * @param int $timestamp
   *   The Annonce creation timestamp.
   *
   * @return \Drupal\annonce\Entity\AnnonceInterface
   *   The called Annonce entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Annonce published status indicator.
   *
   * Unpublished Annonce are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Annonce is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Annonce.
   *
   * @param bool $published
   *   TRUE to set this Annonce to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\annonce\Entity\AnnonceInterface
   *   The called Annonce entity.
   */
  public function setPublished($published);

  /**
   * Gets the Annonce revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Annonce revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\annonce\Entity\AnnonceInterface
   *   The called Annonce entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Annonce revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Annonce revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\annonce\Entity\AnnonceInterface
   *   The called Annonce entity.
   */
  public function setRevisionUserId($uid);

}
