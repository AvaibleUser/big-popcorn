<?php

namespace BigPopcorn\Routers;

use BigPopcorn\Controllers\PublicationController;

function setPublicationGroup($app) {
  $app->group('/publications', function ($app) {
    $app->get('', [PublicationController::class, 'getPublications']);
    $app->post('', [PublicationController::class, 'createPublication']);
    $app->get('/{id}', [PublicationController::class, 'getPublication']);
    $app->put('/{id}', [PublicationController::class, 'updatePublication']);
    $app->delete('/{id}', [PublicationController::class, 'deletePublication']);
    $app->get('/search/{title}', [PublicationController::class, 'searchPublications']);
  });
}
