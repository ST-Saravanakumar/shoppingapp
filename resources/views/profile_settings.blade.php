@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
                    <li><a href="{{ route('products.index') }}">My Products</a></li>
                    @endif
					<li><a class="active">Profile Settings</a></li>
				</ul>

                <h3 class="text-center">{{ $page_title ?? 'My Account' }}</h3>
              
				<div class="dashboard-wrapper user-dashboard">
                    <div class="card card-primary">
                        <div class="card-header text-center">
                            <h3 class="card-title">Profile Settings</h3>
                        </div>
                        <hr>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="profile-form" method="post" class="dropzone" action="{{ route('profile_settings.post') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="card-body row">
                            <div class="dropzone-previews"></div>


                                @if($errors->any())
                                    <div class="col-md-12 text-center">
                                        <ul>
                                        {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ $data ? $data->first_name : old('first_name') }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ $data ? $data->last_name : old('last_name') }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                </div>
                                                                
                                <div class="form-group col-md-12 row">
                                    <div class="col-md-12">
                                        <label>Avatar <span class="text-danger">*</span></label>
                                        <div class="dz-default dz-message"><button class="dz-button" type="button">Drop file here to upload</button></div>
                                        <div id="dropzone-previews"></div>
                                    </div>
                                    
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <button name="submit" id="submit" type="submit" class="btn btn-primary">Update</button>
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
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="{{ URL::asset('/assets/adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script>


    Dropzone.options.profileForm = {
        previewsContainer: document.querySelector('#dropzone-previews'),
        autoProcessQueue: false,
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 1,

        init: function() {
            var myDropzone = this;

            // Here's the change from enyo's tutorial...

            $("#submit").click(function (e) {
                e.preventDefault();
                e.stopPropagation();

                if($('#password').val() != $('#confirm_password').val()) {
                    $('#confirm_password').parent().find('span.text-danger').remove();
                    $('#confirm_password').after('<span class="text text-danger">Confirm Password is not matching</span>');
                    return;
                } else {
                    $('#confirm_password').parent().find('span.text-danger').remove();
                    myDropzone.processQueue();
                }
            }); 
        }
    }


    $(function () {

        setTimeout(function() {
            $('.alert').hide('slow');
        }, 2000);
        
    });
</script>
@endpush