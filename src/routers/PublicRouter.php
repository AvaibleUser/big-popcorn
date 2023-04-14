<?php

namespace BigPopcorn\Routers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function setPublicRoutes($app) {
  $app->get('/{folder:css|js}/{file:.+\.css|.+\.js}', function (Request $req, Response $res, $array) use ($app) {
    $file = $array['file'];
    $folder = $array['folder'];

    $type;
    if ($folder === "js") {
      $type = "text/javascript";
    } else {
      $type = "text/css";
    }

    $css_file = file_get_contents(dirname(__DIR__) . "/public/$folder/$file");
    $res = $res->withHeader('Content-Type', "$type");
    $res->getBody()->write($css_file);

    return $res;
  });

  $app->get('/{file:.+\.html}', function (Request $req, Response $res, $array) use ($app) {
    $res = $res->withHeader('Content-Type', "text/html");
    $file = $array['file'];

    $view = Twig::fromRequest($req);

    return $view->render($res, $file, []);
  });
}
