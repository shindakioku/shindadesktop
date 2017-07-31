<?php

namespace App\Services\Music;

use App\Entities\Group;
use App\Entities\Music;
use Illuminate\Support\Collection;

class MusicService implements MusicContract
{
    /**
     * @return Collection
     */
    public function all(int $skip = 0, int $take = 10): Collection
    {
        return Music::skip($skip)->take($take)->get();
    }

    /**
     * @return Collection
     */
    public function forShinda(int $skip = 0, int $take = 10): Collection
    {
        return Music::skip($skip)->take($take)->get(['id', 'name']);
    }

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getMusic(?string $value, string $column = 'id')
    {
        if (!($music = Music::where($column, $value)->first())) {
            return ['error'];
        }

        return $music;
    }

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getGroup(?string $value, string $column = 'id')
    {
        if (!($group = Group::where($column, $value)->first())) {
            return ['error'];
        }

        return $group;
    }

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getMusicByGroup(?string $value, string $column = 'id')
    {
        if (is_array($group = $this->getGroup($value, $column))) {
            return ['error'];
        }

        return $group->music;
    }
}