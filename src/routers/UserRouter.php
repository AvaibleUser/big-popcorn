<?php

namespace BigPopcorn\Routers;

use BigPopcorn\Controllers\UserController;

function setUserGroup($app) {
  $app->group('/users', function ($app) {
    $app->get('/{email}', [UserController::class, 'getUserByEmail']);
    $app->post('', [UserController::class, 'register']);
    $app->post('/login', [UserController::class, 'login']);
    $app->post('/sign-up', [UserController::class, 'register']);
    $app->get('/{id:[0-9]+}', [UserController::class, 'getUserById']);
  });
}
