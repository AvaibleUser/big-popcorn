<?php

namespace BigPopcorn\Controllers;

use BigPopcorn\Access\Services\CategoryService;
use BigPopcorn\Models\Records\Category;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoryController extends BaseController {
  private $categoryService;
  private $publicationService;

  public function __construct(CategoryService $categoryService, PublicationService $publicationService, Twig $twig) {
    parent::__construct($twig);
    $this->categoryService = $categoryService;
    $this->publicationService = $publicationService;
  }

  public function viewCategoryPublications(int $id): void {
    $category = $this->categoryService->getCategoryById($id);
    $publications = $this->publicationService->getPublicationsByAuthorId($id);
    $this->renderView('category.php', ['category' => $category, 'publications' => $publications]);
  }

  public function getCategory(Request $request, Response $response, $args): Response {
    $category_id = $args['id'];
    $category = $this->categoryService->getCategoryById($category_id);

    if ($category == null) {
      return $response->withStatus(404);
    }

    return $response->withJson($category);
  }

  public function getAllCategories(Request $request, Response $response, $args): Response {
    $categories = $this->categoryService->getAllCategories();

    return $response->withJson($categories);
  }

  public function createCategory(Request $request, Response $response, $args): Response {
    $body = $request->getParsedBody();

    $category = new Category(null, $body['name']);
    $created_category = $this->categoryService->createCategory($category);

    return $response->withJson($created_category, 201);
  }

  public function updateCategory(Request $request, Response $response, $args): Response {
    $params = $request->getParsedBody();

    $category = new Category($params['id'], $params['name']);
    $updated_category = $this->categoryService->updateCategory($category_id, $category);

    return $response->withJson($updated_category);
  }

  public function deleteCategory(Request $request, Response $response, $args): Response {
    $category_id = $args['id'];

    $this->categoryService->deleteCategory($category_id);

    return $response->withStatus(204);
  }
}
