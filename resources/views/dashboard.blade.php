@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
@endpush

@section('content')
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Dashboard</h1>
					<ol class="breadcrumb">
						<li><a href="{{ route('root') }}">Home</a></li>
						<li class="active">{{ (isset($page_title)) ? $page_title : 'My Account' }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="user-dashboard page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="list-inline dashboard-menu text-center">
					<li><a class="active">Dashboard</a></li>
					<li><a href="{{ route('orders') }}">My Orders</a></li>
                    @if(auth()->user()->hasRole('vendor'))
                    <li><a href="{{ route('products.index') }}">My Products</a></li>
                    @endif
					<li><a href="profile-details.html">Profile Details</a></li>
				</ul>

                <h3 class="text-center">{{ $page_title ?? 'My Account' }}</h3>
                
				<div class="dashboard-wrapper user-dashboard">
					
                    @if( session()->has('success') )
                    <p class="alert alert-success text-center">{{ session()->get('success') }}</p>
                    @endif
                    @if( session()->has('error') )
                    <p class="alert alert-danger text-center">{{ session()->get('error') }}</p>
                    @endif
                    
                    <div class="media">
						<div class="pull-left">
							<img class="media-object user-img" src="{{ $default_img_url }}" alt="Image">
						</div>
						<div class="media-body">
                            <p><h2 class="media-heading">Welcome, <span class="text-info">{{ ucfirst(auth()->user()->first_name .' '. auth()->user()->last_name) }}</span></h2></p>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, iure, est. Sit mollitia est maxime! Eos
								cupiditate tempore, tempora omnis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, nihil. </p>
						</div>
					</div>

					<!-- <div class="total-order mt-20">
						<h4>Total Orders</h4>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Order ID</th>
										<th>Date</th>
										<th>Items</th>
										<th>Total Price</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><a href="#!">#252125</a></td>
										<td>Mar 25, 2016</td>
										<td>2</td>
										<td>$ 99.00</td>
									</tr>
									<tr>
										<td><a href="#!">#252125</a></td>
										<td>Mar 25, 2016</td>
										<td>2</td>
										<td>$ 99.00</td>
									</tr>
									<tr>
										<td><a href="#!">#252125</a></td>
										<td>Mar 25, 2016</td>
										<td>2</td>
										<td>$ 99.00</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div> -->

				</div>
			</div>
		</div>
	</div>
</section>
@endsection