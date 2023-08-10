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
                                <th>No</th>
                                <th>User Id</th>
                                <th>Product Id</th>
                                <th>Review</th>
                                <th>Rating</th>
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

        setTimeout(function() {
            $('.alert').hide('slow');
        }, 2000);
    
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.reviews.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'user_id', name: 'user_id'},
                {data: 'product_id', name: 'product_id'},
                {data: 'review', name: 'review'},
                {data: 'rating', name: 'rating'},
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
                        url: "{{ route('admin.reviews.delete') }}",
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
                        error: function() {
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