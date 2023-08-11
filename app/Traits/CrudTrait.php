<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;

trait CrudTrait
{
    abstract function model();
    abstract function module();
    abstract function validationRules($resource_id = 0);

    // public function index()
    // {
    //     return $this->model()::all();
    // }

    public function create(Request $request) {
        $data['data'] = '';
        $data['form_url'] = route('admin.'.$this->module().'.store');
        return view('adminlte.'.$this->module().'.add_edit', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $id = $this->model()::create($request->all())->id;
        if($this->module() == 'users') {
            $user = $this->model()::find($id);
            $user->assignRole($request->role);
        }
        session()->flash('success', 'Created Successfully');
        return redirect()->route('admin.'.$this->module().'.index');
    }

    // public function show($resource_id)
    // {
    //     return $this->model()::findOrFail($resource_id);
    // }

    public function edit(Request $request, $id) {
        $data['data'] = $this->model()::findOrFail($id);
        $data['form_url'] = route('admin.'.$this->module().'.update');
        // dd($data['data']->getMedia('product_images'));
        return view('adminlte.'.$this->module().'.add_edit', $data);
    }

    public function update(Request $request)
    {
        $resource = $this->model()::findOrFail($request->id);

        $validator = Validator::make($request->all(), $this->validationRules($request->id));

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $resource->update($request->all());
        session()->flash('success', 'Updated Successfully');
        if($this->module() == 'users') {
            $role = Role::where('name', $request->role)->first();
            $resource->roles()->sync($role->id);
        }
        return redirect()->route('admin.'.$this->module().'.index');
    }

    public function delete(Request $request)
    {
        $resource = $this->model()::findOrFail($request->id);
        $resource->delete();
        session()->flash('success', 'Deleted Successfully');
        return redirect()->route('admin.'.$this->module().'.index');
    }
}