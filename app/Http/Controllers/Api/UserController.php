<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function get(Request $request)
    {
        return [
            'user' => Auth::user(),
            'user_id' => Auth::user()->id,
        ];
    }
}
