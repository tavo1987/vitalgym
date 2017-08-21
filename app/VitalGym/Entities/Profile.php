<?php

namespace App\VitalGym\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'nick_name',
        'avatar',
        'address',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function getFullNameAttribute()
    {
        return $this->attributes['name'].' '.$this->attributes['last_name'];
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
