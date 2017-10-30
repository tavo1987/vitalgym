<?php

namespace App\Http\Controllers\Api;

use App\VitalGym\Entities\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $order = request('sort') ? collect(explode('|', request('sort'))) : collect(['id', 'DESC']);
        $users = User::with('profile')->orderBy($order->first(), $order->last())->paginate();

        $data = [
            'total'         => $users->total(),
            'per_page'      => $users->perPage(),
            'current_page'  => $users->currentPage(),
            'last_page'     => $users->lastPage(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
            'from'          => $users->firstItem(),
            'to'            => $users->lastItem(),
            'data'          => $users->items(),
        ];

        return $data;
    }
}
