<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class update_userController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'first_name' => 'Required',
            'last_name' => 'Required',
            'email' => 'Required|email|max:32',
            'date_of_birth' => 'Required',
            'address_line1' => 'Required',
            'address_line2' => 'Required',
            'address' => 'Required',
            'image' => 'mimes:png,jpg,jpeg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $file = $request->image->storeAs('images', $filename, 'public');
            $user->update(array_merge(
                $validator->validated(), [
                    'image' => 'storage/' . $file,
                ]
            ));
        }
        $user = collect($user)->only(['phone_number', 'first_name', 'last_name', 'email',
            'date_of_birth', 'address', 'address_line1', 'address_line2', 'image']);
        $response = [
            'message' => 'User',
            'data' => $user,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function edit()
    {
        $user = Auth::user();
        $user = collect($user)->only(['phone_number', 'first_name', 'last_name', 'email',
            'date_of_birth', 'address', 'address_line1', 'address_line2', 'image']);
        $response = [
            'message' => 'user',
            'data' => $user,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function signup(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'first_name' => 'Required',
            'last_name' => 'Required',
            'email' => 'Required|email|max:32',
            'date_of_birth' => 'Required',
            'address_line1' => 'Required',
            'address_line2' => 'Required',
            'address' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $user->update(array_merge(
            $validator->validated(), [
                'draft' => false,
            ]
        ));
        $user = collect($user)->only(['phone_number', 'first_name', 'last_name', 'email',
            'date_of_birth', 'address', 'address_line1', 'address_line2', 'image']);
        $response = [
            'message' => 'User',
            'data' => $user,
            'success' => true,
        ];
        return response($response, 200);
    }
}
