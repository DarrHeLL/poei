<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 19/12/2018
 * Time: 10:28
 */

namespace Drupal\hello\Access;

use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

class AccessCheck implements AccessCheckInterface {
  
  public function applies(Route $route) {
    return NULL;
  }
  
  public function access(Route $route, Request $request = NULL, AccountInterface $account){
    $time_to_access = time() - $route->getRequirement('_access_check') * 3600;
    
    // On vérifis que l'user n'est pas anonyme sinon on refuse l'access
    if($account->isAnonymous()){
      $access = FALSE;
    }else{
      // Le user n'est pas anonyme on check la condition sur la date de création
      $account_created = $account->getAccount()->created;
  
      // Pour autoriser l'access, le timestamp du compte doit être inférieur au timestamp de test
      if($account_created < $time_to_access){
        $access = TRUE;
      }else{
        $access = FALSE;
      }
    }
    
    return AccessResult::allowedIf($access)->cachePerUser();
  }
}