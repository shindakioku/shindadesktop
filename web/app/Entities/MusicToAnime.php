<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MusicToAnime extends Model
{
    /**
     * @var string
     */
    protected $table = 'music_to_anime';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return HasOne
     */
    public function anime(): HasOne
    {
        return $this->hasOne(Anime::class);
    }

    /**
     * @return HasOne
     */
    public function music(): HasOne
    {
        return $this->hasOne(Music::class, 'id');
    }
}
