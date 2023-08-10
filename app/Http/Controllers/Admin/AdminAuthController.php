<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;

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
        $data['purchased_total_cost'] = Order::sum('grand_total');

        $months = [
            date('M', strtotime('-5 months')),
            date('M', strtotime('-4 months')),
            date('M', strtotime('-3 months')),
            date('M', strtotime('-2 months')),
            date('M', strtotime('-1 month')),
            date('M'),
        ];
        $data['months'] = $months;

        $data['last_year_sales'] = [];
        for($i = 0; $i < count($months); $i++) {
            $order = Order::select('grand_total')->whereRaw("YEAR(DATE(created_at)) = '". date('Y', strtotime('-1 year')) ."' and MONTH(DATE(created_at)) = '". date('m', strtotime($months[$i])) ."'")->get();
            // dd($months, $order);
            $data['last_year_sales'][] = ($order) ? $order->sum('grand_total') : 0;
        }
        $data['current_year_sales'] = [];
        for($i = 0; $i < count($months); $i++) {
            $order = Order::select('grand_total')->whereRaw("YEAR(DATE(created_at)) = '". date('Y') ."' and MONTH(DATE(created_at)) = '". date('m', strtotime($months[$i])) ."'")->get();
            // dd($months, $order);
            $data['current_year_sales'][] = ($order) ? $order->sum('grand_total') : 0;
        }

        // echo implode(', ', $data['months']); exit;

        // dd($data['months'], $data['last_year_sales'], $data['current_year_sales']);

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
