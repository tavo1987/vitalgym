<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\VitalGym\Entities\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('customer')->orderByDesc('id')->paginate();

        return view('admin.attendances.index', compact('attendances'));
    }
}
