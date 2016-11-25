<?php

namespace App\VitalGym\Entities;

use Illuminate\Database\Eloquent\Model;

class ActivationToken extends Model
{
    protected $table = 'activation_tokens';

    protected $fillable = ['token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'token';
    }
}
