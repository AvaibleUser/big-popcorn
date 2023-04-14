<?php

use BigPopcorn\Access\Utils\MySqlConnection;

use BigPopcorn\Contracts\Repositories\IAuthorRepository;
use BigPopcorn\Contracts\Repositories\IPublicationRepository;
use BigPopcorn\Contracts\Repositories\IUserRepository;
use BigPopcorn\Contracts\DAOs\IPublicationTypeDAO;
use BigPopcorn\Contracts\DAOs\ICategoryDAO;

use BigPopcorn\Access\Repositories\AuthorRepository;
use BigPopcorn\Access\Repositories\PublicationRepository;
use BigPopcorn\Access\Repositories\UserRepository;
use BigPopcorn\Access\DAOs\PublicationTypeDAO;
use BigPopcorn\Access\DAOs\CategoryDAO;

use BigPopcorn\Access\Services\AuthorService;
use BigPopcorn\Access\Services\CategoryService;
use BigPopcorn\Access\Services\PublicationService;
use BigPopcorn\Access\Services\PublicationTypeService;
use BigPopcorn\Access\Services\UserService;

use BigPopcorn\Controllers\AuthorController;
use BigPopcorn\Controllers\CategoryController;
use BigPopcorn\Controllers\PublicationController;
use BigPopcorn\Controllers\PublicationTypeController;
use BigPopcorn\Controllers\UserController;

function fillContainer($container) {
  $container->set(\PDO::class, function ($container) {
    return MySqlConnection::getConnection();
  });
  
  // Repositories and DAOs'
  $container->set(IAuthorRepository::class, function ($container) {
    return new AuthorRepository(
      $container->get(\PDO::class)
    );
  });
  
  $container->set(IPublicationRepository::class, function ($container) {
    return new PublicationRepository(
      $container->get(\PDO::class)
    );
  });
  
  $container->set(IUserRepository::class, function ($container) {
    return new UserRepository(
      $container->get(\PDO::class)
    );
  });
  
  $container->set(IPublicationTypeDAO::class, function ($container) {
    return new PublicationTypeDAO(
      $container->get(\PDO::class)
    );
  });
  
  $container->set(ICategoryDAO::class, function ($container) {
    return new CategoryDAO(
      $container->get(\PDO::class)
    );
  });
  
  // Services
  $container->set(AuthorService::class, function ($container) {
    return new AuthorService(
      $container->get(IAuthorRepository::class)
    );
  });
  
  $container->set(CategoryService::class, function ($container) {
    return new CategoryService(
      $container->get(ICategoryDAO::class)
    );
  });
  
  $container->set(PublicationService::class, function ($container) {
    return new PublicationService(
      $container->get(IPublicationRepository::class),
      $container->get(IAuthorRepository::class),
      $container->get(ICategoryDAO::class)
    );
  });
  
  $container->set(PublicationTypeService::class, function ($container) {
    return new PublicationTypeService(
      $container->get(IPublicationTypeDAO::class)
    );
  });
  
  $container->set(UserService::class, function ($container) {
    return new UserService(
      $container->get(IUserRepository::class),
      $container->get(IAuthorRepository::class)
    );
  });
  
  // Controllers
  $container->set(AuthorController::class, function ($container) {
    return new AuthorController(
      $container->get(AuthorService::class),
      $container->get(PublicationService::class)
    );
  });
  
  $container->set(CategoryController::class, function ($container) {
    return new CategoryController(
      $container->get(CategoryService::class),
      $container->get(PublicationService::class)
    );
  });
  
  $container->set(PublicationController::class, function ($container) {
    return new PublicationController(
      $container->get(PublicationService::class)
    );
  });
  
  $container->set(PublicationTypeController::class, function ($container) {
    return new PublicationTypeController(
      $container->get(PublicationTypeService::class)
    );
  });
  
  $container->set(UserController::class, function ($container) {
    return new UserController(
      $container->get(UserService::class),
      $container->get(PublicationService::class)
    );
  });  
}
