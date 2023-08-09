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
                    <h1 class="m-0">Order Summary</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('adminDashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Order Summary</li>
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
                
                @if(session()->has('success'))
                <div class="col-lg-12 col-12">
                    <p class="alert alert-success">{{ session()->get('success') }}</p>
                </div>
                @elseif(session()->has('danger'))
                <div class="col-lg-12 col-12">
                    <p class="alert alert-danger">{{ session()->get('danger') }}</p>
                </div>
                @endif

                <div class="col-lg-12 col-12">
                    
                    <table class="table table-bordered yajra-datatable mt-3">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>User</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
@include('adminlte.common.script')
<script type="text/javascript">
  $(function () {

        
    
  });
</script>
@endpush