<?php

namespace BigPopcorn\Contracts\DAOs;

use BigPopcorn\Models\Records\Category;

interface ICategoryDAO {
    public function getCategoryById(int $id): ?Category;
    public function getAllCategories(): array;
    public function getAllPublicationCategories(int $id): array;
    public function createCategory(Category $category): Category;
    public function updateCategory(int $id, Category $category): Category;
    public function deleteCategory(int $id): void;
}
