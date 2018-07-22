<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\VitalGym\Entities\Level;


class CustomerController extends Controller
{
    public function create()
    {
        $levels = Level::all();

        return view('admin.customers.create', compact('levels'));
    }
}
