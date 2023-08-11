<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function contact_form_submit(Request $request) {
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];
        \Mail::to(env('ADMIN_MAIL'))->send(new \App\Mail\ContactMail($details));
        if($request->ajax()) {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Contact us form submitted successfully',
            ]);
        }
        return redirect()->route('root');
    }
}
