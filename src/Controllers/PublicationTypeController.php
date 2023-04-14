<?php

namespace BigPopcorn\Controllers;

use Slim\Views\Twig;

use BigPopcorn\Access\Services\PublicationTypeService;
use BigPopcorn\Models\Records\PublicationType;

use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PublicationTypeController {
  private $publicationTypeService;

  public function __construct(PublicationTypeService $publicationTypeService) {
    $this->publicationTypeService = $publicationTypeService;
  }

  public function viewTypesOptions(Request $request, Response $response, $args): Response {
    $avaibleTypes = $this->publicationTypeService->getAllPublicationTypes();

    if (!is_array($avaibleTypes)) {
      $avaibleTypes = [];
    }

    $view = Twig::fromRequest($request);

    return $view->render($response, 'types-options.php', ['avaibleTypes' => $avaibleTypes]);
  }

  public function getPublicationType(Request $request, Response $response, $args): Response {
    $publicationtype_id = $args['id'];
    $publicationType = $this->publicationTypeService->getPublicationTypeById($publicationtype_id);

    if ($publicationType == null) {
      return $response->withStatus(404);
    }

    return $response->withJson($publicationType);
  }

  public function getAllPublicationTypes(Request $request, Response $response, $args): Response {
    $publicationtypes = $this->publicationTypeService->getAllPublicationTypes();

    return $response->withJson($publicationtypes);
  }

  public function createPublicationType(Request $request, Response $response, $args): Response {
    $body = $request->getParsedBody();

    $publicationType = new PublicationType(null, $body['name']);
    $created_publicationtype = $this->publicationTypeService->createPublicationType($publicationType);

    return $response->withJson($created_publicationtype, 201);
  }

  public function updatePublicationType(Request $request, Response $response, $args): Response {
    $params = $request->getParsedBody();

    $publicationType = new PublicationType($params['id'], $params['name']);
    $updated_publicationtype = $this->publicationTypeService->updatePublicationType($publicationtype_id, $publicationType);

    return $response->withJson($updated_publicationtype);
  }

  public function deletePublicationType(Request $request, Response $response, $args): Response {
    $publicationtype_id = $args['id'];

    $this->publicationTypeService->deletePublicationType($publicationtype_id);

    return $response->withStatus(204);
  }
}
