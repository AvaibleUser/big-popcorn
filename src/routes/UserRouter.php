<?php

namespace BigPopcorn\Routes;

use BigPopcorn\Controllers\UserController;
use Slim\App;

$app->group('/users', function (App $app) {
  $app->get('/{email}', [UserController::class, 'getUserByEmail']);
  $app->post('', [UserController::class, 'register']);
  $app->post('/login', [UserController::class, 'login']);
  $app->get('/{id}', [UserController::class, 'getUserById']);
});
