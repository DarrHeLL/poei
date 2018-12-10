<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 10/12/2018
 * Time: 14:41
 */

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a hello block
 *
 * @block(
 *  id = "hello_block",
 *  admin_label = @translation("Hello!")
 * )
 */
class Hello extends BlockBase {
  
  public function build() {
    $dateTime = \Drupal::service('datetime.time')->getCurrentTime();
    $dateFormat = \Drupal::service('date.formatter');
    $date = $dateFormat->format($dateTime, 'custom', $format = "H:i:s", $timezone = NULL, $langcode = NULL);
    
    $markup = $this->t('Welcome to our website. It is %date',
    [
      '%date' => $date
    ]);
    
    $cache = [
      'keys' => ['hello:block'],
      'max-age' => '0'
    ];
    
    $build = [
      '#markup' => $markup,
      '#cache' => $cache
    ];

    return $build;
  }
}