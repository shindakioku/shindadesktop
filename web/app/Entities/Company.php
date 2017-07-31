<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function anime(): HasMany
    {
        return $this->hasMany(Anime::class, 'company_id');
    }
}