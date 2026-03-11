<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'message' => 'User fetched successfully.',
            'user' => User::all(),
        ], 200);
    }
}