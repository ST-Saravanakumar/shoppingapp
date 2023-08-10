@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
<style>
    #img-container {
        margin-top: 10px;
    }
    .this-img-container img {
        width: 100px;
        height: 100px;
    }
</style>
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
					<li><a class="active">My Orders</a></li>
                    @if(auth()->user()->hasRole('vendor'))
                    <li><a href="{{ route('products.index') }}">My Products</a></li>
                    @endif
					<li><a href="profile-details.html">Profile Details</a></li>
				</ul>

                <div class="float-right">
                    <a href="{{ route('orders') }}" class="btn btn-sm btn-primary">Goto My Orders</a>
                </div>

				<div class="dashboard-wrapper user-dashboard">
                    <div class="card card-primary">
                        <div class="card-header text-center">
                            <h3 class="card-title">{{ $page_title }}</h3>
                        </div>
                        <hr>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="reviews-form" method="post" action="{{ route('write_review.post', ['id' => $order_id]) }}">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $data ? $data->id : 0 }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $data ? $data->user_id : auth()->user()->id }}">
                            <input type="hidden" name="status" id="status" value="approved">
                            <div class="card-body row">

                                @if($errors->any())
                                    <div class="col-md-12 text-center" style="margin-bottom: 10px;">
                                        <ul>
                                        {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group col-md-6">
                                    <label for="order_id">Order Id <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Order Id" value="{{ $order_id }}" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="review">Review <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="review" name="review" placeholder="Write Review">{{ $data ? $data->review : old('review') }}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="rating">Rating <span class="text-danger">*</span></label>
                                    <select name="rating" id="rating" class="form-control">
                                        <option value="">Select</option>
                                        @for($i = 1; $i < 6; $i++)
                                        <option value="{{ $i }}" @if($data && $data->rating == $i) selected @endif>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
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
        }, 3000);
    
    });
</script>
@endpush