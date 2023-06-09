<?php

namespace BigPopcorn\Contracts\DAOs;

use BigPopcorn\Models\Records\PublicationType;

interface IPublicationTypeDAO {
    public function getPublicationTypeById(int $id): ?PublicationType;
    public function getAllPublicationTypes(): array;
    public function createPublicationType(PublicationType $publicationType): PublicationType;
    public function updatePublicationType(int $id, PublicationType $publicationType): PublicationType;
    public function deletePublicationType(int $id): void;
}
