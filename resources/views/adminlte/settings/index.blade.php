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
                    <h1 class="m-0">Site Settings</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('adminDashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Settings</li>
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
                            <h3 class="card-title">Settings Update</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="user-form" method="post" action="{{ route('admin.settings.index') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">

                                @if($errors->any())
                                    <ul>
                                    {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                                    </ul>
                                @endif
                                @if(session()->has('success'))
                                    <p class="alert alert-success">{{ session()->get('success') }}</p>
                                @endif

                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="site_logo">Site Logo <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="site_logo" name="site_logo">
                                    </div>
                                    <div class="col-6">
                                        <img src="{{ $site_logo }}" width="100" height="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="stripe_public_key">Stripe Public Key <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="stripe_public_key" name="stripe_public_key" placeholder="Stripe Public Key" value="{{ $data ? $data->get('stripe_public_key') : old('stripe_public_key') }}">
                                </div>
                                <div class="form-group">
                                    <label for="stripe_secret_key">Stripe Secret Key <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="stripe_secret_key" name="stripe_secret_key" placeholder="Stripe Secret Key" value="{{ $data ? $data->get('stripe_secret_key') : old('stripe_secret_key') }}">
                                </div>
                                <div class="form-group">
                                    <label for="stripe_mode">Payment Mode (Stripe)<span class="text-danger">*</span></label>
                                    <select class="form-control" id="stripe_mode" name="stripe_mode">
                                        <option value="test" @if($data && $data->get('stripe_mode') == 'test') selected @endif>Test</option>
                                        <option value="live" @if($data && $data->get('stripe_mode') == 'live') selected @endif>Live</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
        
        setTimeout(function() {
            $('.alert').hide('slow');
        }, 2000);

    });
</script>
@endpush