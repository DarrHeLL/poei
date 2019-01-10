<?php

namespace Drupal\annonce\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block for each annonce.
 *
 * @Block(
 *   id = "annonce_block",
 *   admin_label = @Translation("Annonce block"),
 *   category = @Translation("Annonce"),
 *   deriver = "Drupal\annonce\Plugin\Derivative\AnnonceBlock"
 * )
 */
class AnnonceBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity view builder.
   *
   * @var \Drupal\Core\Entity\EntityViewBuilderInterface
   */
  protected $viewBuilder;

  /**
   * The derivative annonce entity.
   *
   * @var \Drupal\annonce\Entity\AnnonceInterface
   */
  private $annonce;

  /**
   * Constructs a new AnnonceBlock instance.
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
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->viewBuilder = $entity_type_manager->getViewBuilder('annonce');
    $this->annonce = $entity_type_manager->getStorage('annonce')->load($this->getDerivativeId());
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $images = $this->annonce->get('field_images');

    // Solution 1: on utilise un tableau d'options pour configurer l'affichage du champ.
    //$build['content'] = $this->viewBuilder->viewField($images, [
    //  'label' => 'hidden',
    //  'settings' => [
    //    'image_style' => 'large',
    //    'image_link' => 'content',
    //  ],
    //]);

    // Solution 2: on utilise un mode d'affichage.
    $build['content'] = $this->viewBuilder->viewField($images, 'teaser');

    // Le cache doit être invalidé si l'annonce ou la configuration du mode d'affichage est modifiée.
    $build['#cache'] = [
      'keys' => ['block:annonce:' . $this->annonce->id()],
      'tags' => Cache::mergeTags($this->annonce->getCacheTags(), $this->viewBuilder->getCacheTags()),
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return $this->annonce->access('view', $account, TRUE);
  }

}
