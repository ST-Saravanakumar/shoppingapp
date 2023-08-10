@extends('layouts.admin')

@push('css')
@endpush

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Reviews</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('adminDashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Reviews</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

        
            <!-- Small boxes (Stat box) -->
            <div class="row">
                
                <div class="col-lg-6 col-6">
                    
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Review Update</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="reviews-form" method="post" action="{{ $form_url }}">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $data ? $data->id : 0 }}">
                            <div class="card-body">

                                @if($errors->any())
                                    <ul>
                                    {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                                    </ul>
                                @endif

                                <div class="form-group">
                                    <label for="user_id">User Id <span class="text-danger">*</span></label>
                                    <select class="form-control" id="user_id" name="user_id" readonly>
                                        <option value="{{ $data->user_id }}">{{ $data->user_id }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product_id">Product Id <span class="text-danger">*</span></label>
                                    <select class="form-control" id="product_id" name="product_id" readonly>
                                        <option value="{{ $data->product_id }}">{{ $data->product_id }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="review">Review <span class="text-danger">*</span></label>
                                    <textarea name="review" id="review" class="form-control" cols="10" rows="5">{{ $data->review }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rating">Rating <span class="text-danger">*</span></label>
                                    <select name="rating" id="rating" class="form-control">
                                        <option value="">Select</option>
                                        @for($i = 1; $i < 6; $i++)
                                        <option value="{{ $i }}" @if($data->rating == $i) selected @endif>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="approved" @if($data && $data->status == 'approved') selected @endif>Approved</option>
                                        <option value="unapproved" @if($data && $data->status == 'unapproved') selected @endif>Unapproved</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>

                </div>
                
            </div>
            <!-- /.row -->
            

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@push('js')
<script>
    $(function() {
        


    });
</script>
@endpush