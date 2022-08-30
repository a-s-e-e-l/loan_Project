<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'Required',
            'email' => 'Required|email|unique:admins',
            'password' => 'Required|min:6',
            'password_confirmation' => 'required|same:password|min:6',
        ]);
        if ($validator->fails()) {
            $msg = $validator->errors();
            return redirect()->back()->withErrors(['error' => $msg]);
        }
        $password = Crypt::encrypt($request->password);
        $form_data = array(
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        );
        Admin::create($form_data);
//        Auth::login($admin);
        return redirect()->to('/dashboard');
//        auth()->login($admin);
//        $admin->createToken('auth_token')->plainTextToken;
//        return view('/dashboard')->with('data', $admin);
    }
//
//    public function __construct()
//    {
//        $this->middleware('guest');
//    }
//
//    protected function validator(Request $request)
//    {
//        return Validator::make($request, [
//            'name' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
//        ]);
//    }

//    protected function create(Request $request)
//    {
//        return Admin::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password)
//        ]);
//    }
}
