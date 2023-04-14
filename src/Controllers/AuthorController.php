<?php

namespace BigPopcorn\Controllers;

use Slim\Views\Twig;

use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use BigPopcorn\Access\Services\AuthorService;
use BigPopcorn\Access\Services\PublicationService;
use BigPopcorn\Models\Records\Author;

class AuthorController {
  private $authorService;
  private $publicationService;

  public function __construct(AuthorService $authorService, PublicationService $publicationService) {
    $this->authorService = $authorService;
    $this->publicationService = $publicationService;
  }

  public function viewAuthorPublications(int $id): Response {
    $author = $this->authorService->getAuthorById($id);
    $publications = $this->publicationService->getPublicationsByAuthorId($id);

    $view = Twig::fromRequest($request);

    return $view->render($response, 'author.php', ['author' => $author, 'publications' => $publications]);
  }

  public function createAuthor(Request $request, Response $response, array $args): Response {
    $params = $request->getParsedBody();
    
    $author = new Author(null, $params['name']);
    $createdAuthor = $this->authorService->createAuthor($author);
    
    return $response->withJson($createdAuthor, 201);
  }
  
  public function getAuthors(Request $request, Response $response, array $args): Response {
    $authors = $this->authorService->getAuthors();
    
    if (!is_array($authors)) {
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
