<?php

namespace BigPopcorn\Routers;

use BigPopcorn\Controllers\CategoryController;

function setCategoryGroup($app) {
  $app->group('/categories', function ($app) {
    $app->get('', [CategoryController::class, 'getCategories']);
    $app->get('/options', [CategoryController::class, 'viewCategoriesOptions']);
    $app->get('/{id}', [CategoryController::class, 'getCategory']);
    $app->get('/{id}/publications', [CategoryController::class, 'viewCategoryPublications']);
    $app->post('', [CategoryController::class, 'createCategory']);
    $app->put('/{id}', [CategoryController::class, 'updateCategory']);
  });
}
