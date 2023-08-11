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
					<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
					<li><a href="{{ route('orders') }}">My Orders</a></li>
                    @if(auth()->user()->hasRole('vendor'))
                    <li><a class="active">My Products</a></li>
                    @endif
					<li><a href="{{ route('profile_settings') }}">Profile Settings</a></li>
				</ul>

                <h3 class="text-center">{{ $page_title ?? 'My Account' }}</h3>
              
				<div class="dashboard-wrapper user-dashboard">
                    <div class="card card-primary">
                        <div class="card-header text-center">
                            <h3 class="card-title">Product Add/Edit</h3>
                        </div>
                        <hr>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="products-form" method="post" action="{{ $form_url }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $data ? $data->id : 0 }}">
                            <input type="hidden" name="created_by" id="created_by" value="{{ auth()->user()->id }}">
                            <div class="card-body row">

                                @if($errors->any())
                                    <div class="col-md-12 text-center">
                                        <ul>
                                        {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group col-md-6">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $data ? $data->name : old('name') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description">{{ $data ? $data->description : old('description') }}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">Price <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Price" value="{{ $data ? $data->price : old('price') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="stock_quantity">Stock Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="stock_quantity" name="stock_quantity" placeholder="Stock Quantity" value="{{ $data ? $data->stock_quantity : old('stock_quantity') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Select</option>
                                        @foreach(\App\Models\Category::onlyActive()->get() as $value)
                                        <option value="{{ $value->id }}" @if($data && $data->category_id == $value->id) selected @endif>{{ $value->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" @if($data && $data->status == 'active') selected @endif>Active</option>
                                        <option value="inactive" @if($data && $data->status == 'inactive') selected @endif>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-12 row">
                                    <div class="col-md-12">
                                        <label>Product Images <span class="text-danger">*</span></label>
                                        <button type="button" name="add_img" id="add_img" class="btn btn-sm btn-info">Add Images</button>
                                    </div>
                                    
                                    <div class="container img-container col-md-12 row" id="img-container">

                                        <div class="this-img-container col-md-3">
                                            <input type="file" name="product_image[]" id="product_image_1" class="form-control product-image">
                                            <br>
                                            <img src="{{ $data && $data->id ? $data->getFirstMediaUrl('product_images') : $default_img_url }}" alt="Product Image 1" width="100" height="100" class="img-responsive">
                                            <input type="hidden" name="image_id[]" id="image_id_1" class="image_id" value="{{ $data && $data->id ? $data->getFirstMedia('product_images')->id : '' }}">
                                        </div>

                                        @php $i = 0 @endphp
                                        @if($data && $data->id)
                                        @foreach($data->getMedia('product_images') as $media)

                                        @if($i > 0)
                                        <div class="this-img-container col-md-3">
                                            <input type="file" name="product_image[]" id="product_image_{{ $i }}" class="form-control product-image">
                                            <br>
                                            <img src="{{ $media->getFullUrl() }}" alt="Product Image {{ $i }}" width="100" height="100" class="img-responsive">
                                            <input type="hidden" name="image_id[]" id="image_id_{{ $i }}" class="image_id" value="{{ $media->id }}">
                                            <br>
                                            <button type="button" id="remove_img_{{ $i }}" class="remove_img btn btn-xs btn-danger mt-1">Remove</button>
                                        </div>
                                        @endif

                                        @php $i++ @endphp
                                        @endforeach
                                        @endif

                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
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
        }, 2000);
        
        let index = $('.this-img-container').length;

        $(document).on('click', '#add_img', function(event) {
            if(index > 3) {
                alert('Maximum allowed 4 images');
                return;
            }
            let img_html = '';
            img_html += '<div class="this-img-container col-md-3">'+
                '<input type="file" name="product_image[]" id="product_image_'+index+'" class="form-control product-image">'+
                '<br>'+
                '<img src="" alt="Product Image '+index+'" width="100" height="100" class="img-responsive">'+
                '<input type="hidden" name="image_id[]" id="image_id_'+index+'" class="image_id" value="">'+
                '<br>'+
                '<button type="button" id="remove_img_'+index+'" class="remove_img btn btn-xs btn-danger mt-1">Remove</button>'+
            '</div>';
            $('#img-container').append(img_html);
            index++;
        });

        $(document).on('click', '.remove_img', function() {
            $(this).closest('.this-img-container').remove();
            index--;
        });

        $(document).on('change', '.product-image', function(event){
            $(this).closest('.this-img-container').find('img').attr('src', URL.createObjectURL(event.target.files[0]));
            $(this).closest('.this-img-container').find('input[type="hidden"]').val('');
        });
    
    });
</script>
@endpush