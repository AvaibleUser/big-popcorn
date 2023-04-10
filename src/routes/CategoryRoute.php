<?php

namespace BigPopcorn\Routes;

use BigPopcorn\Controllers\CategoryController;
use Slim\App;
use Slim\Views\Twig;

$app->group('/categories', function (App $app) {
  $app->get('', [CategoryController::class, 'getCategories']);
  $app->get('/{id}', [CategoryController::class, 'getCategory']);
  $app->get('/{id}/publications', [CategoryController::class, 'viewCategoryPublications']);
  $app->post('', [CategoryController::class, 'createCategory']);
  $app->put('/{id}', [CategoryController::class, 'updateCategory']);
});
