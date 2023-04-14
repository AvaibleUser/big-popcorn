<?php

namespace BigPopcorn\Access\DAOs;

use BigPopcorn\Access\Utils\MySqlConnection;
use BigPopcorn\Contracts\DAOs\ICategoryDAO;
use BigPopcorn\Models\Records\Category;
use \PDO;

class CategoryDAO implements ICategoryDAO {
  private const SELECT_CATEGORY_BY_ID = "SELECT * FROM category WHERE id = :id";
  private const SELECT_CATEGORIES_BY_PUBLICATION_ID = "SELECT id, name FROM category c JOIN publication_category pc ON c.id = pc.category_id WHERE pc.publication_id = :id";
  private const SELECT_ALL_CATEGORIES = "SELECT * FROM category";
  private const INSERT_CATEGORY = "INSERT INTO category (name) VALUES (:name)";
  private const UPDATE_CATEGORY = "UPDATE category SET name = :name WHERE id = :id";
  private const DELETE_CATEGORY = "DELETE FROM category WHERE id = :id";

  private $connection;

  public function __construct($connection) {
    $this->connection = $connection;
  }

  public function getCategoryById($id): ?Category {
    $statement = $this->connection->prepare(self::SELECT_CATEGORY_BY_ID);
    $statement->execute(['id' => $id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new Category($row['id'], $row['name']);
  }

  public function getAllCategories(): array {
    $statement = $this->connection->prepare(self::SELECT_ALL_CATEGORIES);
    $statement->execute();
    $categories = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $categories[] = new Category($row['id'], $row['name']);
    }
    return $categories;
  }

  public function getAllPublicationCategories(int $id): array {
    $statement = $this->connection->prepare(self::SELECT_CATEGORIES_BY_PUBLICATION_ID);
    $statement->execute(['id' => $id]);
    $categories = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $categories[] = new Category($row['id'], $row['name']);
    }
    return $categories;
  }

  public function createCategory(Category $category): Category {
    $statement = $this->connection->prepare(self::INSERT_CATEGORY);
    $statement->execute([
      'name' => $category->name,
    ]);
    $category->id = $this->connection->lastInsertId();
    return $category;
  }

  public function updateCategory(int $id, Category $category): Category {
    $statement = $this->connection->prepare(self::UPDATE_CATEGORY);
    $statement->execute([
      'id' => $id,
      'name' => $category->name,
    ]);
    $category->id = $id;
    return $category;
  }

  public function deleteCategory(int $id): void {
    $statement = $this->connection->prepare(self::DELETE_CATEGORY);
    $statement->execute(['id' => $id]);
  }
}
