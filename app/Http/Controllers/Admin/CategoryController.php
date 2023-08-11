<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Traits\CrudTrait;

// use App\DataTables\UsersDataTable;

class CategoryController extends Controller
{
    use CrudTrait;

    public function model() {
        return Category::class;
    }

    public function validationRules($resource_id = null) {
        $res_id = ($resource_id != '') ? ',id,'.$resource_id : '';
        return [
            'title'         => ['required', 'string', 'max:255', 'unique:categories'.$res_id],
            'description'   => ['required', 'string'],
            'status'        => ['required'],
        ];
    }

    public function module() {
        return 'categories';
    }

    public function index(Request $request)
    {
        // return $dataTable->render('adminlte.categories.index');
        if ($request->ajax()) {

            $data = $this->model()::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('description', function ($row) {
                    return Str::of($row->description)->words(50, '...');
                })
                ->editColumn('status', function ($row) {
                    if($row->status && $row->status == 'active') {
                        return '<span class="badge badge-success">'.ucfirst($row->status).'</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
                    }
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
                    $edit_url = route('admin.categories.edit', ['id' => $row->id]);
                    $actionBtn = '<a href="'. $edit_url .'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm btn-delete" data-id="'.$row->id.'" data-module="categories">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        } else {
            return view('adminlte.categories.index');
        }
    }


}
