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
					<li><a href="dashboard.html">Dashboard</a></li>
					<li><a class="active">Orders</a></li>
                    @if(auth()->user()->hasRole('vendor'))
                    <li><a href="profile-details.html">Products</a></li>
                    @endif
					<li><a href="profile-details.html">Profile Details</a></li>
				</ul>

                <h3 class="text-center">{{ $page_title ?? 'My Account' }}</h3>

                <div class="float-right"><a href="{{ route('orders') }}" class="btn btn-info">Back</a></div>
				<div class="dashboard-wrapper user-dashboard">
					<div class="table-responsive">
                        @if( session()->has('success') )
                        <p class="alert alert-success text-center">{{ session()->get('success') }}</p>
                        @endif
                        @if( session()->has('error') )
                        <p class="alert alert-danger text-center">{{ session()->get('error') }}</p>
                        @endif
						<table class="table table-responsive table-condensed">
							<thead>
								<tr>
									<th>Product Name</th>
                                    <th>Product Image</th>
									<th>Quantity</th>
									<th>Unit Price</th>
									<th>Sub Total</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
                                @forelse($order_items as $item)
                                <tr>
                                    <td>{{ $item['product_name'] }}</td>
                                    <td><img src="{{ $item['product_image'] }}" class="img-responsive"></td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ format_price($item['unit_price']) }}</td>
                                    <td>{{ format_price($item['sub_total']) }}</td>
                                </tr>
                                @empty
                                
                                @endforelse
                                <tr>
                                    <td colspan="3"></td>
                                    <th><span>Grand Total</span></th>
                                    <td><strong>{{ format_price($order->grand_total) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <th><span>Payment Status</span></th>
                                    <td>
                                        <span class="label label-{{ ($order->status == 'paid') ? 'success' : 'default' }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                </tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection