<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\OrderRepository;
use Cart;

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
        $data['order'] = [];

        foreach($order as $key => $value) {
            
        }

        return view('order_view', $data);
    }
}
