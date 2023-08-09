<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Themefisher Icon font -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/frontend/plugins/themefisher-font/style.css') }}">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/frontend/plugins/bootstrap/css/bootstrap.min.css') }}">

    <!-- Animate css -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/frontend/plugins/animate/animate.css') }}">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/frontend/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/frontend/plugins/slick/slick-theme.css') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/frontend/css/style.css') }}">
    <link href="{{ URL::asset('/css/custom_styles.css') }}">
    <link href="{{ URL::asset('/assets/frontend/css/jquery.toast.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
    @stack('css')

</head>
<body id="body">
    <div id="app">
        <!-- Start Top Header Bar -->
        <section class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-4">
                        <div class="contact-number">
                            <i class="tf-ion-ios-telephone"></i>
                            <span>0129- 12323-123123</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-4">
                        <!-- Site Logo -->
                        <div class="logo text-center">
                            <a href="{{ route('root') }}">
                                <!-- replace logo here -->
                                <svg width="135px" height="29px" viewBox="0 0 155 29" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-size="40"
                                        font-family="AustinBold, Austin" font-weight="bold">
                                        <g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
                                            <text id="AVIATO">
                                                <tspan x="108.94" y="325">{{ env('APP_NAME') }}</tspan>
                                            </text>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-4">
                        <!-- Cart -->
                        <ul class="top-menu text-right list-inline">
                            <li class="dropdown cart-nav dropdown-slide">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i
                                        class="tf-ion-android-cart"></i>Cart</a>
                                <div id="cart-dropdown-html" class="dropdown-menu cart-dropdown">

                                    @if(auth()->user() && !Cart::session(auth()->user()->id)->isEmpty())
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
                                        <li><a href="{{ route('checkout') }}" class="btn btn-small btn-solid-border">Checkout</a></li>
                                    </ul>
                                    @else
                                    <div class="p-1">
                                        <span class="alert alert-danger">Cart it empty</span>
                                    </div>
                                    @endif

                                </div>

                            </li><!-- / Cart -->

                        </ul><!-- / .nav .navbar-nav .navbar-right -->
                    </div>
                </div>
            </div>
        </section><!-- End Top Header Bar -->

        <!-- Main Menu Section -->
        <section class="menu">
            <nav class="navbar navigation">
                <div class="container">
                    <div class="navbar-header">
                        <h2 class="menu-title">Main Menu</h2>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                    </div><!-- / .navbar-header -->

                    <!-- Navbar Links -->
                    <div id="navbar" class="navbar-collapse collapse text-center">
                        <ul class="nav navbar-nav">

                            <!-- Home -->
                            <li class="dropdown ">
                                <a href="{{ route('root') }}">Home</a>
                            </li><!-- / Home -->


                            <!-- Elements -->
                            <li class="dropdown dropdown-slide">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350"
                                    role="button" aria-haspopup="true" aria-expanded="false">Shop <span
                                        class="tf-ion-ios-arrow-down"></span></a>
                                <div class="dropdown-menu">
                                    <div class="row">

                                        <!-- Basic -->
                                        <div class="col-lg-6 col-md-6 mb-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Pages</li>
                                                <li role="separator" class="divider"></li>
                                                <li><a href="checkout.html">Checkout</a></li>
                                                <li><a href="cart.html">Cart</a></li>
                                                <li><a href="pricing.html">Pricing</a></li>
                                                <li><a href="confirmation.html">Confirmation</a></li>

                                            </ul>
                                        </div>

                                        <!-- Layout -->
                                        <div class="col-lg-6 col-md-6 mb-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Layout</li>
                                                <li role="separator" class="divider"></li>
                                                <li><a href="product-single.html">Product Details</a></li>
                                                <li><a href="{{ route('products.search') }}">Shop With Sidebar</a></li>
                                                @if(auth()->user() && auth()->user()->hasRole('vendor'))
                                                <li><a href="">Add Product</a></li>
                                                @endif

                                            </ul>
                                        </div>

                                    </div><!-- / .row -->
                                </div><!-- / .dropdown-menu -->
                            </li><!-- / Elements -->


                            @if(auth()->user())                         
                            <li class="dropdown dropdown-slide">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350"
                                    role="button" aria-haspopup="true" aria-expanded="false">Profile <span
                                        class="tf-ion-ios-arrow-down"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="dashboard.html">Dashboard</a></li>
                                    <li><a href="{{ route('orders') }}">My Orders</a></li>
                                    @if(auth()->user() && auth()->user()->hasRole('vendor'))
                                    <li><a href="">My Products</a></li>
                                    @endif
                                    <li><a href="profile-details.html">Profile Details</a></li>
                                </ul>
                            </li>
                            @endif

                            
                            <li class="dropdown dropdown-slide">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350"
                                    role="button" aria-haspopup="true" aria-expanded="false">Account <span
                                        class="tf-ion-ios-arrow-down"></span></a>
                                <ul class="dropdown-menu">
                                    @if(auth()->user())
                                    <form method="post" action="{{ route('logout') }}">
                                        @csrf
                                        <li class="dropdown-header">Welcome, <strong>{{ ucfirst(auth()->user()->first_name) }}</strong></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="javascript:void(0);" id="logout-li">Logout</a></li>
                                    </form>
                                    @else
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul><!-- / .nav .navbar-nav -->

                    </div>
                    <!--/.navbar-collapse -->
                </div><!-- / .container -->
            </nav>
        </section>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer section text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="social-media">
                            <li>
                                <a href="https://www.facebook.com/themefisher">
                                    <i class="tf-ion-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/themefisher">
                                    <i class="tf-ion-social-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.twitter.com/themefisher">
                                    <i class="tf-ion-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/themefisher/">
                                    <i class="tf-ion-social-pinterest"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="footer-menu text-uppercase">
                            <li>
                                <a href="contact.html">CONTACT</a>
                            </li>
                            <li>
                                <a href="shop.html">SHOP</a>
                            </li>
                            <li>
                                <a href="pricing.html">Pricing</a>
                            </li>
                            <li>
                                <a href="contact.html">PRIVACY POLICY</a>
                            </li>
                        </ul>
                        <p class="copyright-text">Copyright &copy;{{ date('Y') }}, Designed &amp; Developed by <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Main jQuery -->
    <script src="{{ URL::asset('/assets/frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.1 -->
    <script src="{{ URL::asset('/assets/frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Bootstrap Touchpin -->
    <script src="{{ URL::asset('/assets/frontend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- Instagram Feed Js -->
    <script src="{{ URL::asset('/assets/frontend/plugins/instafeed/instafeed.min.js') }}"></script>
    <!-- Video Lightbox Plugin -->
    <script src="{{ URL::asset('/assets/frontend/plugins/ekko-lightbox/dist/ekko-lightbox.min.js') }}"></script>
    <!-- Count Down Js -->
    <script src="{{ URL::asset('/assets/frontend/plugins/syo-timer/build/jquery.syotimer.min.js') }}"></script>

    <!-- slick Carousel -->
    <script src="{{ URL::asset('/assets/frontend/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/frontend/plugins/slick/slick-animation.min.js') }}"></script>

    <!-- Google Mapl -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="{{ URL::asset('/assets/frontend/plugins/google-map/gmap.js') }}"></script>

    <!-- Main Js File -->
    <script src="{{ URL::asset('/assets/frontend/js/script.js') }}"></script>
    <script>
        $(function() {
            $(document).on('click', '#logout-li', function() {
                $(this).closest('form').submit();
            });
        });
    </script>
    @stack('js')
    @include('cart_script')
</body>
</html>
