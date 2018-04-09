<?php

namespace App\Http\Controllers;

use App\VitalGym\Entities\Order;
use App\VitalGym\Entities\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\MembershipOrderConfirmationEmail;

class MembershipController extends Controller
{
    public function store()
    {
        $order = Order::create([
            'date_start' => request('date_start'),
            'date_end' => request('date_end'),
            'total_days' => request('total_days'),
            'membership_id' => request('membership_id'),
            'customer_id' => request('customer_id'),
        ]);

        Payment::create([
            'order_id' => $order->id,
            'customer_id' => request('customer_id'),
            'total_price' => $order->membership->price * request('quantity'),
            'membership_quantity' => request('quantity'),
            'user_id' => auth()->user()->id,
        ]);

        Mail::to($order->customer->email)->send(new MembershipOrderConfirmationEmail($order));

        return response()->json([], 201);
    }
}
