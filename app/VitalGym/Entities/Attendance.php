<?php

namespace App\VitalGym\Entities;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
