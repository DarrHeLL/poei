<?php

namespace Drupal\console_tests\Plugin\ImageEffect;

use Drupal\Core\Image\ImageInterface;
use Drupal\image\ImageEffectBase;

/**
 * Provides a 'ConsoleTestsImageEffect' image effect.
 *
 * @ImageEffect(
 *  id = "console_tests_image_effect",
 *  label = @Translation("Console tests image effect"),
 *  description = @Translation("Console tests blur")
 * )
 */
class ConsoleTestsImageEffect extends ImageEffectBase {

  /**
   * {@inheritdoc}
   */
  public function applyEffect(ImageInterface $image) {
    // Implement Image Effect.
    return imagefilter($image->getToolkit()->getResource(), IMG_FILTER_NEGATE, NULL);
  }

}
