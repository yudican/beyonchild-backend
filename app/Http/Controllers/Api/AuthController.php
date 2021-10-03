<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
        preg_match_all($pattern, $request->username, $matches);

        if (count($matches[0]) > 0) {
            $user = User::where('email', $request->username)->first();
        } else {
            $user = User::where('username', $request->username)->first();
        }

        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);


        if ($validate->fails()) {
            $respon = [
                'error' => true,
                'status_code' => 401,
                'message' => 'Silahkan isi semua form yang tersedia',
                'messages' => $validate->errors(),
            ];
            return response()->json($respon, 401);
        }

        if (!$user) {
            return response()->json([
                'error' => true,
                'status_code' => 401,
                'message' => 'Unathorized, Username atau Email yang kamu masukkan tidak terdaftar'
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            $respon = [
                'error' => true,
                'status_code' => 401,
                'message' => 'Unathorized, password yang kamu masukkan tidak sesuai',
            ];
            return response()->json($respon, 401);
        }

        $credential = ['username' => $request->username, 'password' => $request->password];
        if (count($matches[0]) > 0) {
            $credential = ['email' => $request->username, 'password' => $request->password];
        }

        if (!Auth::attempt($credential)) {
            $respon = [
                'error' => true,
                'status_code' => 401,
                'message' => 'Unathorized, Username atau Email yang kamu masukkan tidak terdaftar'
            ];
            return response()->json($respon, 401);
        }



        $tokenResult = $user->createToken('token-auth')->plainTextToken;
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Login successfully',
            'data' => [
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => new UserResource($user)
            ]
        ];
        return response()->json($respon, 200);
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'fullname' => 'required',
            'username' => 'required|min:6',
            'email' => 'required|email|email',
            'password' => 'required|min:8',
        ]);

        if ($validate->fails()) {
            $respon = [
                'error' => true,
                'status_code' => 401,
                'message' => 'Silahkan isi semua form yang tersedia',
                'messages' => $validate->errors(),
            ];
            return response()->json($respon, 401);
        }

        // validate username
        $username = User::where('username', $request->username)->first();
        if ($username) {
            $respon = [
                'error' => false,
                'status_code' => 400,
                'message' => 'Username has already registered by another user!',
                'data' => []
            ];

            return response()->json($respon, 400);
        }

        // validate email
        $email = User::where('email', $request->email)->first();
        if ($email) {
            $respon = [
                'error' => false,
                'status_code' => 400,
                'message' => 'Email has already registered by another user!',
                'data' => []
            ];

            return response()->json($respon, 400);
        }

        // validate username and password
        if (strtolower($request->username) == strtolower($request->password)) {
            $respon = [
                'error' => false,
                'status_code' => 400,
                'message' => 'Password cannot same with username',
                'data' => []
            ];

            return response()->json($respon, 400);
        }

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $role_member = Role::where('role_type', 'member')->first();
            $user->roles()->attach($role_member->id);
            $user->teams()->attach(1, ['role' => $role_member->role_type]);

            $respon = [
                'error' => false,
                'status_code' => 200,
                'message' => 'Register successfully',
                'data' => new UserResource($user)
            ];

            DB::commit();
            return response()->json($respon, 200);
        } catch (\Throwable $th) {
            DB::rollback();

            $respon = [
                'error' => false,
                'status_code' => 400,
                'message' => 'Register failed please try again!' . $th->getMessage(),
                'data' => []
            ];

            return response()->json($respon, 400);
        }
    }
}
