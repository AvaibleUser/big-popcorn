<?php

namespace BigPopcorn\Controllers;

use BigPopcorn\Access\Services\AuthorService;
use BigPopcorn\Models\Records\Author;
use BigPopcorn\Controller\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthorController extends BaseController {
  private $authorService;
  private $publicationService;

  public function __construct(AuthorService $authorService, PublicationService $publicationService, Twig $twig) {
    parent::__construct($twig);
    $this->authorService = $authorService;
    $this->publicationService = $publicationService;
  }

  public function viewAuthorPublications(int $id): void {
    $author = $this->authorService->getAuthorById($id);
    $publications = $this->publicationService->getPublicationsByAuthorId($id);
    $this->renderView('author.php', ['author' => $author, 'publications' => $publications]);
  }

  public function createAuthor(Request $request, Response $response, array $args): Response {
    $params = $request->getParsedBody();
    
    $author = new Author(null, $params['name']);
    $createdAuthor = $this->authorService->createAuthor($author);
    
    return $response->withJson($createdAuthor, 201);
  }
  
  public function getAuthors(Request $request, Response $response, array $args): Response {
    $authors = $this->authorService->getAuthors();
    
    if ($authors == null) {
      return $response->withStatus(404);
    }

    return $response->withJson($authors, 200);
  }
  
  public function getAuthorById(Request $request, Response $response, array $args): Response {
    $author = $this->authorService->getAuthorById($args['id']);
    
    if (!$author) {
      return $response->withStatus(404);
    }
    
    return $response->withJson($author, 200);
  }

  public function updateAuthor(Request $request, Response $response, array $args): Response {
    $params = $request->getParsedBody();
    
    $updatedAuthor = $this->authorService->updateAuthor($args['id'], $params['name']);
    
    return $response->withJson($updatedAuthor, 200);
  }
}
