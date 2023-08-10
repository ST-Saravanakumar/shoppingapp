<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Product;
// use App\Traits\CrudTrait;

class ProductController extends Controller
{
    protected $img_coll_name = '';

    public function __construct() {
        $this->img_coll_name = 'product_images';
    }

    public function model() {
        return Product::class;
    }

    public function module() {
        return 'products';
    }

    public function validationRules($resource_id = null) {
        $res_id = ($resource_id != '') ? ',id,'.$resource_id : '';
        $rules = [
            'name'          => ['required', 'string', 'min:3', 'max:255', 'unique:products'.$res_id],
            'description'   => ['required'],
            'price'         => ['required', 'numeric', 'min:0'],
            'stock_quantity'=> ['integer'],
            'status'        => ['required'],
            'category_id'   => ['required', 'integer'],
            'created_by'    => ['required', 'integer'],
            'product_image.*' => [ 'image', 'mimes:jpg,png,jpeg,gif,svg,webp', 'max:8192' ],
        ];

        if(!$res_id) {
            $rules['product_image.*'][] = 'required';
        }

        return $rules;
    }
    
     public function index(Request $request)
    {
        // return $dataTable->render('adminlte.products.index');
        if ($request->ajax()) {

            $data = $this->model()::with('category')->where('created_by', auth()->user()->id)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return '<a href="'. route('product.view', ['id' => $row->id]) .'" class="text text-info" target="_blank">'.$row->name.'</a>';
                })
                ->editColumn('description', function ($row) {
                    return Str::of($row->description)->words(20, '...');
                })
                ->editColumn('price', function ($row) {
                    return $row->price ? format_price($row->price) : "0.00";
                })
                ->editColumn('category.title', function ($row) {
                    return $row->category->title ? ucfirst($row->category->title) : "";
                })
                ->editColumn('status', function ($row) {
                    if($row->status && $row->status == 'active') {
                        return '<span class="label label-success">'.ucfirst($row->status).'</span>';
                    } else {
                        return '<span class="label label-danger">Inactive</span>';
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
                    $edit_url = route('products.edit', ['id' => $row->id]);
                    $actionBtn = '<a href="'. $edit_url .'" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>&nbsp;<a href="javascript:void(0)" class="delete btn btn-danger btn-sm btn-delete" data-id="'.$row->id.'" data-module="products"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['name', 'status', 'action'])
                ->make(true);
        }
        $data['page_title'] = 'My Products';
        return view('products.index', $data);
    }

    public function create(Request $request) {
        $data['data'] = '';
        $data['form_url'] = route($this->module().'.store');
        return view($this->module().'.add_edit', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if(!$request->product_image) {
            return back()->withErrors(['Product image is required']);
        }


        $id = $this->model()::create($request->all())->id;
        $product = Product::find($id);

        if($request->hasFile('product_image')) {
            $fileAdders = $product->addMultipleMediaFromRequest(['product_image'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection($this->img_coll_name);
            });
        }

        session()->flash('success', 'Created Successfully');
        return redirect()->route($this->module().'.index');
    }

    public function edit(Request $request, $id) {
        $data['data'] = $this->model()::findOrFail($id);
        $data['form_url'] = route($this->module().'.update');
        // dd($data['data']->getMedia('product_images'));
        return view($this->module().'.add_edit', $data);
    }

    public function update(Request $request) {
        $resource = $this->model()::findOrFail($request->id);

        $validator = Validator::make($request->all(), $this->validationRules($request->id));

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $data = [];
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['price'] = $request->price;
        $data['stock_quantity'] = $request->stock_quantity;
        $data['category_id'] = $request->category_id;
        $data['created_by'] = $request->created_by;
        $data['status'] = $request->status;
        Product::where('id', $request->id)->update($data);
        $product = Product::find($request->id);
        $images = $product->getMedia($this->img_coll_name);
        foreach($images as $img) {
            if(!in_array($img->id, $request->image_id)) {
                $media = $product->getMedia($this->img_coll_name)->find($img->id);
                $media->delete();
            }
        }

        if($request->hasFile('product_image')) {
            $fileAdders = $product->addMultipleMediaFromRequest(['product_image'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection($this->img_coll_name);
            });
        }

        session()->flash('success', 'Updated Successfully');
        return redirect()->route($this->module().'.index');
    }

    public function delete(Request $request)
    {
        $resource = $this->model()::findOrFail($request->id);
        $resource->delete();
        session()->flash('success', 'Deleted Successfully');
        return redirect()->route($this->module().'.index');
    }

    
}
