<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Anime extends Model
{
    /**
     * @var string
     */
    protected $table = 'anime';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function series(): HasMany
    {
        return $this->hasMany(AnimeSeries::class);
    }

    /**
     * @return HasMany
     */
    public function musicToAnime(): HasMany
    {
        return $this->hasMany(MusicToAnime::class);
    }

    /**
     * @return HasOne
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id');
    }
}
