<?php

namespace App\Http\Controllers;

use App\Mail\MembershipConfirmationEmail;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Support\Facades\Mail;

class MembershipController extends Controller
{
    public function store()
    {
        $membership = Membership::create([
            'date_start' => request('date_start'),
            'date_end' => request('date_end'),
            'total_days' => request('total_days'),
            'membership_type_id' => request('membership_type_id'),
            'customer_id' => request('customer_id'),
        ]);

        $membershipType = MembershipType::findOrFail(request('membership_type_id'));
        $totalPrice = request('quantity') * $membershipType->price;

        Payment::create([
            'membership_id' => $membership->id,
            'customer_id' => request('customer_id'),
            'total_price' =>$totalPrice,
            'membership_quantity' => request('quantity'),
            'user_id' => auth()->user()->id,
        ]);

        $customer = Customer::with('user')->findOrFail(request('customer_id'));

        Mail::to($customer->user->email)->send(new MembershipConfirmationEmail($membership));
        return response()->json([], 201);
    }
}
