<?php

namespace App\VitalGym\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalPriceInDollarsAttribute()
    {
        return number_format($this->total_price / 100, 2);
    }
}
