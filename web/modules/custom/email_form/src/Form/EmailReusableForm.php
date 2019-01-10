<?php

namespace Drupal\email_form\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\reusable_forms\Form\ReusableFormBase;

/**
 * Defines the BasicForm class.
 */
class EmailReusableForm extends ReusableFormBase {
  
  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'email_form';
  }
  
  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Your mail'),
    );
    
    $form = parent::buildForm($form, $form_state);
    
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }
}
