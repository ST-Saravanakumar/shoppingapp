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
                    <h2 class="text-center">Create Your Account</h2>
                    <form class="text-left clearfix" method="POST" action="{{ route('register') }}">
                        <div class="form-group">
							<input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus placeholder="First Name">

							@error('first_name')
							<span class="text-danger" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
                        </div>
                        <div class="form-group">
							<input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus placeholder="Last Name">

							@error('last_name')
								<span class="text-danger" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
                        </div>
                        
                        <div class="form-group">
							<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

							@error('email')
								<span class="text-danger" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
                        </div>
                        <div class="form-group">
							<select name="role" id="role" class="form-control">
								<option value="user">User</option>
								<option value="vendor">Vendor</option>
							</select>

							@error('role')
								<span class="text-danger" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
                        </div>
						<div class="form-group">
							<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

							@error('password')
								<span class="text-danger" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
                        </div>
						<div class="form-group">
							<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">

							@error('password_confirmation')
								<span class="text-danger" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-main text-center">Register</button>
                        </div>
                    </form>
                    <p class="mt-20">Already hava an account ? <a href="{{ route('login') }}"> Login</a></p>
                    <p>
                        <a href="{{ route('password.request') }}"> Forgot your password?</a>
                    </p>

					<hr>
                    <p>Or Signup with</p>
                    <a class="google-icon" href="{{ route('login.social', [ 'driver' => 'google' ]) }}">
                        <img src="{{ URL::asset('/assets/frontend/images/social/google-icon.png') }}" alt="google-icon" width="100" height="50">
                    </a>
                    <a class="facebook-icon" href="{{ route('login.social', [ 'driver' => 'facebook' ]) }}">
                        <img src="{{ URL::asset('/assets/frontend/images/social/facebook-icon.jpeg') }}" alt="facebook-icon" width="50" height="50">
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
