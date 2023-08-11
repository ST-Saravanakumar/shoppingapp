<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Repositories\OrderRepository;
use Cart;
use App\Models\Product;
use App\Models\Review;

class UserController extends Controller
{
    //
    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function dashboard(Request $request) {
        $data['page_title'] = 'Dashboard';
        return view('dashboard', $data);
    }

    public function orders(Request $request) {
        $data['page_title'] = 'My Orders';
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
            if($product) {
                $data['order_items'][$i]['product_name'] = $product->name;
                $data['order_items'][$i]['product_image'] = $product->getFirstMediaUrl('product_images');
            } else {
                $data['order_items'][$i]['product_name'] = 'Deleted Product';
                $data['order_items'][$i]['product_image'] = url()->asset('/assets/frontend/images/img_not_available.png');
            }
            $i++;
        }

        return view('order_view', $data);
    }

    public function write_review(Request $request) {
        if($request->ajax()) {
            $review = Review::firstOrNew(
                [ 'product_id' => $request->product_id ],
                [ 'user_id' => auth()->user()->id ]
            );
            
            $review->product_id = $request->product_id;
            $review->user_id = auth()->user()->id;
            $review->review = $request->review;
            $review->rating = $request->rating;
            $review->save();

            return response()->json([
                'status_code' => 200,
                'message' => 'Review updated successfully',
                'review' => $review
            ]);
        } else {
            session()->flash('success', 'Review updated successfully');
            return redirect()->route('orders');
        }
    }

    public function profile_settings(Request $request) {
        $data['page_title'] = 'Profile Settings';
        $data['data'] = auth()->user();
        return view('profile_settings', $data);
    }

    public function profile_settings_post(Request $request) {
        $user = auth()->user();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->password = $request->password;
        $user->save();

        if($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        if($request->ajax()) {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'success',
            ]);
        }
        return redirect()->route('dashboard')->with('error', 'Failed to update profile settings');
    }
}
