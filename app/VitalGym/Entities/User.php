<?php

namespace App\VitalGym\Entities;

use App\Filters\Traits\Filterable;
use App\Filters\UserFilter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'name',
        'last_name',
        'nick_name',
        'avatar',
        'address',
        'password',
        'role',
        'active',
        'last_login',
    ];

    protected $filters = UserFilter::class;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function token()
    {
        return $this->hasOne(ActivationToken::class);
    }

    public function getStatusAttribute()
    {
        return $this->attributes['active'] ? 'activo' : 'inactivo';
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['name'].$this->attributes['last_name'];
    }
}
