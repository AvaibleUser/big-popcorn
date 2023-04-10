<?php

namespace BigPopcorn\Access\Services;

use BigPopcorn\Contracts\DAOs\ICategoryDAO;
use BigPopcorn\Models\Records\Category;

class CategoryService {
  private $categoryDAO;

  public function __construct(ICategoryDAO $categoryDAO) {
    $this->categoryDAO = $categoryDAO;
  }

  public function getCategoryById(int $id): ?Category {
    return $this->categoryDAO->getCategoryById($id);
  }

  public function getAllCategories(): array {
    return $this->categoryDAO->getAllCategories();
  }

  public function createCategory(Category $category): Category {
    return $this->categoryDAO->createCategory($category);
  }

  public function updateCategory(int $id, Category $category): Category {
    return $this->categoryDAO->updateCategory($id, $category);
  }

  public function deleteCategory(int $id): void {
    $this->categoryDAO->deleteCategory($id);
  }
}
