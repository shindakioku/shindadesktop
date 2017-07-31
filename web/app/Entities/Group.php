<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    /**
     * @var string
     */
    protected $table = 'music_groups';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function music(): HasMany
    {
        return $this->hasMany(Music::class);
    }
}