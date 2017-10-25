<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\VitalGym\Entities\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->orderBy('id', 'DESC')->paginate();

        $data = [
            'total'         => $users->total(),
            'per_page'      => $users->perPage(),
            'current_page'  => $users->currentPage(),
            'last_page'     => $users->lastPage(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
            'from'          => $users->firstItem(),
            'to'            => $users->lastItem(),
            'data'          => $users->items()
        ];

        return $data;
    }
}
