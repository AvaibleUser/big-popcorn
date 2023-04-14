<?php

namespace BigPopcorn\Access\Services;

use BigPopcorn\Contracts\Repositories\IUserRepository;
use BigPopcorn\Models\Records\User;

class UserService {
  private $userRepository;

  public function __construct(IUserRepository $userRepository) {
    $this->userRepository = $userRepository;
  }

  private function password_verify($password, $suspectPassword) {
    // modify logic for more security
    return strcmp($password, $suspectPassword);
  }

  public function getUserByEmail(string $email): ?User {
    return $this->userRepository->getUserByEmail($email);
  }

  public function createUser(User $user): User {
    try {
      return $this->userRepository->createUser($user);
    } catch (Exception $error) {
      return null;
    }
  }

  public function getUserById(int $id): ?User {
    return $this->userRepository->getUserById($id);
  }

  public function login(string $email, string $password): ?User {
    $user = $this->userRepository->getUserByEmail($email);

    if ($user == null || !$this->password_verify($password, $user->password)) {
      return null;
    }
    return $user;
  }
}
