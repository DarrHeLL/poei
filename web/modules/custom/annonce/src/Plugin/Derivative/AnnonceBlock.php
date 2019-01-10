<?php

namespace Drupal\annonce\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AnnonceBlock extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The annonce storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $annonceStorage;

  /**
   * AnnonceBlock constructor.
   *
   * @param EntityStorageInterface $annonce_storage
   */
  public function __construct(EntityStorageInterface $annonce_storage) {
    $this->annonceStorage = $annonce_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('entity_type.manager')->getStorage('annonce')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    foreach ($this->annonceStorage->loadMultiple() as $id => $entity) {
      $this->derivatives[$id] = $base_plugin_definition;
      $this->derivatives[$id]['admin_label'] = $entity->label();
    }
    return $this->derivatives;
  }

}
