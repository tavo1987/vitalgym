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

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function toArray()
    {
        return [
            'date_start' => $this->date_start->toDateString(),
            'date_end' => $this->date_end->toDateString(),
            'total_days' => $this->total_days,
            'name'        => $this->membershipType->name,
            'unit_price'  => $this->membershipType->price,
            'created_by' => $this->payment->user->full_name,
            'total_price' => $this->payment->total_price,
            'membership_quantity' => $this->payment->membership_quantity,
            'customer' => [
                'name' => $this->customer->name,
                'last_name' => $this->customer->last_name,
                'email' => $this->customer->email,
            ],
        ];
    }
}
