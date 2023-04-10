<?php

namespace BigPopcorn\Controllers;

use BigPopcorn\Access\Services\PublicationService;
use BigPopcorn\Models\Records\Publication;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PublicationController extends BaseController {
  private $publicationService;

  public function __construct(PublicationService $publicationService, Twig $twig) {
    parent::__construct($twig);
    $this->publicationService = $publicationService;
  }

  public function viewPublication(Request $request, Response $response, $args): Response {
    $publication_id = $args['id'];
    $publication = $this->publicationService->getPublicationById($publication_id);

    if ($publication == null) {
      return $response->withStatus(404);
    }

    $this->renderView('publication.php', ['publication' => $publication]);
  }

  public function createPublication(Request $request, Response $response, $args): Response {
    $body = $request->getParsedBody();
    $publication = Publication::fromArray($body);
    $created_publication = $this->publicationService->createPublication($publication);
    return $response->withJson($created_publication, 201);
  }

  public function getPublication(Request $request, Response $response, $args): Response {
    $publication_id = $args['id'];
    $publication = $this->publicationService->getPublicationById($publication_id);

    if ($publication == null) {
      return $response->withStatus(404);
    }

    return $response->withJson($publication);
  }

  public function getPublicationsByTitle(Request $request, Response $response, $args): Response {
    $title = $args['title'];
    $publications = $this->publicationService->getPublicationsByTitle($title);
    return $response->withJson($publications);
  }

  public function updatePublication(Request $request, Response $response, $args): Response {
    $publication_id = $args['id'];
    $body = $request->getParsedBody();
    $publication = Publication::fromArray($body);
    $updated_publication = $this->publicationService->updatePublication($publication_id, $publication);
    return $response->withJson($updated_publication);
  }

  public function deletePublication(Request $request, Response $response, $args): Response {
    $publication_id = $args['id'];
    $this->publicationService->deletePublication($publication_id);
    return $response->withStatus(204);
  }
}
