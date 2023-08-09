<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\OrderRepository;
use Cart;
use App\Models\Product;

class UserController extends Controller
{
    //
    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function orders(Request $request) {
        $data['page_title'] = 'Orders';
        $data['orders'] = $this->orderRepository->getOrders(auth()->user()->id);

        return view('orders', $data);
    }

    public function order_summary(Request $request, $id) {
        $data['page_title'] = 'Order Summary';
        $order = $this->orderRepository->getOrder($id);
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

        return view('order_view', $data);
    }
}
