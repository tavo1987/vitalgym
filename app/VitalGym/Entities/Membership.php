<?php

namespace App\VitalGym\Entities;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $guarded = [];

    protected $dates = ['date_start', 'date_end'];
}
