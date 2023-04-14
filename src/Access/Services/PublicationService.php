<?php

namespace BigPopcorn\Access\Services;

use BigPopcorn\Contracts\Repositories\IPublicationRepository;
use BigPopcorn\Contracts\Repositories\IAuthorRepository;
use BigPopcorn\Contracts\DAOs\ICategoryDAO;
use BigPopcorn\Models\Records\Publication;

class PublicationService {
  private $publicationRepository;
  private $authorRepository;
  private $categoryDAO;

  public function __construct(IPublicationRepository $publicationRepository, IAuthorRepository $authorRepository, ICategoryDAO $categoryDAO) {
    $this->publicationRepository = $publicationRepository;
    $this->authorRepository = $authorRepository;
    $this->categoryDAO = $categoryDAO;
  }

  public function createPublication(Publication $publication): Publication {
    foreach ($publication->authors as $author) {
      if (!$author->id) {
        $newAuthor = $this->authorRepository->createAuthor($author);
        $author->id = $newAuthor->id;
      }
    }
    $publication->publication_date = date("Y-m-d");
    return $this->publicationRepository->createPublication($publication);
  }

  public function getPublicationById(int $id): ?Publication {
    $publication = $this->publicationRepository->getPublicationById($id);
    if ($publication) {
      $publication->authors = $this->authorRepository->getAuthorsByPublicationId($id);
      $publication->references = $this->publicationRepository->getPublicationReferences($id);
      $publication->citations = $this->publicationRepository->getPublicationCitations($id);
      $publication->categories = $this->categoryDAO->getAllPublicationCategories($id);
    }
    return $publication;
  }

  public function getPublicationsByTitle(string $title): array {
    return $this->publicationRepository->getPublicationsByTitle($title);
  }

  public function getPublicationsByAuthorId(int $author_id): array {
    return $this->publicationRepository->getPublicationsByAuthorId($author_id);
  }

  public function getPublicationsByCategoryId(int $category_id): array {
    return $this->publicationRepository->getPublicationsByCategoryId($category_id);
  }

  public function updatePublication(int $id, Publication $publication): Publication {
    return $this->publicationRepository->updatePublication($id, $publication);
  }

  public function deletePublication(int $id): void {
    $this->publicationRepository->deletePublication($id);
  }
}
