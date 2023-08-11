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
                    <h1 class="m-0">Manage Users</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('adminDashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Users</li>
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
                            <h3 class="card-title">User Add/Edit</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="users-form" method="post" action="{{ $form_url }}">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $data ? $data->id : 0 }}">
                            <div class="card-body">

                                @if($errors->any())
                                    <ul>
                                    {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                                    </ul>
                                @endif

                                <div class="form-group">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ $data ? $data->first_name : old('first_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ $data ? $data->last_name : old('last_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $data ? $data->email : old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="user" @if($data && $data->role == 'user') selected @endif>User</option>
                                        <option value="vendor" @if($data && $data->role == 'vendor') selected @endif>Vendor</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-danger">Cancel</a>
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