@extends('layouts.app')

@push('css')
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
    #card-errors, .error-field {
        color: red !important;
    }
</style>
@endpush

@section('content')
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">Checkout</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('root') }}">Home</a>
                        </li>
                        <li class="active">Checkout</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="page-wrapper">
    <div class="checkout shopping">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('success'))
                    <p class="alert alert-success alert-dismissable">{{ session()->get('success') }}  <a href="javascript:void(0);" class="ml-10 remove-alert" style="margin-left: 10px; padding-left: 10px;" data-dismiss="alert">X</a></p>
                    @elseif(session()->has('error'))
                    <p class="alert alert-danger alert-dismissable">{{ session()->get('error') }}  <a href="javascript:void(0);" class="ml-10 remove-alert" style="margin-left: 10px; padding-left: 10px;" data-dismiss="alert">X</a></p>
                    @endif
                </div>
                <div class="col-md-8">
                    <form action="{{ route('make_payment') }}" method="post" id="payment-form" class="checkout-form">
                    @csrf
                        <input type="hidden" name="payment_method" id="payment-method" class="payment-method">
                        <div class="block billing-details">
                            <h4 class="widget-title">Billing Details</h4>
                            
                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="user_address">Address</label>
                                <input type="text" class="form-control" id="user_address" name="user_address" placeholder="">
                            </div>
                            <div class="checkout-country-code clearfix">
                                <div class="form-group">
                                    <label for="user_post_code">Zip Code</label>
                                    <input type="text" class="form-control" id="user_post_code" name="user_post_code" value="">
                                </div>
                                <div class="form-group">
                                    <label for="user_city">City</label>
                                    <input type="text" class="form-control" id="user_city" name="user_city" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <!-- <input type="text" class="form-control" id="user_country" name="user_country" placeholder=""> -->
                                <select name="user_country" id="user_country" class="form-control">
                                    <option value="US">USA</option>
                                    <option value="IN">India</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="block">
                            <h4 class="widget-title">Payment Method</h4>
                            <p>Credit Cart Details (Secure payment)</p>
                            <div class="checkout-product-details">
                                <div class="payment">
                                    <div class="card-details">
                                        
                                        <div id="card-element"></div>
                                        <div id="card-errors" class="mt-3"></div>
                                        <!-- <div class="form-group">
                                            <label for="card-number">Card Number <span class="required">*</span>
                                            </label>
                                            <input id="card-number" class="form-control" type="tel" placeholder="•••• •••• •••• ••••">
                                        </div>
                                        <div class="form-group half-width padding-right">
                                            <label for="card-expiry">Expiry (MM/YY) <span class="required">*</span>
                                            </label>
                                            <input id="card-expiry" class="form-control" type="tel" placeholder="MM / YY">
                                        </div>
                                        <div class="form-group half-width padding-left">
                                            <label for="card-cvc">Card Code <span class="required">*</span>
                                            </label>
                                            <input id="card-cvc" class="form-control" type="tel" maxlength="4" placeholder="CVC">
                                        </div> -->
                                        <button type="submit" id="card-button" class="btn btn-main mt-20">Place Order</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <div class="product-checkout-details">
                        <div class="block">
                            <h4 class="widget-title">Order Summary</h4>
                            @foreach( Cart::session(auth()->user()->id)->getContent()->toArray() as $key => $item )
                            <div class="media product-card">
                                <a class="pull-left" href="{{ route('product.view', ['id' => $item['id']]) }}">
                                    <img class="media-object" src="{{ $item['attributes']['img'] }}" alt="Image">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="product-single.html">{{ $item['name'] }}</a>
                                    </h4>
                                    <p class="price">{{ $item['quantity'] }} x {{ format_price($item['price']) }}</p>
                                </div>
                            </div>
                            @endforeach
                            <!-- <div class="discount-code">
                                <p>Have a discount ? <a data-toggle="modal" data-target="#coupon-modal" href="#!">enter it here</a>
                                </p>
                            </div> -->
                            <ul class="summary-prices">
                                <li>
                                    <span>Subtotal:</span>
                                    <span class="price">{{ format_price( Cart::session(auth()->user()->id)->getSubTotal() ) }}</span>
                                </li>
                                <li>
                                    <span>Shipping:</span>
                                    <span>Free</span>
                                </li>
                            </ul>
                            <div class="summary-total">
                                <span>Total</span>
                                <span>{{ format_price( Cart::session(auth()->user()->id)->getTotal() ) }}</span>
                            </div>
                            <div class="verified-icon">
                                <img src="{{ URL::asset('/assets/frontend/images/shop/verified.png') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ URL::asset('/assets/adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>

    var stripe = Stripe("{{ get_settings('stripe_public_key') }}");
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    let card = elements.create('card', {hidePostalCode: true, style: style});
    card.mount('#card-element');
    let paymentMethod = null;
    $('#payment-form').validate({
        errorElement: 'span',
        errorClass: 'error-field',
        rules: {
            full_name: "required",
            user_address: "required",
            user_post_code: "required",
            user_city: "required",
            user_country: "required",
        }
    });
    $('#payment-form').on('submit', function (e) {
        $('#card-button').attr('disabled', true);
        if (paymentMethod) {
            return true;
        }
        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: card,
                    billing_details: {name: $('#full_name').val()}
                }
            }
        ).then(function (result) {
            if (result.error) {
                $('#card-errors').text(result.error.message);
                $('#card-button').removeAttr('disabled');
            } else {
                paymentMethod = result.setupIntent.payment_method;
                $('#payment-method').val(paymentMethod);
                $('#payment-form').submit();
            }
        });
        return false;
    });

    $(document).on('click', '.remove-alert', function() {
        $(this).closest('.alert').remove();
    });

</script>
@endpush