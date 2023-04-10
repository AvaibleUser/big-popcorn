<?php

namespace BigPopcorn\Access\DAOs;

use BigPopcorn\Access\Utils\MySqlConnection;
use BigPopcorn\Contracts\DAOs\IPublicationTypeDAO;
use BigPopcorn\Models\Records\PublicationType;
use PDO;

class PublicationTypeDAO implements IPublicationTypeDAO {
  private const SELECT_PUBLICATION_TYPE_BY_ID = "SELECT * FROM publication_types WHERE id = :id";
  private const SELECT_ALL_PUBLICATION_TYPES = "SELECT * FROM publication_types";
  private const INSERT_PUBLICATION_TYPE = "INSERT INTO publication_types (name) VALUES (:name)";
  private const UPDATE_PUBLICATION_TYPE = "UPDATE publication_types SET name = :name WHERE id = :id";
  private const DELETE_PUBLICATION_TYPE = "DELETE FROM publication_types WHERE id = :id";

  private $connection;

  public function __construct($connection) {
    $this->connection = $connection;
  }

  public function getPublicationTypeById(int $id): ?PublicationType {
    $statement = $this->connection->prepare(self::SELECT_PUBLICATION_TYPE_BY_ID);
    $statement->execute(['id' => $id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new PublicationType($row['id'], $row['name']);
  }

  public function getAllPublicationTypes(): array {
    $statement = $this->connection->prepare(self::SELECT_ALL_PUBLICATION_TYPES);
    $statement->execute();
    $publicationTypes = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $publicationTypes[] = new PublicationType($row['id'], $row['name']);
    }
    return $publicationTypes;
  }

  public function createPublicationType(PublicationType $publicationType): PublicationType {
    $statement = $this->connection->prepare(self::INSERT_PUBLICATION_TYPE);
    $statement->execute([
      'name' => $publicationType->name,
    ]);
    $publicationType->id = $this->connection->lastInsertId();
    return $publicationType;
  }

  public function updatePublicationType(int $id, PublicationType $publicationType): PublicationType {
    $statement = $this->connection->prepare(self::UPDATE_PUBLICATION_TYPE);
    $statement->execute([
      'id' => $id,
      'name' => $publicationType->name,
    ]);
    return $publicationType;
  }

  public function deletePublicationType(int $id): void {
    $statement = $this->connection->prepare(self::DELETE_PUBLICATION_TYPE);
    $statement->execute(['id' => $id]);
  }
}
