<?php

namespace BigPopcorn\Contracts\Repositories;

use BigPopcorn\Models\Records\Author;

interface IAuthorRepository {
    public function createAuthor(Author $author): Author;
    public function getAuthors(): array;
    public function getAuthorById(int $id): ?Author;
    public function getAuthorsByPublicationId(int $publication_id): array;
    public function updateAuthor(int $id, string $name): Author;
}
