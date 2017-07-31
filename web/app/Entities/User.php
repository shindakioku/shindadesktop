<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function favorite(): HasMany
    {
        return $this->hasMany(UserFavorite::class);
    }

    /**
     * @return mixed
     */
    public function favoriteAnime()
    {
        return $this->hasMany(UserFavorite::class)->where('entity', Anime::class);
    }

    /**
     * @return mixed
     */
    public function favoriteMusic()
    {
        return $this->hasMany(UserFavorite::class)->where('entity', Music::class);
    }
}
