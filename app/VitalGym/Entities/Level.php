<?php

namespace App\Vitalgym\Entities;

use App\Traits\PerPageTrait;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use PerPageTrait;

    protected $fillable = ['name'];

    public function routines()
    {
        return $this->hasMany(Routine::class);
    }
}
