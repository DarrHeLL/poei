<?php

namespace Drupal\file_from_url\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class FileDownloadController.
 */
class FileDownloadController extends ControllerBase {

  /**
   * Action.
   *
   * @return string
   *   Return Hello string.
   */
  public function action() {
    // On récupère la valeur de la variable d'environement contenant l'id du fichier
    $fid = $this->state()->get('file_from_url_fid');
    
    // On charge du fichier a partir de son ID en utilisant l'entityTypeManager
    $file = $this->entityTypeManager()->getStorage('file')->load($fid[0]);
    
    // On récupère l'adresse du fichier
    $url = $file->get('uri')->getValue()[0]['value'];
    
    // Instanciation de la réponse
    $response = new Response();
    // On ajoute le contenu du fichier dans la réponse
    $response->setContent(file_get_contents($url));
    // Code permettant de dire au navigateur de téléchercher le fichier
    $dispositions = $response->headers->makeDisposition(
      ResponseHeaderBag::DISPOSITION_ATTACHMENT,
      $file->label()
    );
  
    $response->headers->set('Content-Disposition', $dispositions);
  
    // On retourne la réponse
    return $response;
  }

}
