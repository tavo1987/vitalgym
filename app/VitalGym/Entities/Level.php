<?php

namespace App\Vitalgym\Entities;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['name'];

    public function routines()
    {
        return $this->hasMany(Routine::class);
    }
}
