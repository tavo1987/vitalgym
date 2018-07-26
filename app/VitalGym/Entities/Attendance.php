<?php

namespace App\VitalGym\Entities;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $dates = ['date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
