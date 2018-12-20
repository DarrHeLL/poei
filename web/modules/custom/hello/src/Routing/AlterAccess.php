<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 19/12/2018
 * Time: 14:07
 */

namespace Drupal\hello\Routing;


use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class AlterAccess extends RouteSubscriberBase {
  public function alterRoutes(RouteCollection $collection) {
    // On récupère la route concerné (enitity.user.canonical)
    $route = $collection->get('entity.user.canonical');
    $route->addRequirements([
      '_access_check' => '2'
    ]);
  }
}