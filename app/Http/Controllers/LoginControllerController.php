<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginControllerController extends Controller
{
    public function login(Request $request)
    {
        $fields=$request->validate(['phone_number'=>'Required|string']);
        $user = User::where('phone_number',$fields['phone_number'])->first();
        if (empty($user)) {
            $form_data = array(
                'phone_number'  =>  $request->phone_number,
                'first_name' =>  $request->first_name,
                'last_name' =>  $request->last_name,
                'email' =>  $request->email, 
                'address' =>  $request->address,
                'image' =>  $request->image,
            );
            $user = User::create($form_data);
        }
        $token = $user->createToken('user_token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];return response($response, 200);

    }
}
