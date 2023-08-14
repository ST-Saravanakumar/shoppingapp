<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Socialite;

use App\Models\User;

class LoginController extends Controller
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function postLogin(Request $request) {
        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // do whatever yo desire
    
            $user = \Auth::user();

            if($user->role == 'admin') {
                auth()->logout();
                // session()->flash('error', 'Invalid Credentials');
                return redirect()->route('login')->with('error', 'Invalid Credentials');
            }
        
            return redirect()->route('root')->with('success', 'Welcome, '.ucfirst(auth()->user()->first_name));
        } else {
            return redirect()->route('login')->with('error', 'Invalid Credentials');
        }
    }

    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            $newUser                    = new User;
            $newUser->provider_name     = $driver;
            $newUser->provider_id       = $user->getId();
            $newUser->name              = $user->getName();
            $newUser->password          = '';
            $newUser->first_name        = $user->getName();
            $newUser->last_name         = $user->getName();
            $newUser->email             = $user->getEmail();
            // we set email_verified_at because the user's email is already veridied by social login portal
            $newUser->email_verified_at = now();
            // you can also get avatar, so create avatar column in database it you want to save profile image
            // $newUser->avatar            = $user->getAvatar();
            $newUser->save();

            auth()->login($newUser, true);
        }

        return redirect()->route('dashboard')->with('success', 'Loggedin successfully');
    }
}
