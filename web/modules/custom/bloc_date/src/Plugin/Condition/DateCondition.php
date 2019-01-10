<?php

namespace Drupal\bloc_date\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Provides a 'Start and end dates' condition to enable a condition based in module selected status.
*
* @Condition(
*   id = "date_condition",
*   label = @Translation("Start and end dates")
* )
*
*/
class DateCondition extends ConditionPluginBase {

  /**
  * {@inheritdoc}
  */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
    $configuration,
    $plugin_id,
    $plugin_definition
    );
  }
  
  /**
   * Creates a new DateCondition object.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }
  
  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['start_date'] = [
      '#title' => $this->t('Start date'),
      '#type' => 'date',
      '#default_value' => $this->configuration['start_date'],
    ];
    
    $form['end_date'] = [
      '#title' => $this->t('End date'),
      '#type' => 'date',
      '#default_value' => $this->configuration['end_date'],
    ];
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['start_date'] = $form_state->getValue('start_date');
    $this->configuration['end_date'] = $form_state->getValue('end_date');

    parent::submitConfigurationForm($form, $form_state);
  }
  
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'start_date' => '',
      'end_date' => '',
    ] + parent::defaultConfiguration();
  }
  
  /**
  * Evaluates the condition and returns TRUE or FALSE accordingly.
  *
  * @return bool
  *   TRUE if the condition has been met, FALSE otherwise.
  */
  public function evaluate() {
    $today = new DrupalDateTime('today');
    $start_date = $this->configuration['start_date'] ? new DrupalDateTime($this->configuration['start_date']) : NULL;
    $end_date = $this->configuration['end_date'] ? new DrupalDateTime($this->configuration['end_date']) : NULL;
    
    return(!$start_date || ($start_date <= $today)) && (!$end_date || $end_date >= $today);
  }
  
  /**
  * Provides a human readable summary of the condition's configuration.
  */
  public function summary()
  {
    return t('Date bloc condition');
  }

}
