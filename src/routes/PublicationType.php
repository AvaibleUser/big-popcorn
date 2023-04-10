<?php

namespace BigPopcorn\Routes;

use BigPopcorn\Controllers\PublicationTypeController;
use Slim\App;

$app->group('/publicationtypes', function (App $app) {
  $app->get('', [PublicationTypeController::class, 'getAllPublicationTypes']);
  $app->get('/{id}', [PublicationTypeController::class, 'getPublicationType']);
  $app->post('', [PublicationTypeController::class, 'createPublicationType']);
  $app->put('/{id}', [PublicationTypeController::class, 'updatePublicationType']);
  $app->delete('/{id}', [PublicationTypeController::class, 'deletePublicationType']);
});
