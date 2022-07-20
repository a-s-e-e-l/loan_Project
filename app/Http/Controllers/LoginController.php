<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $fields=$request->validate([
            'phone_number'=>'Required',
            'Enter_code'=>'Required',
        ]);

        $user = User::where('phone_number',$fields['phone_number'])
                        ->where('activation_code', $fields['Enter_code'])
                        ->first();
        if (empty($user)) {
            $response = [
                'msg' => "Error , You entered wrong code",
            ];
            return response($response, 200);
        }else{
            $token = $user->createToken('user_token')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
            ];
            return response($response, 200);
        }
    }
}
