<?php

namespace BigPopcorn\Access\Services;

use BigPopcorn\Contracts\DAOs\IPublicationTypeDAO;
use BigPopcorn\Models\Records\PublicationType;

class PublicationTypeService {
  protected $publicationTypeDAO;

  public function __construct(IPublicationTypeDAO $publicationTypeDAO) {
    $this->publicationTypeDAO = $publicationTypeDAO;
  }

  public function getPublicationTypeById(int $id): PublicationType {
    return $this->publicationTypeDAO->getPublicationTypeById($id);
  }

  public function getAllPublicationTypes(): array {
    return $this->publicationTypeDAO->getAllPublicationTypes();
  }

  public function createPublicationType(PublicationType $publicationType): PublicationType {
    return $this->publicationTypeDAO->createPublicationType($publicationType);
  }

  public function updatePublicationType(int $id, PublicationType $publicationType): PublicationType {
    return $this->publicationTypeDAO->updatePublicationType($id, $publicationType);
  }

  public function deletePublicationType(int $id): void {
    $this->publicationTypeDAO->deletePublicationType($id);
  }
}
