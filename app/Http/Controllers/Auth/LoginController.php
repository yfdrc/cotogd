<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\Dianpu;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This script handles authenticating users for the application and
    | redirecting them to your home screen. The script uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new script instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username()
    {
        return 'name';
    }

    protected function attemptLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->name, 'password' => $request->password], $request->has('remember'))) {
            return true;
        } else {
            if (Auth::attempt(['name' => $request->name, 'password' => $request->password], $request->has('remember'))) {
                return true;
            }
            return false;
        }
    }

    protected function authenticated()
    {
        $cookie1 = cookie('user', Auth::user()->name);
        $cookie2 = cookie('dp', Dianpu::find(Auth::user()->dianpu_id)->name);
        return redirect('/')->cookie($cookie1)->cookie($cookie2);
    }

}
