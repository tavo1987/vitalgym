<?php

namespace App\Filters;

use App\VitalGym\Entities\Routine;
use App\VitalGym\Entities\Level;

class LevelFilter extends Filter
{
    public function name($name)
    {
        $routinesIds = Routine::whereRole('customer')->where('name', 'like', "%{$name}%")->pluck('id');
        $levelIds = Level::whereIn('level_id', $routinesIds)->pluck('id');

        return $this->builder->whereIn('level_id', $levelIds);
    }

    public function email($email)
    {
        /*$userIds = User::whereRole('customer')->where('email', 'like', "%{$email}%")->pluck('id');
        $customerIds = Customer::whereIn('user_id', $userIds)->pluck('id');

        return $this->builder->whereIn('customer_id', $customerIds);*/
    }
}
