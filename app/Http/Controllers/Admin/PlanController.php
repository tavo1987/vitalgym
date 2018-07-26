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

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store()
    {
        $validatedData = request()->validate([
            'name' => 'required|max:60',
            'price' => 'required|integer',
            'is_premium' => 'required|boolean',
        ]);

        Plan::create($validatedData);

        return redirect()->route('admin.plans.index')->with(['alert-type' => 'success', 'message' => 'Plan creado con éxito']);
    }
}
