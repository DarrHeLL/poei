<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 03/01/2019
 * Time: 15:16
 */

namespace Drupal\config_override;


use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\StorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxyInterface;

class Overrider implements ConfigFactoryOverrideInterface {
  protected $current_user;
  
  public function __construct(AccountProxyInterface $current_user) {
    $this->current_user = $current_user;
  }
  
  public function loadOverrides($names) {

    if(in_array('system.site', $names)) {
      $names['system.site']['name'] = 'Development ANON';
      if($this->current_user->isAuthenticated()){
        $names['system.site']['name'] = 'Development AUTH';
      }
    }
    return $names;
  }
  
  public function getCacheSuffix() {
    // TODO: Implement getCacheSuffix() method.
  }
  
  public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
    // TODO: Implement createConfigObject() method.
  }
  
  public function getCacheableMetadata($name) {
    // TODO: Implement getCacheableMetadata() method.
  }
  
}