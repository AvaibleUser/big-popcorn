<?php

namespace BigPopcorn\Controllers;

use Slim\Views\Twig;

use BigPopcorn\Access\Services\PublicationService;
use BigPopcorn\Models\Records\Publication;
use BigPopcorn\Models\Records\Author;
use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PublicationController {
  private $publicationService;

  public function __construct(PublicationService $publicationService) {
    $this->publicationService = $publicationService;
  }

  public function viewPublication(Request $request, Response $response, $args): Response {
    $publication_id = $args['id'];
    $publication = $this->publicationService->getPublicationById($publication_id);

    if ($publication == null) {
      return $response->withStatus(404);
    }

    $view = Twig::fromRequest($request);

    return $view->render($response, 'publication.php', ['publication' => $publication]);
  }

  public function createPublication(Request $request, Response $response, $args): Response {
    $body = $request->getParsedBody();
    $authors = [];
    foreach ($body['authors'] as $author) {
      $authors[] = new Author($user['id'] ?? null, null, $author['name']);
    }
    $publication = new Publication(null, null, $body['title'], $body['abstract'], $body['content'], null, $authors, $body['references'], [], $body['categories'], $body['type']);
    $created_publication = $this->publicationService->createPublication($publication);

    if (!$created_publication) {
      return $response->withStatus(400);
    }
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

  public function searchPublications(Request $request, Response $response, $args): Response {
    $title = $args['title'];
    $publications = $this->publicationService->getPublicationsByTitle($title);
    // add other methods
    if (!is_array($publications)) {
      return $response->withStatus(404);
    }

    $view = Twig::fromRequest($request);

    return $view->render($response, 'publications.php', [
      'publications' => $publications,
      'bunchtitle' => "Publicaciones que coinciden con '$title'"
    ]);
  }

  public function getPublicationsByTitle(Request $request, Response $response, $args): Response {
    $title = $args['title'];
    $publications = $this->publicationService->getPublicationsByTitle($title);
    if (!is_array($publications)) {
      return $response->withStatus(404);
    }

    $view = Twig::fromRequest($request);

    return $view->render($response, 'publications.php', [
      'publications' => $publications,
      'bunchtitle' => "Publicaciones que coinciden con '$title'"
    ]);
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
