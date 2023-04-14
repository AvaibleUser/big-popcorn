<?php

use DI\Container;
use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/config.php";

$container = new Container();

fillContainer($container);

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->setBasePath("");
$app->addRoutingMiddleware();

$app->add(TwigMiddleware::create($app, Twig::create(__DIR__ . '/static/views', ['cache' => false])));

use function BigPopcorn\Routers\setAuthorGroup;
use function BigPopcorn\Routers\setCategoryGroup;
use function BigPopcorn\Routers\setPublicationGroup;
use function BigPopcorn\Routers\setPublicationTypeGroup;
use function BigPopcorn\Routers\setUserGroup;
use function BigPopcorn\Routers\setPublicRoutes;

setAuthorGroup($app);
setCategoryGroup($app);
setPublicationGroup($app);
setPublicationTypeGroup($app);
setUserGroup($app);
setPublicRoutes($app);

$app->run();
