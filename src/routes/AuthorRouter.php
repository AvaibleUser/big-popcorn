<?php

namespace BigPopcorn\Routes;

use BigPopcorn\Controllers\AuthorController;
use Slim\App;

$app->group('/authors', function (App $app) {
  $app->get('', [AuthorController::class, 'getAuthors']);
  $app->get('/{id}', [AuthorController::class, 'getAuthorById']);
  $app->get('/{id}/publications', [AuthorController::class, 'viewAuthorPublications']);
  $app->post('', [AuthorController::class, 'createAuthor']);
  $app->put('/{id}', [AuthorController::class, 'updateAuthor']);
});
