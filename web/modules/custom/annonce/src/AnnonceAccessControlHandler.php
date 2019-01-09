<?php

namespace Drupal\annonce;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Annonce entity.
 *
 * @see \Drupal\annonce\Entity\Annonce.
 */
class AnnonceAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\annonce\Entity\AnnonceInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished annonce entities')->addCacheableDependency($entity);
        }
  
        // On test si l'user à la permission utlime sur le module
        if($account->hasPermission('administer annonce entities')){
          return AccessResult::allowed()->cachePerUser();
        }
        
        return AccessResult::allowedIfHasPermission($account, 'view published annonce entities')->cachePerUser();

      case 'update':
        // Permission de modification pour le propriétaire
        if($entity->getOwnerId() == $account->id())
        {
          return AccessResult::allowedIfHasPermission($account, 'edit own annonce entities')->cachePerUser();
        }
        
        // On test si l'user à la permission utlime sur le module
        if($account->hasPermission('administer annonce entities')){
          return AccessResult::allowed()->cachePerUser();
        }
        
        // On regarde sinon si l'utilisateur à la permission d'édition
        return AccessResult::allowedIfHasPermission($account, 'edit annonce entities')->cachePerUser();

      case 'delete':
        // Droit de suppression si il est le propriétaire de l'annonce
        if($entity->getOwnerId() == $account->id()){
          return AccessResult::allowedIfHasPermission($account, 'delete own annonce entities')->cachePerUser();
        }
  
        // On test si l'user à la permission utlime sur le module
        if($account->hasPermission('administer annonce entities')){
          return AccessResult::allowed()->cachePerUser();
        }
        
        // Sinon si l'account à le droit de supprimer l'annonce
        return AccessResult::allowedIfHasPermission($account, 'delete annonce entities')->cachePerUser();
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral()->cachePerUser();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add annonce entities');
  }

}
