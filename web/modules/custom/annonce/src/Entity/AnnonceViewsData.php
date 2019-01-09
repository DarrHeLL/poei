<?php

namespace Drupal\annonce\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Annonce entities.
 */
class AnnonceViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    
    // Ajout des annonces dans le module views
    $data['annonce_views_history']['table']['group'] = t('Annonce History'); // Category des champs filtres etc ... dans views
    $data['annonce_views_history']['table']['provier'] = 'annonce';  // Module qui fournis le schema de la table
    $data['annonce_views_history']['table']['base'] = [
      'field' => 'id',
      'title' => t('Annonce history'), // cela apparait dans le select au niveau de vews
      'help' => t('This table contain the hisotry of viewed adverts.'),
    ];
    
    $data['annonce_views_history']['uid'] = [
      'title' => t('User ID from annonce_views_history table'),
      'help' => t('This is the id of the user who watched an advert from the table annonce_views_history'),
      'field' => [
        'id' => 'numeric',
      ],
      'sort' => [
        'id' => 'numeric',
      ],
      'filter' => [
        'id' => 'numeric',
      ],
      'relationship' => [
        'base' => 'users_field_data',
        'base field' => 'uid',
        'id' => 'standard',
        'label' => t('Relation for annonce_views_history_id table uid to users table uid'),
      ]
    ];
    
    $data['annonce_views_history']['annonce_id'] = [
      'title' => t('Annonce ID from annonce_views_history table'),
      'help' => t('This the id of the advert who have been watched get from the annonce_views_history'),
      'field' => [
        'id' => 'numeric',
      ],
      'sort' => [
        'id' => 'numeric',
      ],
      'filter' => [
        'id' => 'numeric',
      ],
      'relationship' => [
        'base' => 'annonce_field_data',
        'base field' => 'id',
        'id' => 'standard',
        'label' => t('Reltion dor annonce_views_history table annonce_id to annonce id '),
      ]
    ];
    
    $data['annonce_views_history']['time'] = [
      'title' => t('Time Annonce view history'),
      'help' => t('Time when the advert was watched from annonce views history'),
      'field' => [
        'id' => 'date',
      ],
      'sort' => [
        'id' => 'date',
      ],
      'filter' => [
        'id' => 'date',
      ],
    ];

    return $data;
  }

}
