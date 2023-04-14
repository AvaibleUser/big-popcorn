<?php

namespace BigPopcorn\Access\Repositories;

use BigPopcorn\Access\Utils\MySqlConnection;
use BigPopcorn\Contracts\Repositories\IAuthorRepository;
use BigPopcorn\Models\Records\Author;
use \PDO;

class AuthorRepository implements IAuthorRepository {
  private const INSERT_AUTHOR = "INSERT INTO author (name) VALUES (:name)";
  private const SELECT_ALL_AUTHORS = "SELECT * FROM author";
  private const SELECT_AUTHOR_BY_ID = "SELECT * FROM author WHERE id = :id";
  private const SELECT_AUTHORS_BY_PUBLICATION_ID = "SELECT author.* FROM author a JOIN publication_author pa ON a.id = pa.author_id WHERE pa.publication_id = :publication_id";
  private const UPDATE_AUTHOR = "UPDATE author SET name = :name WHERE id = :id";

  private $connection;

  public function __construct($connection) {
    $this->connection = $connection;
  }

  public function createAuthor(Author $author): Author {
    $statement = $this->connection->prepare(self::INSERT_AUTHOR);
    $statement->execute(['name' => $author->name]);
    $author->id = $this->connection->lastInsertId();
    return $author;
  }

  public function getAuthorById(int $id): ?Author {
    $statement = $this->connection->prepare(self::SELECT_AUTHOR_BY_ID);
    $statement->execute(['id' => $id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new Author($row['id'], $row['name']);
  }

  public function getAuthors(): array {
    $statement = $this->connection->query(self::SELECT_ALL_AUTHORS);
    $authors = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $authors[] = new Author($row['id'], $row['name']);
    }
    return $authors;
  }

  public function getAuthorsByPublicationId(int $publication_id): array {
    $statement = $this->connection->prepare(self::SELECT_AUTHORS_BY_PUBLICATION_ID);
    $statement->execute(['publication_id' => $publication_id]);
    $authors = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $authors[] = new Author($row['id'], $row['name']);
    }
    return $authors;
  }

  public function updateAuthor(int $id, string $name): Author {
    $statement = $this->connection->prepare(self::UPDATE_AUTHOR);
    $statement->execute(['id' => $id, 'name' => $name]);
    return $this->getAuthorById($id);
  }
}
