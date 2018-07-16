<?php

namespace App\Http\Controllers\Admin;

use App\VitalGym\Entities\Plan;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();

        return view('admin.plans.index', compact('plans'));
    }
}
