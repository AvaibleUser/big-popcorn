<?php

namespace BigPopcorn\Routes;

use BigPopcorn\Controllers\PublicationController;
use Slim\App;

$app->group('/publications', function (App $app) {
  $app->get('', [PublicationController::class, 'getPublications']);
  $app->post('', [PublicationController::class, 'createPublication']);
  $app->get('/{id}', [PublicationController::class, 'getPublication']);
  $app->put('/{id}', [PublicationController::class, 'updatePublication']);
  $app->delete('/{id}', [PublicationController::class, 'deletePublication']);
  $app->get('/search/{title}', [PublicationController::class, 'getPublicationsByTitle']);
});
