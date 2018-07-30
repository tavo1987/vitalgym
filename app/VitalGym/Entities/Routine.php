<?php

namespace App\VitalGym\Entities;

use App\Filters\LevelFilter;
use App\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PerPageTrait;

class Routine extends Model
{
    use Filterable, PerPageTrait;

    protected $fillable = [
        'level_id', 'name', 'file', 'description',
    ];

    protected $filters = LevelFilter::class;

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
