<?php

namespace App\Http\Controllers\Admin;

use App\VitalGym\Entities\Plan;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\VitalGym\Entities\Membership;
use App\Mail\MembershipOrderConfirmationEmail;
use App\Http\Requests\CreateMembershipFormRequest;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::all();

        return view('admin.memberships.index', compact('memberships'));
    }

    public function create($planId)
    {
        $plan = Plan::findOrFail($planId);
        $customers = Customer::all();

        return view('admin.memberships.create', compact('customers', 'plan'));
    }

    public function store(CreateMembershipFormRequest $request, $planId)
    {
        $plan = Plan::find($planId);
        $payment = Payment::create([
            'customer_id' => $request->get('customer_id'),
            'total_price' => $plan->price * $request->get('membership_quantity'),
            'membership_quantity' => $request->get('membership_quantity'),
            'user_id' => auth()->user()->id,
        ]);

        $membership = $payment->membership()->create([
            'date_start' => $request->get('date_start'),
            'date_end' => $request->get('date_end'),
            'total_days' => $request->get('total_days'),
            'plan_id' => $plan->id,
            'customer_id' => $payment->customer_id,
        ]);

        Mail::to($membership->customer->email)->send(new MembershipOrderConfirmationEmail($membership));

        return redirect()->route('admin.memberships.index')->with(['message' => 'Membresía guardada con éxito', 'alert-type' => 'success']);
    }
}
