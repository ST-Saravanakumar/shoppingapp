@extends('layouts.app')

@section('content')
<section class="single-product">
    <div class="container">
        <div class="row">
            <div class="col-md-6 clearfix">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('root') }}">Home</a>
                    </li>
                    <li class="active">Single Product</li>
                </ol>
            </div>
            <!-- <div class="col-md-6">
            </div> -->
        </div>
        <div class="row mt-20">
            <div class="col-md-5">
                <div class="single-product-slider">
                    <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
                        <div class='carousel-outer'>
                            <!-- me art lab slider -->
                            <div class='carousel-inner '>
                                @php $i=0 @endphp
                                @foreach($product->getMedia('product_images') as $media)
                                <div class="item {{ $i == 0 ? 'active' : '' }}">
                                    <img src="{{ $media->getFullUrl() }}" alt="product-image" data-zoom-image="{{ $media->getFullUrl() }}">
                                </div>
                                @php $i++ @endphp
                                @endforeach
                            </div>
                            <!-- sag sol -->
                            <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                                <i class="tf-ion-ios-arrow-left"></i>
                            </a>
                            <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                                <i class="tf-ion-ios-arrow-right"></i>
                            </a>
                        </div>
                        <!-- thumb -->
                        <ol class='carousel-indicators mCustomScrollbar meartlab'>
                            @php $i=0 @endphp
                            @foreach($product->getMedia('product_images') as $media)
                            <li data-target="#carousel-custom" data-slide-to="{{ $i }}" class="{{ $i==0 ? 'active' : '' }}">
                                <img src="{{ $media->getFullUrl() }}" alt="product-img">
                            </li>
                            @php $i++ @endphp
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="single-product-details">
                    <h2>{{ $product->name }}</h2>
                    <p class="product-price">{{ format_price($product->price) }}</p>
                    <p class="product-description mt-20"> {{ $product->description }}</p>
                    <div class="product-quantity">
                        <span>Quantity:</span>
                        <div class="product-quantity-slider">
                            <input id="product-quantity" type="text" value="{{ ($current_quantity) ? $current_quantity : 0 }}" name="product-quantity" data-id="{{ $product->id }}">
                        </div>
                    </div>
                    <div class="product-category">
                        <span>Category:</span>
                        <ul>
                            <li>
                                <a href="javascript:void(0);">{{ $product->category->title }}</a>
                            </li>
                        </ul>
                    </div>
                    @if($product->stock_quantity > 0)
                    <a href="javascript:void(0);" class="btn btn-main mt-20 add_to_cart" data-id="{{ $product->id }}">Add To Cart</a>
                        @if($product->stock_quantity <= 10)
                        <p class="text text-danger mt-1">Only {{ $product->stock_quantity }} left</p>
                        @endif
                    @else
                    <span class="label label-danger mt-20">Out of Stock</span>
                    @endif
                    <p id="msg-success" class="alert alert-success text-center hide"></p>
                    <p id="msg-error" class="alert alert-danger text-center hide"></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="tabCommon mt-20">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#details" aria-expanded="true">Details</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#reviews" aria-expanded="false">Reviews (3)</a>
                        </li>
                    </ul>
                    <div class="tab-content patternbg">
                        <div id="details" class="tab-pane fade active in">
                            <h4>Product Description</h4>
                            <p>{{ $product->description }}</p>
                        </div>


                        <div id="reviews" class="tab-pane fade">
                            <div class="post-comments">
                                <ul class="media-list comments-list m-bot-50 clearlist">
                                    <!-- Comment Item start-->
                                    <li class="media">
                                        <a class="pull-left" href="#!">
                                            <img class="media-object comment-avatar" src="{{ URL::asset('/assets/frontend/images/blog/avater-1.jpg') }}" alt="" width="50" height="50" />
                                        </a>
                                        <div class="media-body">
                                            <div class="comment-info">
                                                <h4 class="comment-author">
                                                    <a href="#!">Jonathon Andrew</a>
                                                </h4>
                                                <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                            </div>
                                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at magna ut ante eleifend eleifend.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod laborum minima, reprehenderit laboriosam officiis praesentium? Impedit minus provident assumenda quae. </p>
                                        </div>
                                    </li>
                                    <!-- End Comment Item -->
                                    <!-- Comment Item start-->
                                    <li class="media">
                                        <a class="pull-left" href="#!">
                                            <img class="media-object comment-avatar" src="{{ URL::asset('/assets/frontend/images/blog/avater-4.jpg') }}" alt="" width="50" height="50" />
                                        </a>
                                        <div class="media-body">
                                            <div class="comment-info">
                                                <div class="comment-author">
                                                    <a href="#!">Jonathon Andrew</a>
                                                </div>
                                                <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                            </div>
                                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at magna ut ante eleifend eleifend. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni natus, nostrum iste non delectus atque ab a accusantium optio, dolor! </p>
                                        </div>
                                    </li>
                                    <!-- End Comment Item -->
                                    <!-- Comment Item start-->
                                    <li class="media">
                                        <a class="pull-left" href="#!">
                                            <img class="media-object comment-avatar" src="{{ URL::asset('/assets/frontend/images/blog/avater-1.jpg') }}" alt="" width="50" height="50">
                                        </a>
                                        <div class="media-body">
                                            <div class="comment-info">
                                                <div class="comment-author">
                                                    <a href="#!">Jonathon Andrew</a>
                                                </div>
                                                <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                            </div>
                                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at magna ut ante eleifend eleifend. </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@if($related_products)
