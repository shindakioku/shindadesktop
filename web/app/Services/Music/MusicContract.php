<?php

namespace App\Services\Music;

use Illuminate\Support\Collection;

interface MusicContract
{
    public function all(int $skip = 0, int $take = 10): Collection;

    public function forShinda(int $skip = 0, int $take = 10): Collection;

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getMusic(?string $value, string $column = 'id');

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getGroup(?string $value, string $column = 'id');

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getMusicByGroup(?string $value, string $column = 'id');
}