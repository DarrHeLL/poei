<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 17/12/2018
 * Time: 16:43
 */

namespace Drupal\hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class HelloAdminForm extends ConfigFormBase {
  public function getFormId() {
    return 'admin_hello_form';
  }
  
  protected function getEditableConfigNames() {
    return ['hello.settings'];
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    $purge_days_number = $this->config('hello.settings')->get('purge_days_number');

    $form['purge_days_number'] = [
      '#type' => 'select',
      '#title' => 'How many time user statistics are keeped',
      '#options' => [
        '0' => 'Never expire',
        '1' => '1 Day',
        '2' => '2 Days',
        '7' => '7 Days',
        '14' => '14 Days',
        '30' => '1 month'
      ],
      '#default_value' => $purge_days_number,
    ];
    return parent::buildForm($form, $form_state);
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // On enregistre la valeur sélectionnée
    $this->config('hello.settings')->set('purge_days_number', $form_state->getValue('purge_days_number'))->save();
    
    parent::submitForm($form, $form_state);
  }
}
