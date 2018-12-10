<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 10/12/2018
 * Time: 11:51
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;


class HelloController extends ControllerBase{
  public function content($param){
    return  [
              '#markup' => $this->t('You are on the hello page. Your username is : %username and this is the parameter given by URL : %param',
              [
                '%username' => $this->currentUser()->getAccountName(),
                '%param' => $param
              ])
            ];
  }
}