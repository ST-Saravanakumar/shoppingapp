<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Review;
use App\Traits\CrudTrait;

class ReviewController extends Controller
{
    use CrudTrait;

    public function model() {
        return Review::class;
    }

    public function validationRules($resource_id = null) {
        return [
            'user_id'       => ['required', 'numeric'],
            'product_id'    => ['required', 'numeric'],
            'review'        => ['required', 'string', 'min:10'],
            'rating'        => ['required', 'numeric'],
        ];
    }

    public function module() {
        return 'reviews';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->model()::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_id', function ($row) {
                    return '#'.$row->user_id;
                })
                ->editColumn('product_id', function ($row) {
                    return '#'.$row->product_id;
                })
                ->editColumn('status', function ($row) {
                    if($row->status == 'approved') {
                        return '<span class="badge badge-success">'. ucfirst($row->status). '</span>';
                    }
                    return '<span class="badge badge-danger">'. ucfirst($row->status). '</span>';
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
                    $edit_url = route('admin.reviews.edit', ['id' => $row->id]);
                    $actionBtn = '<a href="'. $edit_url .'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm btn-delete" data-id="'.$row->id.'" data-module="reviews">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('adminlte.reviews.index');
    }


}
