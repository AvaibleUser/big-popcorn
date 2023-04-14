<?php

namespace BigPopcorn\Controllers;

use Slim\Views\Twig;

use BigPopcorn\Access\Services\UserService;
use BigPopcorn\Models\Records\User;
use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController {
  private $userService;

  public function __construct(UserService $userService) {
    $this->userService = $userService;
  }

  public function getUserByEmail(Request $request, Response $response, $args): Response {
    $user_email = $args['email'];
    $user = $this->userService->getUserByEmail($user_email);

    if ($user == null) {
      return $response->withStatus(404);
    }

    return $response->withJson($user);
  }

  public function register(Request $request, Response $response, $args): Response {
    $body = $request->getParsedBody();

    $user = new User(null, $body['email'], $body['password'], $body['name'], $body['lastname']);
    $created_user = $this->userService->createUser($user);

    if ($created_user) {
      return $response->withJson($created_user, 201);
    } else {
      return $response->withStatus(400);
    }
  }

  public function login(Request $request, Response $response, $args): Response {
    $body = $request->getParsedBody();
    $user = $this->userService->login($body['email'], $body['password']);

    if (!$user) {
      return $response->withStatus(401);
    }

    return $response->withJson($user);
  }

  public function getUserById(Request $request, Response $response, $args): Response {
    $user_id = $args['id'];

    $user = $this->userService->getUserById($user_id);

    if ($user == null) {
      return $response->withStatus(404);
    }

    return $response->withJson($user);
  }
}
