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

                <div class="col-lg-12 col-12 p-3">
                    <div class="row p-2 mb-3">
                        <div class="col-2"><strong class="text-info">Product Name</strong></div>
                        <div class="col-2"><strong class="text-info">Product Image</strong></div>
                        <div class="col-2"><strong class="text-info">Quantity</strong></div>
                        <div class="col-2"><strong class="text-info">Unit Price</strong></div>
                        <div class="col-2"><strong class="text-info">Subtotal</strong></div>
                    </div>
                    @foreach($order_items as $item)
                    <div class="row p-2">
                        <div class="col-2">
                            <span>{{ $item['product_name'] }}</span>
                        </div>
                        <div class="col-2">
                            <img src="{{ $item['product_image'] }}" alt="Product Image" class="img-responsive" width="100" height="100">
                        </div>
                        <div class="col-2">
                            <span>{{ $item['quantity'] }}</span>
                        </div>
                        <div class="col-2">
                            <span>{{ format_price($item['unit_price']) }}</span>
                        </div>
                        <div class="col-2">
                            <span>{{ format_price($item['sub_total']) }}</span>
                        </div>
                    </div>
                    @endforeach
                    <div class="row p-2">
                        <div class="col-6"></div>
                        <div class="col-2"><strong class="text-info">Grand Total</strong></div>
                        <div class="col-2"><strong>{{ format_price($order->grand_total) }}</strong></div>
                    </div>
                    <div class="row p-2">
                        <div class="col-6"></div>
                        <div class="col-2"><strong class="text-info">Payment Status</strong></div>
                        <div class="col-2"><span class="badge badge-{{ ($order->status == 'paid') ? 'success' : 'info' }}">{{ ucfirst($order->status) }}</span></div>
                    </div>
                    <div class="row p-2">
                        <div class="col-6"></div>
                        <div class="col-2"><strong class="text-info">Ordered By</strong></div>
                        <div class="col-2"><strong>{{ ($order->user) ? ucfirst($order->user->first_name) : 'Deleted User' }}</strong></div>
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
@include('adminlte.common.script')
<script type="text/javascript">
  $(function () {

        
    
  });
</script>
@endpush