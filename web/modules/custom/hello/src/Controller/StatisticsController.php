<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 12/12/2018
 * Time: 14:53
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\UserInterface;

class StatisticsController extends ControllerBase{
  public function getUserStatistics(UserInterface $user){
    // Appel des services
    $dateFormat = \Drupal::service('date.formatter');
    
    // récupération du contenu de la table hello_user_statistics
    $database = \Drupal::database();
    $statistics = $database->select('hello_user_statistics', 'hus')->fields('hus', [])->condition('uid', $user->id())->execute();
    $rows = [];
    
    foreach($statistics as $statistic){
      if($statistic->action == 0){
        $action = 'Logged out';
      }else{
        $action = 'Logged in';
      }
      $rows[] = [
        $action,
        $dateFormat->format($statistic->time)
      ];
    }
    
    $table = [
      '#theme' => 'table',
      '#header' =>[
        'Action',
        'Time'
      ],
      '#rows' => $rows
    ];
    
    $build = [
      'table' => $table,
    ];
    
    return $build;
  }
}
