<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\Product;

class AdminAuthController extends Controller
{
    public function getLogin(){
        $data['login_url'] = route('adminLoginPost');
        return view('adminlte.login', $data);
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
            $user = auth()->guard('admin')->user();

            if($user->hasRole('admin') || $user->role == 'admin'){
                return redirect()->route('adminDashboard')->with('success','You are Logged in sucessfully.');
            } else {
                auth()->guard('admin')->logout();
                Session::flush();
                return back()->with('error','Whoops! invalid email and password.');
            }
        }else {
            return back()->with('error','Whoops! invalid email and password.');
        }
    }

    public function adminDashboard(Request $request) {
        $data = [];
        $data['users_count'] = User::where('role', 'user')->count();
        $data['vendors_count'] = User::where('role', 'vendor')->count();
        $data['products_count'] = Product::count();
        return view('adminlte.dashboard', $data);
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('adminLogin'));
    }
}
