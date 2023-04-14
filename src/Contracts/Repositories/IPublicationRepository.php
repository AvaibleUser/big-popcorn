<?php

namespace BigPopcorn\Contracts\Repositories;

use BigPopcorn\Models\Records\Publication;

interface IPublicationRepository {
    public function createPublication(Publication $publication): Publication;
    public function getPublicationById(int $id): ?Publication;
    public function getPublicationsByTitle(string $title): array;
    public function getPublicationsByAuthorId(int $author_id): array;
    public function getPublicationsByCategoryId(int $category_id): array;
    public function getPublicationReferences(int $id): array;
    public function getPublicationCitations(int $id): array;
    public function updatePublication(int $id, Publication $publication): Publication;
    public function deletePublication(int $id): void;
}
