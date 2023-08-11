@extends('layouts.app')

@section('content')
<section class="signin-page account">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="block text-center">
                    <a class="logo" href="{{ route('root') }}">
                        <img src="{{ $site_logo }}" alt="">
                    </a>
                    <h2 class="text-center">Welcome Back</h2>
                    @if( session()->has('error') )
                    <p class="alert alert-danger">{{ session()->get('error') }}</p>
                    @endif
                    <form class="text-left clearfix" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                            @error('password')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-main text-center">Login</button>
                        </div>
                    </form>
                    <p class="mt-20">New in this site? <a href="{{ route('register') }}"> Create New Account</a></p>
                    <p class="mt-20">Forgot your password? <a href="{{ route('password.request') }}"> Reset Password</a></p>

                    <hr>
                    <p>Or Login with</p>
                    <div class="social-media-icons">
                        <ul>
                            <li>
                                <a class="google-icon googleplus" href="{{ route('login.social', [ 'driver' => 'google' ]) }}">
                                    <i class="tf-ion-social-googleplus"></i>
                                </a>
                            </li>
                            <li>
                                <a class="facebook-icon facebook" href="{{ route('login.social', [ 'driver' => 'facebook' ]) }}">
                                    <i class="tf-ion-social-facebook"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
