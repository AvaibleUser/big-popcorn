<?php

namespace BigPopcorn\Contracts\Repositories;

use BigPopcorn\Models\Records\User;

interface IUserRepository {
    public function getUserByEmail(string $email): ?User;
    public function createUser(User $user): User;
    public function getUserById(int $id): ?User;
}
