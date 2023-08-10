@extends('layouts.app')

@section('content')

<div class="hero-slider">
    <div class="slider-item th-fullpage hero-area" style="background-image: url({{ URL::asset('/assets/frontend/images/banner/banner1.jpeg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-center">
                    <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                    <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br> is hidden in details. </h1>
                    <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="{{ route('products.search') }}">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-item th-fullpage hero-area" style="background-image: url({{ URL::asset('/assets/frontend/images/banner/banner2.jpeg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-left">
                    <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                    <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br> is hidden in details. </h1>
                    <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="{{ route('products.search') }}">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-item th-fullpage hero-area" style="background-image: url({{ URL::asset('/assets/frontend/images/banner/banner3.jpeg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-right">
                    <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                    <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br> is hidden in details. </h1>
                    <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="{{ route('products.search') }}">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

@if($trendy_products)
<section class="products section bg-gray">
	<div class="container">
		<div class="row">
			<div class="title text-center">
				<h2>Trendy Products</h2>
			</div>
		</div>
		<div class="row">
			@foreach($trendy_products as $product)
			<div class="col-md-4">
				<div class="product-item">
					<div class="product-thumb">
						<span class="bage">Sale</span>
						<img class="img-responsive" src="{{ $product->getFirstMediaUrl('product_images') }}" alt="product-img">
						<div class="preview-meta">
							<ul>
								<li>
									<a href="{{ route('product.view', ['id' => $product->id]) }}"><i class="tf-ion-ios-search-strong"></i></a>
								</li>
								<li>
									<a href="javascript:void(0);" class="add_to_cart" data-id="{{ $product->id }}"><i class="tf-ion-android-cart"></i></a>
								</li>
							</ul>
                      	</div>
					</div>
					<div class="product-content">
						<h4><a href="{{ route('product.view', ['id' => $product->id]) }}">{{ $product->name }}</a></h4>
						<p class="price">{{ format_price($product->price) }}</p>
					</div>
				</div>
			</div>
			@endforeach

		</div>
	</div>
</section>
@endif

<section class="page-wrapper">
	<div class="contact-section">
		<div class="container">
			<div class="row">
                <div class="contact-form col-md-12">
                    <h3>Contact Us</h3>
                </div>
				<!-- Contact Form -->
				<div class="contact-form col-md-6 " >
					<form id="contact-form" method="post" action="{{ route('contact_form.submit') }}" role="form">
						@csrf
						<div class="form-group">
							<p id="msg" class="alert hide"></p>
						</div>
						<div class="form-group">
							<input type="text" placeholder="Your Name" class="form-control" name="name" id="name">
						</div>
						
						<div class="form-group">
							<input type="email" placeholder="Your Email" class="form-control" name="email" id="email">
						</div>
						
						<div class="form-group">
							<input type="text" placeholder="Subject" class="form-control" name="subject" id="subject">
						</div>
						
						<div class="form-group">
							<textarea rows="6" placeholder="Message" class="form-control" name="message" id="message"></textarea>	
						</div>
						
						<div id="mail-success" class="success">
							Thank you. The Mailman is on His Way :)
						</div>
						
						<div id="mail-fail" class="error">
							Sorry, don't know what happened. Try later :(
						</div>
						
						<div id="cf-submit">
							<button type="submit" id="contact-submit" class="btn btn-transparent">Submit</button>
						</div>						
						
					</form>
				</div>
				<!-- ./End Contact Form -->
				
				<!-- Contact Details -->
				<div class="contact-details col-md-6 " >
					<div class="google-map">
						<div id="map"></div>
					</div>
					<ul class="contact-short-info" >
						<li>
							<i class="tf-ion-ios-home"></i>
							<span>Khaja Road, Bayzid, Chittagong, Bangladesh</span>
						</li>
						<li>
							<i class="tf-ion-android-phone-portrait"></i>
							<span>Phone: +880-31-000-000</span>
						</li>
						<li>
							<i class="tf-ion-android-globe"></i>
							<span>Fax: +880-31-000-000</span>
						</li>
						<li>
							<i class="tf-ion-android-mail"></i>
							<span>Email: hello@example.com</span>
						</li>
					</ul>
					<!-- Footer Social Links -->
					<div class="social-icon">
						<ul>
							<li><a class="fb-icon" href="https://www.facebook.com/themefisher"><i class="tf-ion-social-facebook"></i></a></li>
							<li><a href="https://www.twitter.com/themefisher"><i class="tf-ion-social-twitter"></i></a></li>
							<li><a href="https://themefisher.com/"><i class="tf-ion-social-dribbble-outline"></i></a></li>
							<li><a href="https://themefisher.com/"><i class="tf-ion-social-googleplus-outline"></i></a></li>
							<li><a href="https://themefisher.com/"><i class="tf-ion-social-pinterest-outline"></i></a></li>
						</ul>
					</div>
					<!--/. End Footer Social Links -->
				</div>
				<!-- / End Contact Details -->
					
				
			
			</div> <!-- end row -->
		</div> <!-- end container -->
	</div>
</section>

@endsection

@push('js')
<script src="{{ URL::asset('/assets/adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script>
	$(function() {
		$('#contact-form').validate({
			errorElement: 'span',
            errorClass: 'error-field',
            rules: {
                'name': { required: true, minlength: 2, },
                'email': { required: true, email: true },
				'subject': { required: true, minlength: 2 },
				'message': { required: true, minlength: 2 }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: "{{ route('contact_form.submit') }}",
                    type: "post",
                    data: $(form).serializeArray(),
					beforeSend: function() {
						$('#contact-submit').text('Please wait...');
						$('#contact-submit').attr('disabled', 'disabled');
					},
                    success: function(resp) {
						$('#contact-submit').text('Submit');
						$('#contact-submit').removeAttr('disabled');
                        if(resp.status_code == 200) {
                            $('#msg').text(resp.message);
                            $('#msg').addClass('alert-success').removeClass('hide');
                        }
                    },
                    error: function(err) {
						$('#contact-submit').text('Submit');
						$('#contact-submit').removeAttr('disabled');
                        alert('Something went wrong');
                    }
                });
            }
		});
	});
</script>
@endpush