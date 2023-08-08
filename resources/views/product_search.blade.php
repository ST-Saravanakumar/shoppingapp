@extends('layouts.app')

@push('css')
<!-- Ion Slider -->
<link rel="stylesheet" href="{{ URL::asset('/assets/adminlte/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">
<!-- bootstrap slider -->
<link rel="stylesheet" href="{{ URL::asset('/assets/adminlte/plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link href="{{ URL::asset('/assets/frontend/css/jquery.toast.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
<style>
    .widget {
        padding-bottom: 0px !important;
    }
    /* span.price {
        font-size: 15px !important;
    } */
</style>
@endpush

@section('content')
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">{{ $page_title }}</h1>
					<ol class="breadcrumb">
						<li><a href="{{ route('root') }}">Home</a></li>
						<li class="active">{{ $page_title }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="products section">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
                <form action="" method="get" id="filters-form">
                    <div class="widget">
                        <h4 class="widget-title">Sort By</h4>
                        <select name="sort_by" id="sort_by" class="form-control">
                            <option value="price_low_to_high" @if(request()->has('sort_by') && request()->sort_by == 'price_low_to_high') selected @endif>Price Low to High</option>
                            <option value="price_high_to_low" @if(request()->has('sort_by') && request()->sort_by == 'price_high_to_low') selected @endif>Price High to Low</option>
                            <option value="recently_created" @if(request()->has('sort_by') && request()->sort_by == 'recently_created') selected @endif>Recently Created</option>
                            <option value="most_rated" @if(request()->has('sort_by') && request()->sort_by == 'most_rated') selected @endif>Most Rated</option>
                        </select>
                    </div>

                    <hr>
                    <p>Filter By</p>
                    <div class="widget product-category">
                        <h4 class="widget-title">Categories</h4>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select</option>
                            @foreach($categories as $key => $value)
                            <option value="{{ $value->id }}" @if(request()->has('category') && request()->category == $value->id) selected @endif>{{ $value->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="widget">
                        <h4 class="widget-title">Product Name</h4>
                        <input type="search" name="product_name" id="product_name" class="form-control" placeholder="Product Name" value="{{ request()->has('product_name') ? request()->product_name : '' }}">
                    </div>
                    <div class="widget">
                        <h4 class="widget-title">Product Price</h4>
                        <input type="text" name="price_range" id="price_range" class="form-control" value="{{ request()->has('price_range') ? request()->price_range : '' }}">
                    </div>

                    <hr>
                    <div class="widget text-center">
                        <button type="submit" id="apply_filters" class="btn btn-md btn-primary">Apply Filters</button>
                    </div>
                </form>
			</div>


			<div class="col-md-9">
				<div class="row">
					
                    @forelse($products as $key => $value)
                    <div class="col-md-4">
                        <div class="product-item">
                            <div class="product-thumb">
                                <span class="bage">Sale</span>
                                <img class="img-responsive" src="{{ $value->getFirstMediaUrl('product_images') }}" alt="product-img">
                                <div class="preview-meta">
                                    <ul>
                                        <li>
                                            <a href="{{ route('product.view', ['id' => $value->id]) }}"><i class="tf-ion-ios-search-strong"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="add_to_cart" data-id="{{ $value->id }}"><i class="tf-ion-android-cart"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h4><a href="product-single.html">{{ $value->name }}</a></h4>
                                <span class="price">{{ format_price($value->price) }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-md-12">
                        <p class="alert alert-default">No Products Found!</p>
                    </div>
                    @endforelse

                    <div class="col-md-12">
                        {!! $products->links() !!}
                    </div>

		
                    <!-- Modal -->
                    <!-- <div class="modal product-modal fade" id="product-modal">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="tf-ion-close"></i>
                        </button>
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <div class="modal-image">
                                                <img class="img-responsive" src="{{ URL::asset('/assets/frontend/images/shop/products/modal-product.jpg') }}" alt="product-img" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="product-short-details">
                                                <h2 class="product-title">GM Pendant, Basalt Grey</h2>
                                                <p class="product-price">$200</p>
                                                <p class="product-short-description">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem iusto nihil cum. Illo laborum numquam rem aut officia dicta cumque.
                                                </p>
                                                <a href="cart.html" class="btn btn-main">Add To Cart</a>
                                                <a href="product-single.html" class="btn btn-transparent">View Product Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- /.modal -->

				</div>				
			</div>
		
		</div>
	</div>
</section>
@endsection

@push('js')
@include('cart_script')
<!-- Ion Slider -->
<script src="{{ URL::asset('/assets/adminlte/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<!-- Bootstrap slider -->
<script src="{{ URL::asset('/assets/adminlte/plugins/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script>
    $(function() {

        $('#price_range').ionRangeSlider({
            min     : 0,
            max     : 100000,
            // from    : 0,
            // to      : 100000,
            type    : 'double',
            step    : 1,
            prefix  : "{{ env('CURRENCY_SYMBOL') }}",
            prettify: false,
            hasGrid : true
        });

    });
</script>
@endpush