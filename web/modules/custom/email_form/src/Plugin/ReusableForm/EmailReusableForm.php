<?php

namespace Drupal\email_form\Plugin\ReusableForm;

use Drupal\reusable_forms\ReusableFormPluginBase;

/**
 * Provides a basic form.
 *
 * @ReusableForm(
 *   id = "email_form",
 *   name = @Translation("Email Form"),
 *   form = "Drupal\email_form\Form\EmailReusableForm"
 * )
 */
class EmailReusableForm extends ReusableFormPluginBase {
  
}