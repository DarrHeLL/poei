<?php

namespace Drupal\file_from_url\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FileUploadForm.
 */
class FileUploadForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'file_upload_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['upload_your_file'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload your file'),
      '#default_value' => \Drupal::state()->get('file_from_url_fid'),
      '#upload_validators' => ['file_validate_extensions' => ['pdf']],
      '#upload_location' => 'public://archives',
      '#required' => TRUE,
      '#weight' => '0',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::state()->set('file_from_url_fid', $form_state->getValue('upload_your_file'));
  }

}
