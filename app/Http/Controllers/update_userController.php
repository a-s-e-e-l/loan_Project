<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $phone_number
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            $response = [
                'Error' => "wrong mobile phone",
            ];
            return response($response, 200);
        } else {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $vimage = $request->file('file');
            if (!empty($vimage)) {
                $request->validate([
                    'phone_number' => 'Required|string',
                    'file' => 'required|mimes:png,jpg,jpeg,gif|max:2048',
                ]);
                if ($request->file('file')) {
                    $file = $request->file('file')->store('public/files');
                    $user->image = $file;
                    $user->update();
                    $response = [
                        "message" => "File successfully uploaded",
                        'user' => $user,
                    ];
                    return response($response, 200);
                }
            } else {
                $user->update();
                $response = [
                    'user' => $user,
                ];
                return response($response, 200);
            }
        }


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
}
