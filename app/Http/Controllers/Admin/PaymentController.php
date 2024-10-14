<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\VitalGym\Entities\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('customer', 'user', 'membership.plan')->orderByDesc('created_at')->paginate();

        return view('admin.payments.index', compact('payments'));
    }
}
