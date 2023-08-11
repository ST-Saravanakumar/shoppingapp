<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

use App\Models\Product;
use App\Repositories\CartRepository;

class CartController extends Controller
{
    public function __construct(CartRepository $cart) {
        $this->cart = $cart;
    }

    public function cart(Request $request) {
        $data['page_title'] = 'Cart';
        return view('cart', $data);
    }

    public function add(Request $request) {
        $product = Product::find($request->product_id);

        $params = [
            'product_id' => $product->id,
            'user_id' => auth()->user() ? auth()->user()->id : $request->user_id,
            'change_type' => ($request->has('change_type') && $request->change_type == 'decrease') ? 'decrease' : 'increase',
            'quantity' => ($request->has('change_type') && $request->change_type == 'decrease') ? -1 : 1,
        ];
        if($validation = $this->cart->validateQuantity($params)) {
            if( !$validation['valid'] ) {
                return response()->json($validation);
            }
        }
        $res = $this->cart->addOrUpdate($params, $product);
        return response()->json($res);
    }

    public function remove(Request $request) {
        $product = Product::find($request->product_id);

        $params = [
            'product_id' => $product->id,
            'user_id' => auth()->user() ? auth()->user()->id : $request->user_id,
        ];
        $res = $this->cart->remove($params, $product);
        return response()->json($res);
    }

    public function checkout(Request $request) {
        if( Cart::session(auth()->user()->id)->isEmpty() ) {
            return redirect()->route('orders')->with('error', 'No items in your cart');
        }
        $data['page_title'] = 'Checkout';
        $data['intent'] = auth()->user()->createSetupIntent();
        // dd($data);
        return view('checkout', $data);
    }

}
