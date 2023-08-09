<?php

namespace App\Repositories;

use Cart;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository implements OrderRepositoryInterface 
{
    public function processOrder() {
        $cart = Cart::session(auth()->user()->id);
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'grand_total' => $cart->getTotal(),
            'status' => 'paid'
        ]);

        foreach($cart->getContent() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'sub_total' => $item->quantity * $item->price,
            ]);
        }

        $cart->clear();

        return true;
    }

    public function getOrders($user_id = 0) {
        $orders = Order::with('order_items');

        if($user_id != '' || $user_id != 0) {
            $orders = $orders->where('user_id', $user_id);
        }
        return $orders->get();
    }

    public function getOrder($order_id) {
        return Order::with('order_items')->where('user_id', auth()->user()->id)->findOrFail($order_id);
    }
}
