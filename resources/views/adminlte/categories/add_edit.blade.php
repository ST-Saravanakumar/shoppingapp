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
                    <h1 class="m-0">Manage Categories</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('adminDashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Categories</li>
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
                            <h3 class="card-title">Categories Add/Edit</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="categories-form" method="post" action="{{ $form_url }}">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $data ? $data->id : 0 }}">
                            <div class="card-body">

                                @if($errors->any())
                                    <ul>
                                    {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                                    </ul>
                                @endif

                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ $data ? $data->title : old('title') }}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description">{{ $data ? $data->description : old('description') }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" @if($data && $data->status == 'active') selected @endif>Active</option>
                                        <option value="inactive" @if($data && $data->status == 'inactive') selected @endif>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Cancel</a>
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