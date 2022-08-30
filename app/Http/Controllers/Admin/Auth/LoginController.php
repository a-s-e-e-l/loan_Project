<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';


//    public function __construct()
//    {
//        $this->middleware('auth')->except('logout');
//    }

//    protected function authenticated(Request $request, $user)
//    {
//        //check if the previous page route name is 'congresses.registration'
//        if (Route::getRoutes()->match(Request::create(URL::previous()))->getName() == 'congresses.registration') {
//            //redirect to previous page with parameters
//            return redirect(Request::create(URL::previous())->getRequestUri());
//        }
//        return redirect()->intended($this->redirectTo);
//
//    }
//    public function store(Request $request)
//    {
//        $request->authenticate();
//
//        $request->session()->regenerate();
//
//        return redirect()->intended(RouteServiceProvider::HOME);
//    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'Required',
            'password' => 'Required',
        ]);
//        $validator = Validator::make($request->all(), [
//            'email' => 'Required',
//            'password' => 'Required',
//        ]);
//        if ($validator->fails()) {
//            $msg = $validator->errors();
//            return redirect()->back()->withErrors(['error' => $msg]);
//        }
        $admin = Admin::where('email', $request['email'])->first();
        if (!$admin) {
            $msg = 'Login Fail, please check email';
            return redirect()->back()->withErrors(['email' => $msg]);
        }
        $decrypt = Crypt::decrypt($admin->password);
        if (!$decrypt)
            throw new DecryptException("Invalid data.");
        if ($request->password != $decrypt) {
            $msg = 'Login Fail, please check password';
            return redirect()->back()->withErrors(['password' => $msg]);
        }
        Auth::login($admin);
        return redirect()->to('/dashboard');
//        auth()->login($admin);
//        $admin->createToken('auth_token')->plainTextToken;
//        return redirect()->to('/dashboard')->with('data', $admin);
    }

}
