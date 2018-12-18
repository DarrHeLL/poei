<?php
/**
 * Created by PhpStorm.
 * User: POE1
 * Date: 17/12/2018
 * Time: 09:44
 */

namespace Drupal\hello\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CalculatorForm extends FormBase {
  /**
   * @inheritdoc
   */
  public function getFormID() {
    return 'calculator_form';
  }
  
  /**
   * @inheritdoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // On regarde si la variable de retour existe
    if(isset($form_state->getRebuildInfo()['resultat'])){
      $form['resultat'] = [
        '#type' => 'markup',
        '#markup' => $this->t('The result id : %resultat', [
          '%resultat' => $form_state->getRebuildInfo()['resultat']
        ])
      ];
    }
    
    
    // Input text to fill the first value
    $form['first_value'] = [
      '#type' => 'textfield',
      '#title' => 'First value',
      '#required' => 'TRUE',
      '#description' => 'Enter the first value',
      '#ajax' => [
        'callback' => [$this, 'validateTextAjax'],
        'event' => 'change'
      ],
      '#suffix' => '<span class="first_value_response"></span>'
    ];
    
    $form['operation'] = [
      '#type' => 'radios',
      '#title' => 'Operations',
      '#required' => 'TRUE',
      '#options' => [
        '+' => 'Add',
        '-' => 'Soustract',
        '*' => 'Multiply',
        '/' => 'Divide'
      ],
      '#description' => 'Choose an operation to process'
    ];
    
    $form['second_value'] = [
      '#type' => 'textfield',
      '#title' => 'Second value',
      '#required' => 'TRUE',
      '#description' => 'Enter the second value',
      '#ajax' => [
        'callback' => [$this, 'validateTextAjax'],
        'event' => 'change'
      ],
      '#suffix' => '<span class="second_value_response"></span>'
    ];
    
    $form['form_submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Calculate')
    ];
    
    return $form;
  }
  
  /**
   * @inheritdoc
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // On regarde si first value est bien numérique
    $first_value = $form_state->getValue('first_value');
    if(!is_numeric($first_value)){
      $form_state->setErrorByName('first_value', 'First value must be a numeric');
    }
    
    // on regarde si la deuxième valeur est bien numérique
    $second_value = $form_state->getValue('second_value');
    if(!is_numeric($second_value)){
      $form_state->setErrorByName('second_value', 'Second value must be a numeric');
    }
    
    // Si l'opération est une division on évite que la valeur 2 soit 0
    $operation = $form_state->getValue('operation');
    if($operation == '/' && $second_value == '0'){
      $form_state->setErrorByName('operation', "You can't divide by 0");
    }
    
    //Flush du résultat
    unset($form['resultat']);
  }
  
  /**
   * @inheritdoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $operation = $form_state->getValue('operation');
    $first_value = $form_state->getValue('first_value');
    $second_value = $form_state->getValue('second_value');
    $resultat = '';
    
    switch($operation){
      case '+':
        $resultat = $first_value + $second_value;
      break;
      
      case '-':
        $resultat = $first_value - $second_value;
      break;
      
      case '*':
        $resultat = $first_value * $second_value;
      break;
      
      case '/':
        $resultat = $first_value / $second_value;
      break;
    }
    
    drupal_set_message($resultat);
    
    $form_state->addRebuildInfo('resultat', $resultat);
    
    $form_state->setRebuild();
    
    // Ajout du timestamp courrant dans state lors de la soumission du formulaire
    $state = \Drupal::state();
    $state->set('hello_submit_CalcutorForm_time', time());
  }
  
  public function validateTextAjax(&$form, FormStateInterface $form_state){
    // On récupère l'élément en cour
    $element = $form_state->getTriggeringElement();
    
    $css = ['border' => '2px dashed green'];
    $message = 'The field value is : ' . $element['#value'];
    
    $response = new AjaxResponse();
    $response->addCommand(new CssCommand($element['#id'], $css));
    $response->addCommand(new HtmlCommand('.' . $element['#name'].'_response', $message));
    
    return $response;
  }
}