<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Hash as Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class UserAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function viewLogin()
    {
        if (Auth::user()) {
            return redirect()->intended('home');
        }
        return view('users.login');
    }

    /**
     * @param UserLoginRequest $request
     * @return View|\Illuminate\Http\RedirectResponse
     */
    public function login(UserLoginRequest $request)
    {
        $user = (new Customer)->byEmail($request->get('email'))->first();
        if ($user) {
            if (Hash::check($request->get('password'), $user->password)) {
                Auth::loginUsingId($user->id);
                return redirect()->intended('home');
            }
        }
        return view('users.login')->withErrors(['clave' => 'credenciales incorrectas']);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToLogin()
    {
        return redirect('/');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function home()
    {
        if (!Auth::user()) {
            return $this->redirectToLogin();
        }
        return view('users.home');
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        Auth::logout();
        return $this->redirectToLogin();
    }
}
