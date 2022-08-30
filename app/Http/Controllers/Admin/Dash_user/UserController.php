<?php

namespace App\Http\Controllers\Admin\Dash_user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('draft', 0)->get();
        return view('Users.index', compact('users'));
    }

    public function create()
    {
        return view('Users.create');
    }

    public function store(Request $request)
    {
        $user = User::create([
            'phone_number' => $request->phone_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'address' => $request->address,
            'draft' => false,
        ]);
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $user['image'] = $filename;
            $user->save();
        }
//        User::create($form_data);
        return redirect()->to('users');
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return view('Users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('Users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $user['image'] = $filename;
            $user->save();
        }
        User::where('id', $id)->update([
            'phone_number' => $request->phone_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'address' => $request->address,
//            'image' => 'storage/' . $file,
        ]);
        return redirect()->to('users');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->to('users');
    }
}
