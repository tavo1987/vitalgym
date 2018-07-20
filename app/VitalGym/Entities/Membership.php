<?php

namespace App\VitalGym\Entities;

use App\Filters\MembershipFilter;
use App\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use Filterable;

    protected $guarded = [];

    protected $dates = ['date_start', 'date_end'];

    protected $filters = MembershipFilter::class;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
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
            'name'        => $this->plan->name,
            'unit_price'  => $this->plan->price,
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
