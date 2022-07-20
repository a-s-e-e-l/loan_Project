<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Code_requestController extends Controller
{
    public function code_request()
    {
        $code = mt_rand(1000,9999);
        $response = [
            'code' => $code
        ];
        return response($response, 200);
    }
}
