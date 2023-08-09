<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Repositories\OrderRepository;

class PaymentController extends Controller
{
    //
    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function make_payment(Request $request) {
        $user          = auth()->user();
        $paymentMethod = $request->input('payment_method');
        $total_price = Cart::session($user->id)->getTotal();

        try {
            $user_address = [
                'name' => $request->full_name,
                'description' => 'Order placed by - '.$request->full_name,
                'email' => $user->email,
                // 'source' => $token,
                "address" => ["city" => $request->user_city, "country" => $request->user_country, "line1" => $request->user_address, "line2" => "", "postal_code" => $request->user_post_code, "state" => ""]
            ];
            // $user->createAsStripeCustomer();
            $user->createOrGetStripeCustomer();
            $user->updateStripeCustomer($user_address);
            $customer = $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($total_price * 100, $paymentMethod, ['description' => $user_address['description'], 'off_session' => true, 'confirm' => true, 'customer' => $customer->id]);

            $this->orderRepository->processOrder();
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('orders')->with('success', 'Product purchased successfully!');

    }
}
