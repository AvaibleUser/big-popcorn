<?php

namespace BigPopcorn\Controllers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;

class BaseController {
  protected $twig;
  
  public function __construct(Twig $twig) {
    $this->twig = $twig;
  }
  
  protected function renderView(Response $response, $template, $data = []) {
    $response->getBody()->write(
      $this->twig->render($template, $data)
    );
  }
}
