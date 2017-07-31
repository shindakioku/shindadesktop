<?php

namespace App\Services\Anime;

use Illuminate\Support\Collection;

interface AnimeContract
{
    /**
     * @return Collection
     */
    public function all(int $skip = 0, int $take = 10): Collection;

    /**
     * @return Collection
     */
    public function forShinda(int $skip = 0, int $take = 10): Collection;

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getAnime(?string $value, string $column = 'id');

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getCompany(?string $value, string $column = 'id');

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getAnimeForCompany(?string $value, string $column = 'id');

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getSoundTracks(?string $value, string $column = 'id');
}