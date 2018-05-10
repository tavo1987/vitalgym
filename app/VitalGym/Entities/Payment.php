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
}
