<?php

namespace App\Filters;

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\User;

class MembershipFilter extends Filter
{
    public function name($name)
    {
        $userIds = User::whereRole('customer')->where('name', 'like',"%{$name}%")->pluck('id');
        $customerIds = Customer::whereIn('user_id', $userIds)->pluck('id');

        return $this->builder->whereIn('customer_id', $customerIds);
    }

    public function email($email)
    {
        $userIds = User::whereRole('customer')->where('email', 'like',"%{$email}%")->pluck('id');
        $customerIds = Customer::whereIn('user_id', $userIds)->pluck('id');

        return $this->builder->whereIn('customer_id', $customerIds);
    }
}
