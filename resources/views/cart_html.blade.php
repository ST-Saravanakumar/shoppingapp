@foreach(Cart::session(auth()->user()->id)->getContent()->toArray() as $key => $item)

<div class="media cart-row">
    <a class="pull-left" href="javascript:void(0);">
        <img class="media-object" src="{{ $item['attributes']['img'] }}" alt="image">
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a href="{{ route('product.view', ['id' => $item['id']]) }}">{{ $item['name'] }}</a></h4>
        <div class="cart-price">
            <span>{{ $item['quantity'] }} x</span>
            <span>{{ format_price($item['price']) }}</span>
        </div>
        <h5><strong>{{ format_price($item['quantity'] * $item['price']) }}</strong></h5>
    </div>
    <a href="javascript:void(0);" class="remove remove_cart_item" data-id="{{ $item['id'] }}"><i class="tf-ion-close"></i></a>
</div>
@endforeach


<div class="cart-summary">
    <span>Total</span>
    <span class="total-price total-price-span">{{ format_price(Cart::session(auth()->user()->id)->getTotal()) }}</span>
</div>
<ul class="text-center cart-buttons">
    <li><a href="{{ route('cart') }}" class="btn btn-small">View Cart</a></li>
    <li><a href="checkout.html" class="btn btn-small btn-solid-border">Checkout</a></li>
</ul>