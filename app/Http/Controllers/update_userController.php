<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Array_;

class update_userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
    public function update(Request $request)
    {
        $user = Auth::user();
//        if (empty($user)) {
//            $response = [
//                'Error' => "user no login   Error token",
//            ];
//            return response($response, 200);
//        } else {
        $validator = Validator::make($request->all(), [
            'first_name' => 'Required',
            'last_name' => 'Required',
            'email' => 'Required|email|max:32',
            'address' => 'Required',
            'image' => 'mimes:png,jpg,jpeg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $file = null;
        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $file = $request->image->storeAs('images', $filename, 'public');
        }
        $user->update(array_merge(
            $validator->validated(), [
                'image' => $file,
            ]
        ));
        $response = [
            'Message' => 'user',
            'data' => $user,
            'success' => true,
        ];
        return response($response, 200);
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function edit()
    {
        $user = Auth::user();
        $response = [
            'Message' => 'user',
            'data' => $user,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function setup(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'first_name' => 'Required',
            'last_name' => 'Required',
            'email' => 'Required|email|max:32',
            'address' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $user->update($validator->validated());
        $response = [
            'Message' => 'user',
            'data' => $user,
            'success' => true,
        ];
        return response($response, 200);
    }
}
