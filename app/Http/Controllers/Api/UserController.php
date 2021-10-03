<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChildrenResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfile()
    {
        $user = auth()->user();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => new UserResource($user)
        ];
        return response()->json($respon, 200);
    }
}
