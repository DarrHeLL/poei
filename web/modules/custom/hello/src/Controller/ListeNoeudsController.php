<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 11/12/2018
 * Time: 13:59
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class ListeNoeudsController extends ControllerBase{
  public function getNodeByType($nodeType){
    $storage = $this->entityTypeManager()->getStorage('node');
    
    $query = $storage->getQuery();
    
    if($nodeType == "all"){
      $result = $query->pager(20)->execute();
    }else{
      $result = $query->condition('type', $nodeType)->pager(20)->execute();
    }
    
    $nodes = $storage->loadMultiple($result);
    
    $items = [];
    foreach($nodes as $node){
      $items[] = $node->toLink();
    }
    
    $list = [
      '#theme' => 'item_list',
      '#items' => $items,
      '#titile' => $this->t('Node list')
    ];
    
    $pager = ['#type' => 'pager'];
    
    $build = [
      'list' => $list,
      'pager' => $pager,
      '#cache' => [
        'keys' => ['hello:node_list'],
        'tag' => ['node_list', 'node_type_list'],
        'contexts' => ['url'],
      ]
    ];
    
    return $build;
  }
}