<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Order;
use App\Traits\CrudTrait;

class OrderController extends Controller
{
    use CrudTrait;

    public function model() {
        return Order::class;
    }

    public function validationRules($resource_id = null) {
        return [];
    }

    public function module() {
        return 'orders';
    }

    public function index(Request $request)
    {
        // return $dataTable->render('adminlte.orders.index');
        if ($request->ajax()) {

            $data = $this->model()::with('user')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return '#'.$row->id;
                })
                ->editColumn('grand_total', function ($row) {
                    return format_price($row->grand_total);
                })
                ->editColumn('status', function ($row) {
                    $color  = ($row->status == 'paid') ? 'success' : 'danger';
                    return '<span class="badge badge-'. $color .'">'. ucfirst($row->status) .'</span>';
                })
                ->editColumn('order.user', function ($row) {
                    return ucfirst($row->user->first_name);
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="" class="edit btn btn-success btn-sm">View</a>';
                    return $actionBtn;
                })
                ->rawColumns(['id', 'status', 'action'])
                ->make(true);
        }
        return view('adminlte.orders.index');
    }

    public function summary(Request $request) {
        $order = Order::with('order_items')->where('user_id', auth()->user()->id)->findOrFail($order_id);
        $data['order'] = $order;
        $data['order_items'] = [];
        $i = 0;
        foreach($order->order_items as $key => $value) {
            $data['order_items'][$i] = [
                'product_id' => $value->product_id,
                'quantity' => $value->quantity,
                'unit_price' => $value->unit_price,
                'sub_total' => $value->sub_total,
            ];
            $product = Product::find($value->product_id);
            $data['order_items'][$i]['product_name'] = $product->name;
            $data['order_items'][$i]['product_image'] = $product->getFirstMediaUrl('product_images');
            $i++;
        }

        return view('adminlte.orders.summary', $data);
    }


}
