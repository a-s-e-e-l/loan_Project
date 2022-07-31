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
            'Enter_code' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $user = User::where('phone_number', $request['phone_number'])->first();
        if (empty($user)) {
            $response = [
                'Message' => 'No user wrong mobile phone',
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        } else {
            $user = User::where('phone_number', $request['phone_number'])
                ->where('activation_code', $request['Enter_code'])
                ->first();
            if (empty($user)) {
                $response = [
                    'Message' => 'You entered wrong code',
                    'data' => null,
                    'success' => false,
                ];
                return response($response, 200);
            } else {
                $user->activation_code = null;
                $user->save();
                $token = $user->createToken('auth_token')->plainTextToken;
                $response = [
                    'Message' => 'User add with token',
                    'data' => [
                        'user' => $user,
                        'token' => $token,
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
            'Message' => 'You have been successfully logged out',
            'data' => null,
            'success' => true,
        ];
        return response($response, 200);
    }

}
