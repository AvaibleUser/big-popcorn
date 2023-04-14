<?php

namespace BigPopcorn\Routers;

use BigPopcorn\Controllers\AuthorController;

function setAuthorGroup($app) {
  $app->group('/authors', function ($app) {
    $app->get('', [AuthorController::class, 'getAuthors']);
    $app->get('/{id}', [AuthorController::class, 'getAuthorById']);
    $app->get('/{id}/publications', [AuthorController::class, 'viewAuthorPublications']);
    $app->post('', [AuthorController::class, 'createAuthor']);
    $app->put('/{id}', [AuthorController::class, 'updateAuthor']);
  });
}
