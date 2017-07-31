<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_favorite';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function anime()
    {
        return $this->hasOne(Anime::class, 'id', 'entity_id')->where('entity', Anime::class);
    }

    /**
     * @return mixed
     */
    public function music()
    {
        return $this->hasOne(Music::class, 'id', 'entity_id')->where('entity', Music::class);
    }
}
