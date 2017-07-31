<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnimeSeries extends Model
{
    /**
     * @var string
     */
    protected $table = 'anime_series';

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
}
