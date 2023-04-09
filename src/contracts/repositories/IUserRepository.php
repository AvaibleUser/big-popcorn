<?php

namespace BigPopcorn\Contracts\Repositories;

interface IUserRepository {
    public function getUserByEmail(string $email): ?User;
    public function createUser(User $user): User;
    public function getUserById(int $id): ?User;
}
