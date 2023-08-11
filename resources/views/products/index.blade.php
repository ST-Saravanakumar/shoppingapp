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
					<li><a href="{{ route('orders') }}">My Orders</a></li>
                    @if(auth()->user()->hasRole('vendor'))
                    <li><a class="active">My Products</a></li>
                    @endif
					<li><a href="{{ route('profile_settings') }}">Profile Settings</a></li>
				</ul>

                <h3 class="text-center">{{ $page_title ?? 'My Account' }}</h3>

                <div class="float-right">
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">Create Product</a>
                </div>
                
				<div class="dashboard-wrapper user-dashboard">
					<div class="table-responsive">
                        @if( session()->has('success') )
                        <p class="alert alert-success text-center">{{ session()->get('success') }}</p>
                        @endif
                        @if( session()->has('error') )
                        <p class="alert alert-danger text-center">{{ session()->get('error') }}</p>
                        @endif
						<table class="table yajra-datatable">
							<thead>
								<tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Stock Quantity</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
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
    $(function () {

        setTimeout(function() {
            $('.alert').hide('slow');
        }, 2000);
    
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'price', name: 'price'},
                {data: 'stock_quantity', name: 'stock_quantity'},
                {data: 'category.title', name: 'category.title'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });

        $(document).on('click', '.btn-delete', function(event) {
            let id = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('products.delete') }}",
                        type: "post",
                        data: { "_token": $('meta[name="csrf-token"]').attr('content'), "id": id },
                        success: function() {
                            Swal.fire(
                                'Deleted!',
                                'Your data has been deleted.',
                                'success'
                            );
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
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
            })

        });
    
    });
</script>
@endpush