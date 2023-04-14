<?php

namespace BigPopcorn\Access\Repositories;

use BigPopcorn\Access\Utils\MySqlConnection;
use BigPopcorn\Contracts\Repositories\IUserRepository;
use BigPopcorn\Models\Records\User;
use \PDO;

class UserRepository implements IUserRepository {
  private const SELECT_USER_BY_EMAIL = "SELECT * FROM user WHERE email = :email";
  private const SELECT_USER_BY_ID = "SELECT * FROM user WHERE id = :id";
  private const INSERT_USERS = "INSERT INTO user (email, password, name, lastname) VALUES (:email, :password, :name, :lastname)";
  private const INSERT_USER_AUTHOR = "INSERT INTO author (name, user_id) VALUES (:name, :user_id)";

  private $connection;

  public function __construct($connection) {
    $this->connection = $connection;
  }

  private function createUserAuthor(User $user): void {
    $statement = $this->connection->prepare(self::INSERT_USER_AUTHOR);
    $statement->execute([
      'name' => "{$user->name} {$user->lastname}",
      'user_id' => $user->id,
    ]);
  }

  public function getUserByEmail(string $email): ?User {
    $statement = $this->connection->prepare(self::SELECT_USER_BY_EMAIL);
    $statement->execute(['email' => $email]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new User($row['id'], $row['email'], '', $row['name'], $row['lastname']);
  }

  public function createUser(User $user): User {
    $statement = $this->connection->prepare(self::INSERT_USERS);
    $statement->execute([
      'email' => $user->email,
      'password' => $user->password,
      'name' => $user->name,
      'lastname' => $user->lastname,
    ]);
    $user->id = $this->connection->lastInsertId();
    $this->createUserAuthor($user);
    return $user;
  }

  public function getUserById(int $id): ?User {
    $statement = $this->connection->prepare(self::SELECT_USER_BY_ID);
    $statement->execute(['id' => $id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new User($row['id'], $row['email'], '', $row['name'], $row['lastname']);
  }
}
