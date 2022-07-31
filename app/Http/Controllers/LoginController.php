<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'code' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $user = User::where('phone_number', $request['phone_number'])->first();
        if (empty($user)) {
            $response = [
                'message' => 'No user wrong mobile phone',
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        } else {
            $user = User::where('phone_number', $request['phone_number'])
                ->where('activation_code', $request['code'])
                ->first();
            if (empty($user)) {
                $response = [
                    'message' => 'You entered wrong code',
                    'data' => null,
                    'success' => false,
                ];
                return response($response, 200);
            } else {
                $user->activation_code = null;
                $user->save();
                $token = $user->createToken('auth_token')->plainTextToken;
                $response = [
                    'message' => 'token user',
                    'data' => [
                        'token' => $token,
                        'draft' => $user->draft,
                    ],
                    'success' => true,
                ];
                return response($response, 200);
            }
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        $response = [
            'message' => 'You have been successfully logged out',
            'data' => null,
            'success' => true,
        ];
        return response($response, 200);
    }
}
