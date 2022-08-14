<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Code_requestController extends Controller
{
    public function code_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
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
        $code = mt_rand(1000, 9999);
        if (empty($user)) {
            $form_data = array(
                'phone_number' => $request ['phone_number'],
                'activation_code' => $code,
            );
            User::create($form_data);
        } else {
            $user->activation_code = $code;
            $user->save();
        }
        $response = [
            'message' => 'Code',
            'data' => $code,
            'success' => true,
        ];
        return response($response, 200);
    }
}
