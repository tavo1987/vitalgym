<?php

namespace App\Http\Controllers\Admin;

use App\VitalGym\Entities\Level;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function create()
    {
        $levels = Level::all();

        return view('admin.customers.create', compact('levels'));
    }
}
