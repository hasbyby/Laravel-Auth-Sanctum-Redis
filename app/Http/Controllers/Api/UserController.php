<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function get(Request $request)
    {

        $user_id = Auth::user()->id;
        // dd(' ID USER ', $user_id);
        return 'ID USER = '. $user_id;

    }
}
