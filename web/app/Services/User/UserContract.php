<?php

namespace App\Services\User;

interface UserContract
{
    public function auth(string $login, string $password, bool $auth);

    public function addFavorite(string $entity, int $entityId, int $userId);

    public function getFavorite(int $id, string $entity);

    public function hasFavorite(int $userId, string $entity, int $entityId): bool;
}