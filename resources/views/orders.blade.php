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
					<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
					<li><a class="active">My Orders</a></li>
                    @if(auth()->user()->hasRole('vendor'))
                    <li><a href="{{ route('products.index') }}">My Products</a></li>
                    @endif
					<li><a href="{{ route('profile_settings') }}">Profile Settings</a></li>
				</ul>

                <h3 class="text-center">{{ $page_title ?? 'My Account' }}</h3>
                
				<div class="dashboard-wrapper user-dashboard">
					<div class="table-responsive">
                        @if( session()->has('success') )
                        <p class="alert alert-success text-center">{{ session()->get('success') }}</p>
                        @endif
                        @if( session()->has('error') )
                        <p class="alert alert-danger text-center">{{ session()->get('error') }}</p>
                        @endif
						<table class="table">
							<thead>
								<tr>
									<th>Order ID</th>
									<th>Date</th>
									<th>Total Price</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ format_date($order->created_at) }}</td>
                                    <td>{{ format_price($order->grand_total) }}</td>
                                    <td>
                                        <span class="label label-{{ ($order->status=='paid') ? 'success' : 'default' }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('order.view', ['id' => $order->id]) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i> View</a>
                                    </td>
                                </tr>
                                @empty
                                
                                @endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
    $(function() {
        // $('table.table').dataTable();
        let table = new DataTable('table.table', {
            responsive: true
        });

		setTimeout(function() {
            $('.alert').hide('slow');
        }, 3000);
    });
</script>
@endpush