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

    public function store()
    {
        $validatedData = request()->validate([
           'date' => 'required|date',
           'customer_id' => 'required|exists:customers,id',
        ]);

        Attendance::create($validatedData);

        return redirect()->route('admin.attendances.index')
                         ->with(['alert-type' => 'success', 'message' => 'Asistencia Registrada con éxito']);
    }
}
