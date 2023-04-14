<?php

namespace BigPopcorn\Routers;

use BigPopcorn\Controllers\PublicationTypeController;

function setPublicationTypeGroup($app) {
  $app->group('/types', function ($app) {
    $app->get('', [PublicationTypeController::class, 'getAllPublicationTypes']);
    $app->get('/options', [PublicationTypeController::class, 'viewTypesOptions']);
    $app->get('/{id}', [PublicationTypeController::class, 'getPublicationType']);
    $app->post('', [PublicationTypeController::class, 'createPublicationType']);
    $app->put('/{id}', [PublicationTypeController::class, 'updatePublicationType']);
    $app->delete('/{id}', [PublicationTypeController::class, 'deletePublicationType']);
  });
}
