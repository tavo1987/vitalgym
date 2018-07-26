<?php

namespace App\Http\Controllers\Admin;

use App\VitalGym\Entities\Customer;
use App\Http\Controllers\Controller;
use App\VitalGym\Entities\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('customer')->orderByDesc('id')->paginate();

        return view('admin.attendances.index', compact('attendances'));
    }

    public function create()
    {
        $customers = Customer::with('user')->orderByDesc('id')->paginate();

        return view('admin.attendances.create', compact('customers'));
    }
}
