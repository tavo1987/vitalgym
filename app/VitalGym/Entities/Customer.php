<?php

namespace App\VitalGym\Entities;

use App\Traits\PerPageTrait;
use App\Filters\CustomerFilter;
use App\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Filterable, PerPageTrait;

    protected $filters = CustomerFilter::class;

    protected $guarded = [];

    protected $dates = ['birthdate'];

    protected $with = ['user'];

    public function Memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function routine()
    {
        return $this->belongsTo(Routine::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->user->name} {$this->user->last_name}";
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function getAvatarAttribute()
    {
        return $this->user->avatar;
    }

    public function getLastNameAttribute()
    {
        return $this->user->last_name;
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }

    public function getAddressAttribute()
    {
        return $this->user->address;
    }

    public function getCellPhoneAttribute()
    {
        return $this->user->cell_phone;
    }
}
