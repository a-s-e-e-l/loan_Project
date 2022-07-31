<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class notificationController extends Controller
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function add_notification_to(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'type' => 'Required',
            'data' => 'Required',
            'nontice_from' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        } else {
            $id = User::where('phone_number', $request['nontice_from'])->first();
            $notification_data = array(
                'user_id' => $id['id'],
                'type' => $request['type'],
                'data' => $request['data'],
                'nontice_from' => $user['phone_number'],
                'notifiable_id' => $id['id'],
                'notifiable_type' => $request['type'],
            );
            $notification = Notification::Create($notification_data);
            $response = [
                'Message' => 'Notifications',
                'data' => $notification,
                'success' => true,
            ];
            return response($response, 200);
        }
    }

    public function add_notification_from(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'type' => 'Required',
            'data' => 'Required',
            'nontice_from' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        } else {
            $notification_data = array(
                'user_id' => $user['id'],
                'type' => $request['type'],
                'data' => $request['data'],
                'nontice_from' => $request['nontice_from'],
                'notifiable_id' => $user['id'],
                'notifiable_type' => $request['type'],
            );
            $notification = Notification::Create($notification_data);
            $response = [
                'Message' => 'Notifications',
                'data' => $notification,
                'success' => true,
            ];
            return response($response, 200);
        }
    }

    public function all_notification()
    {
        $user = Auth::user();
        $notifications = Notification::where('notifiable_id', $user['id'])
            ->with('users_from')->sortByDesc('created_at')->paginate(5);
        $response = [
            'Message' => 'Notifications',
            'data' => $notifications,
            'success' => true,
        ];
        return response($response, 200);
    }
}
