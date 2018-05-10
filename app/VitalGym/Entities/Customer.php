<?php

namespace App\VitalGym\Entities;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $with = ['user'];

    public function Memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->user->first_name} {$this->user->last_name}";
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function getLastNameAttribute()
    {
        return $this->user->last_name;
    }
}
