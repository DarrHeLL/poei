<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 11/12/2018
 * Time: 11:36
 */

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a session block
 *
 * @block(
 *  id = "session_block",
 *  admin_label = @translation("Session Block")
 * )
 */
class Session extends BlockBase {
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access hello');
  }
  
  public function build() {
    $database = \Drupal::database();
    $nbSession = $database->select('sessions', 's')
                          ->countQuery()
                          ->execute()
                          ->fetchField();
    
    $markup = $this->t('Their is %nbSession active sessions',
      [
        '%nbSession' => $nbSession
      ]);

    $cache = [
      'keys' => ['session:block'],
      'max-age' => '0'
    ];

    $build = [
      '#markup' => $markup,
      '#cache' => $cache
    ];

    return $build;
  }
}