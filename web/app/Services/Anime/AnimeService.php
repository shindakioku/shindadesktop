<?php

namespace App\Services\Anime;

use App\Entities\Anime;
use App\Entities\Company;
use Illuminate\Support\Collection;

class AnimeService implements AnimeContract
{
    /**
     * @return Collection
     */
    public function all(int $skip = 0, int $take = 10): Collection
    {
        return Anime::with(['series', 'musicToAnime', 'musicToAnime.music', 'company'])->skip($skip)->take($take)->get();
    }

    /**
     * @return Collection
     */
    public function forShinda(int $skip = 0, int $take = 10): Collection
    {
        return Anime::skip($skip)->take($take)->get(['id', 'title', 'image_name', 'image_url']);
    }

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getAnime(?string $value, string $column = 'id')
    {
        if (!($anime = Anime::with(['series', 'musicToAnime', 'musicToAnime.music', 'company'])->where($column, $value)->first())) {
            return ['error'];
        }

        return $anime;
    }

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getCompany(?string $value, string $column = 'id')
    {
        if (!($company = Company::where($column, $value)->first())) {
            return ['error'];
        }

        return $company;
    }

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getAnimeForCompany(?string $value, string $column = 'id')
    {
        if (is_array($company = $this->getCompany($value, $column))) {
            return $company;
        }

        return $company->anime;
    }

    /**
     * @param null|string $value
     * @param string $column
     * @return array|Collection
     */
    public function getSoundTracks(?string $value, string $column = 'id')
    {
        if (is_array($anime = $this->getAnime($value, $column))) {
            return $anime;
        }

        return $anime->musicToAnime;
    }
}