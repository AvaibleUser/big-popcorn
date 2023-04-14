<?php

namespace BigPopcorn\Access\Repositories;

use BigPopcorn\Access\Utils\MySqlConnection;
use BigPopcorn\Contracts\Repositories\IPublicationRepository;
use BigPopcorn\Models\Records\Publication;
use BigPopcorn\Models\Records\PublicationType;
use \PDO;

class PublicationRepository implements IPublicationRepository {
  private const SELECT_PUBLICATION_BY_ID = "SELECT pt.id AS ptid, * FROM publication p JOIN publication_type pt ON p.type_id = pt.id WHERE id = :id";
  private const INSERT_PUBLICATIONS = "INSERT INTO publication (title, abstract, content, publication_date, type_id) VALUES (:title, :abstract, :content, :publication_date, :type_id)";
  private const INSERT_PUBLICATION_AUTHORS = "INSERT INTO publication_author (author_id, publication_id) VALUES (:author_id, :publication_id)";
  private const INSERT_PUBLICATION_REFERENCES = "INSERT INTO publication_reference (publication_id, reference_publication_id) VALUES (:publication_id, :reference_publication_id)";
  private const UPDATE_PUBLICATION_BY_ID = "UPDATE publication SET title = :title, abstract = :abstract, content = :content, publication_date = :publication_date, type_id = :type_id WHERE id = :id";
  private const DELETE_PUBLICATION_BY_ID = "DELETE FROM publication WHERE id = :id";
  private const SELECT_PUBLICATIONS_BY_AUTHOR_ID = "SELECT p.id, title, abstract, content, publication_date, pt.id AS ptid, pt.name FROM publication p JOIN publication_author pa ON p.id = pa.publication_id JOIN publication_type pt ON p.type_id = pt.id WHERE author_id = :author_id";
  private const SELECT_PUBLICATIONS_BY_CATEGORY_ID = "SELECT p.id, title, abstract, content, publication_date, pt.id AS ptid, pt.name FROM publication p JOIN publication_category pc ON p.id = pc.publication_id JOIN publication_type pt ON p.type_id = pt.id WHERE category_id = :category_id";
  private const SELECT_PUBLICATIONS_BY_TITLE = "SELECT p.id, title, abstract, content, publication_date, pt.id AS ptid, pt.name FROM publication p JOIN publication_type pt ON p.type_id = pt.id WHERE title LIKE :title";
  private const SELECT_PUBLICATION_CITATIONS = "SELECT p.id, title, abstract, content, publication_date, pt.id AS ptid, pt.name FROM publication p JOIN publication_type pt ON p.type_id = pt.id JOIN publication_reference pr ON p.id = pr.publication_id WHERE pr.reference_publication_id = :id";
  private const SELECT_PUBLICATION_REFERENCES = "SELECT p.id, title, abstract, content, publication_date, pt.id AS ptid, pt.name FROM publication p JOIN publication_type pt ON p.type_id = pt.id JOIN publication_reference pr ON p.id = pr.reference_publication_id WHERE pr.publication_id = :id";

  private $connection;

  public function __construct($connection) {
    $this->connection = $connection;
  }

  private function createPublicationAuthors(int $publicationId, array $authors): void {
    $statement = $this->connection->prepare(self::INSERT_PUBLICATION_AUTHORS);
    foreach ($authors as $author) {
      $statement->execute([
        'author_id' => $author->id,
        'publication_id' => $publicationId,
      ]);
    }
  }

  private function createPublicationReferences(int $publicationId, array $references): void {
    $statement = $this->connection->prepare(self::INSERT_PUBLICATION_REFERENCES);
    foreach ($references as $reference) {
      $statement->execute([
        'publication_id' => $publicationId,
        'reference_publication_id' => $reference->id,
      ]);
    }
  }

  public function createPublication(Publication $publication): Publication {
    $publication->content = base64_encode($publication->content);
    $statement = $this->connection->prepare(self::INSERT_PUBLICATIONS);
    $statement->execute([
      'title' => $publication->title,
      'abstract' => $publication->abstract,
      'content' => $publication->content,
      'publication_date' => $publication->publication_date,
      'type_id' => $publication->type,
    ]);
    $publication->id = $this->connection->lastInsertId();
    $publication->content = base64_decode($publication->content);
    
    $this->createPublicationAuthors($publication->id, $publication->authors);
    $this->createPublicationReferences($publication->id, $publication->references);
    return $publication;
  }

  public function getPublicationById(int $id): ?Publication {
    $statement = $this->connection->prepare(self::SELECT_PUBLICATION_BY_ID);
    $statement->execute(['id' => $id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new Publication($row['id'], $row['title'], $row['abstract'], base64_decode($row['content']), $row['publication_date'], [], [], [], [], new PublicationType($row['ptid'], $row['name']));
  }

  public function updatePublication(int $id, Publication $publication): Publication {
    $statement = $this->connection->prepare(self::UPDATE_PUBLICATION_BY_ID);
    $statement->execute([
      'id' => $id,
      'title' => $publication->title,
      'abstract' => $publication->abstract,
      'content' => $publication->content,
      'publication_date' => $publication->publication_date,
      'type_id' => $publication->type,
    ]);
    return $publication;
  }

  public function deletePublication(int $id): void {
    $statement = $this->connection->prepare(self::DELETE_PUBLICATION_BY_ID);
    $statement->execute(['id' => $id]);
  }

  public function getPublicationReferences(int $id): array {
    $statement = $this->connection->prepare(self::SELECT_PUBLICATION_REFERENCES);
    $statement->execute(['id' => $id]);
    return $this->getRecordsFromStatement($statement);
  }

  public function getPublicationCitations(int $id): array {
    $statement = $this->connection->prepare(self::SELECT_PUBLICATION_CITATIONS);
    $statement->execute(['id' => $id]);
    return $this->getRecordsFromStatement($statement);
  }

  public function getPublicationsByAuthorId(int $author_id): array {
    $statement = $this->connection->prepare(self::SELECT_PUBLICATIONS_BY_AUTHOR_ID);
    $statement->execute(['author_id' => $author_id]);
    return $this->getRecordsFromStatement($statement);
  }

  public function getPublicationsByCategoryId(int $category_id): array {
    $statement = $this->connection->prepare(self::SELECT_PUBLICATIONS_BY_CATEGORY_ID);
    $statement->execute(['category_id' => $category_id]);
    return $this->getRecordsFromStatement($statement);
  }

  public function getPublicationsByTitle(string $title): array {
    $statement = $this->connection->prepare(self::SELECT_PUBLICATIONS_BY_TITLE);
    $statement->execute(['title' => "%$title%"]);
    return $this->getRecordsFromStatement($statement);
  }

  private function getRecordsFromStatement($statement): array {
    $publications = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $publications[] = new Publication(
        $row['id'],
        "/{$row['id']}",
        $row['title'],
        $row['abstract'],
        base64_decode($row['content']),
        $row['publication_date'],
        [],
        [],
        [],
        [],
        new PublicationType($row['ptid'], $row['name'])
      );
    }
    return $publications;
  }
}
