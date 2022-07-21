<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Code_requestController extends Controller
{
    public function code_request(Request $request)
    {
        $code = mt_rand(1000,9999);
        $fields=$request->validate(['phone_number'=>'Required|string']);
        /** @noinspection PhpUndefinedMethodInspection */
        $user = User::where('phone_number',$fields['phone_number'])->first();
        if (empty($user)) {
            $form_data = array(
                'phone_number'  =>  $request->input('phone_number'),
                'activation_code' =>  $code,
            );
            /** @noinspection PhpUndefinedMethodInspection */
            User::create($form_data);
        }else{
            $user->activation_code = $code;
            $user->update();
        }
        $response = [
            'activation_code' => $code
        ];
        return response($response, 200);
    }
}
