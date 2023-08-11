<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\Setting;
use App\Traits\CrudTrait;

class SettingController extends Controller
{
    // use CrudTrait;

    // public function model() {
    //     return Setting::class;
    // }

    public function validationRules($resource_id = null) {
        $rules = [
            'stripe_public_key'     =>  ['required', 'string', 'max:255'],
            'stripe_secret_key'          =>  ['required', 'string', 'max:255'],
            'stripe_mode' => ['required'],
        ];

        if(request()->file('site_logo')) {
            $rules['site_logo'] = 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:4096';
        }

        return $rules;
    }

    public function module() {
        return 'settings';
    }

    public function index(Request $request)
    {
        $data['data'] = [];
        if ($request->isMethod('POST')) {

            $validator = Validator::make($request->all(), $this->validationRules());

            if($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            // $image = Image::load($request->site_logo)->save();

            $data = [];
            $data['stripe_public_key'] = $request->stripe_public_key;
            $data['stripe_secret_key'] = $request->stripe_secret_key;
            $data['stripe_mode'] = $request->stripe_mode;
            foreach($data as $name => $value) {
                Setting::where('name', $name)->update(['value' => $value]);
            }
            if($request->has('site_logo')) {
                $site_logo = Setting::where('name', 'site_logo')->first();
                $site_logo->addMediaFromRequest('site_logo')->toMediaCollection('settings');
            }
            session()->flash('success', 'Updated Successfully');
            return redirect()->route('admin.settings.index');
            
        } else {
            $data['data'] = Setting::pluck('value', 'name');
            return view('adminlte.settings.index', $data);
        }
    }


}
