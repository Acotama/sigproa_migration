<?php

namespace sayhuite\Http\Controllers\Api;

use Illuminate\Http\Request;
use sayhuite\Http\Controllers\Controller;

class UserController extends Controller
{
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
