<?php

namespace App\VitalGym\Entities;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $guarded = [];

    protected $dates = ['date_start', 'date_end'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
