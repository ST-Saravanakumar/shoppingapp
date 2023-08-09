<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Traits\CrudTrait;

// use App\DataTables\UsersDataTable;

class UserController extends Controller
{
    use CrudTrait;

    public function model() {
        return User::class;
    }

    public function validationRules($resource_id = null) {
        $res_id = ($resource_id != '') ? ',id,'.$resource_id : '';
        $password_rules = ($resource_id != '') ? [] : ['required', 'string', 'min:8'];
        return [
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'.$res_id],
            'password'      => $password_rules,
            'role'          => ['required'],
        ];
    }

    public function module() {
        return 'users';
    }

    public function index(Request $request)
    {
        // return $dataTable->render('adminlte.users.index');
        if ($request->ajax()) {

            $data = $this->model()::where('role', '!=', 'admin')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('first_name', function ($row) {
                    return $row->first_name ? ucfirst($row->first_name) : "";
                })
                ->editColumn('last_name', function ($row) {
                    return $row->last_name ? ucfirst($row->last_name) : "";
                })
                ->editColumn('role', function ($row) {
                    return $row->role ? ucfirst($row->role) : "User";
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);
                    // return date('Y-m-d H:i:s', $row->created_at);
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at);
                    // return date('Y-m-d H:i:s', $row->updated_at);
                })
                ->addColumn('action', function($row){
                    $edit_url = route('admin.users.edit', ['id' => $row->id]);
                    $actionBtn = '<a href="'. $edit_url .'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm btn-delete" data-id="'.$row->id.'" data-module="users">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('adminlte.users.index');
    }


}