<!-- Related Products -->
<section class="products related-products section">
    <div class="container">
        <div class="row">
            <div class="title text-center">
                <h2>Related Products</h2>
            </div>
        </div>
        <div class="row">
            @foreach($related_products as $key => $value)
            <div class="col-md-3">
                <div class="product-item">
                    <div class="product-thumb">
                        <span class="bage">Sale</span>
                        <img class="img-responsive" src="{{ $value->getFirstMediaUrl('product_images') }}" alt="product-img" />
                        <div class="preview-meta">
                            <ul>
                                <li>
                                    <a href="{{ route('product.view', ['id' => $value->id]) }}"><i class="tf-ion-ios-search-strong"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-id="{{ $value->id }}" class="add_to_cart">
                                        <i class="tf-ion-android-cart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-content">
                        <h4>
                            <a href="product-single.html">{{ $value->name }}</a>
                        </h4>
                        <p class="price">{{ format_price($value->price) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('js')
<script>
    $(function() {

        $('#product-quantity').TouchSpin({
            min: 1
        });

        let logged_user = "{{ auth()->user() ? auth()->user()->id : 0 }}";

        $(document).on('click', '.bootstrap-touchspin-up', function(event) {
            let _this = $(this);
            let qty = $('#product-quantity');
            let params = {
                'input'         : qty,
                'product_id'    : qty.data('id'),
                'change_type'   : 'increase',
                'trigger'       : 'touchspin.downonce'
            };
            if(!checkLogin(logged_user, params)) {
                return;
            }
            update_cart_item(params);
        });
        $(document).on('click', '.bootstrap-touchspin-down', function(event) {
            let _this = $(this);
            let qty = $('#product-quantity');
            let params = {
                'input'         : qty,
                'product_id'    : qty.data('id'),
                'change_type'   : 'decrease',
                'trigger'       : 'touchspin.uponce'
            };
            if(!checkLogin(logged_user, params)) {
                return;
            }
            update_cart_item(params);
        });

        function checkLogin(logged_user, params) {
            if(Number(logged_user) == Number(0)) {
                let error = $('#msg-error');
                error.removeClass('hide');
                error.text('Please login to continue...');
                setTimeout(function() {
                    error.addClass('hide');
                    error.text('');
                }, 3000);

                $(params.input).trigger(params.trigger);
                return;
            }
            return true;
        }


        function update_cart_item(params) {
            $.ajax({
                url: "{{ route('add_to_cart') }}",
                type: 'post',
                data: { 'user_id': logged_user, 'product_id': params.product_id, 'change_type': params.change_type, '_token': "{{ csrf_token() }}" },
                success: function(resp) {
                    
                    if(resp.error) {
                        let error = $('#msg-error');
                        error.removeClass('hide');
                        error.text(resp.error);
                        setTimeout(function() {
                            error.addClass('hide');
                            error.text('');
                        }, 3000);
                        // $(params.qty).val(params.qty.val() - 1);
                        $(params.input).trigger("touchspin.downonce");
                    } else {
                        let success = $('#msg-success');
                        success.removeClass('hide');
                        success.text('Cart item has been updated');
                        setTimeout(function() {
                            success.addClass('hide');
                            success.text('');
                        }, 3000);

                        $('#cart-dropdown-html').html(resp.cart_html);
                    }
                },
                error: function(err) {
                    Swal.fire(
                        'Failed!',
                        'Something went wrong',
                        'error'
                    );
                }
            });
        }

    });
</script>
@endpush