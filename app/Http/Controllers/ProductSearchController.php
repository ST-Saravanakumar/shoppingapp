<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use App\Models\Category;
use Cart;

class ProductSearchController extends Controller
{
    // public function __construct() {

    // }

    public function index(Request $request) {
        
        $data['page_title'] = 'Products';
        $data['categories'] = Category::onlyActive()->get();

        $products = Product::query();

        if($request->category) {
            $products = $products->where('category_id', $request->category);
        }
        if($request->product_name) {
            $products = $products->where('name', 'LIKE', '%'.$request->product_name.'%');
        }
        if($request->price_range) {
            $min_price = explode(';', $request->price_range)[0];
            $max_price = explode(';', $request->price_range)[1];
            $products = $products->whereBetween('price', [$min_price, $max_price]);
        }

        if($request->sort_by) {
            if($request->sort_by == 'price_low_to_high') {
                $column = 'price';
                $order = 'asc';
            } elseif($request->sort_by == 'price_high_to_low') {
                $column = 'price';
                $order = 'desc';
            } elseif($request->sort_by == 'recently_created') {
                $column = 'created_by';
                $order = 'desc';
            } else {
                $column = 'price';
                $order = 'asc';
            }
            $products = $products->orderBy($column, $order);
        }
        $data['products'] = $products->paginate(12);
        // $data['products'] = $products->toSql();
        return view('product_search', $data);
    }

    public function view(Request $request, $id) {
        $data['product'] = Product::with('owner', 'category')->findOrFail($id);
        if($data['product']->status != 'active') {
            return redirect()->route('dashboard')->with('error', 'Product is not available');
        }
        $data['related_products'] = Product::onlyActive()->where('category_id', $data['product']->category_id)->get();
        $data['current_quantity'] = 0;
        if(auth()->user() && \Cart::session(auth()->user()->id)->get($data['product']->id)) {
            $data['current_quantity'] = \Cart::session(auth()->user()->id)->get($data['product']->id)->quantity;
        }
        $data['review'] = null;
        $data['order'] = null;
        if(auth()->user()) {
            $data['review'] = Review::where([ 'product_id' => $id, 'user_id' => auth()->user()->id ])->first();
            $data['order'] = Order::with('order_items')->where('user_id', auth()->user()->id)->whereHas('order_items', function ($query) use ($id) {
                return $query->where('product_id', $id);
            })->first();
        }
        $data['reviews'] = Review::with('user')->where('product_id', $id)->get();
        return view('product_view', $data);
    }
}
