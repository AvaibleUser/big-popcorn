<?php

namespace BigPopcorn\Access\Services;

use BigPopcorn\Contracts\Repositories\IAuthorRepository;
use BigPopcorn\Models\Records\Author;

class AuthorService {
  private $authorRepository;
  
  public function __construct(IAuthorRepository $authorRepository) {
    $this->authorRepository = $authorRepository;
  }
  
  public function createAuthor(Author $author): Author {
    return $this->authorRepository->createAuthor($author);
  }
  
  public function getAuthors(): array {
    return $this->authorRepository->getAuthors();
  }
  
  public function getAuthorById(int $id): ?Author {
    return $this->authorRepository->getAuthorById($id);
  }

  public function updateAuthor(int $id, string $name): Author {
    return $this->authorRepository->updateAuthor($id, $name);
  }
}
