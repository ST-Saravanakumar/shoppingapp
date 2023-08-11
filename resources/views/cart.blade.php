@extends('layouts.app')

@push('css')
<link href="{{ URL::asset('/assets/adminlte/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
<style>
    td.input-group {
        width: 50% !important;
        padding: 5px !important;
        border: 0 !important;
    }
</style>
@endpush

@section('content')
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">Cart</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('root') }}">Home</a>
                        </li>
                        <li class="active">Cart</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="page-wrapper">
    <div class="cart shopping">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="block">
                        <div class="product-list">
                            <p id="msg-success" class="alert alert-success text-center hide"></p>
                            <p id="msg-error" class="alert alert-danger text-center hide"></p>
                            <table class="table table-responsive table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="">Item Name</th>
                                        <th class="">Item Price</th>
                                        <th class="">Item Quantity</th>
                                        <th class="">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(Cart::session(auth()->user()->id)->getContent()->toArray() as $key => $item)
                                    <tr class="item-list">
                                        <td class="">
                                            <div class="product-info">
                                                <img width="80" src="{{ $item['attributes']['img'] }}" alt="product-image" />
                                                <a href="#!">{{ $item['name'] }}</a>
                                            </div>
                                        </td>
                                        <td class="">{{ format_price($item['price']) }}</td>
                                        <td class="">
                                            <div class="single-product-details">
                                                <div class="product-quantity">
                                                    <div class="product-quantity-slider">
                                                        <input type="text" name="quantity_{{ $item['id'] }}" id="quantity_{{ $item['id'] }}" class="form-control item-quantity" value="{{ $item['quantity'] }}" data-id="{{ $item['id'] }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <a href="javascript:void(0);" class="product-remove btn btn-sm" data-id="{{ $item['id'] }}">Remove</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4"><p class="alert alert-warning text-center">Cart is empty</p></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <a href="{{ route('checkout') }}" class="btn btn-main pull-right">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ URL::asset('/assets/adminlte/plugins/toastr/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
<script>
    $(function() {

        $('.item-quantity').TouchSpin({
            min: 1
        });

        let logged_user = "{{ auth()->user() ? auth()->user()->id : 0 }}";

        
        $(document).on('click', '.product-remove', function(event) {
            let _this = $(this);

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
                        url: "{{ route('remove_cart_item') }}",
                        type: 'post',
                        data: { 'user_id': logged_user, 'product_id': _this.data('id'), '_token': "{{ csrf_token() }}" },
                        success: function(resp) {
                            Swal.fire(
                                'Removed!',
                                'Item has been removed from cart',
                                'success'
                            );
                            _this.closest('.item-list').remove();
                            $('#cart-dropdown-html').html(resp.cart_html);
                        },
                        error: function(err) {
                            Swal.fire(
                                'Failed!',
                                'Something went wrong',
                                'error'
                            );
                        }
                    });
                }
            });
        
        });

        $(document).on('click', '.bootstrap-touchspin-up', function(event) {
            let _this = $(this);
            let qty = _this.closest('.single-product-details').find('input.item-quantity');
            let params = {
                'input'         : qty,
                'product_id'    : qty.data('id'),
                'change_type'   : 'increase'
            };
            update_cart_item(params);
        });
        $(document).on('click', '.bootstrap-touchspin-down', function(event) {
            let _this = $(this);
            let qty = _this.closest('.single-product-details').find('input.item-quantity');
            let params = {
                'input'         : qty,
                'product_id'    : qty.data('id'),
                'change_type'   : 'decrease'
            };
            update_cart_item(params);
        });


        function update_cart_item(params) {
            $.ajax({
                url: "{{ route('add_to_cart') }}",
                type: 'post',
                data: { 'user_id': logged_user, 'product_id': params.product_id, 'change_type': params.change_type, '_token': "{{ csrf_token() }}" },
                success: function(resp) {
                    // Swal.fire(
                    //     'Updated!',
                    //     'Cart item has been updated',
                    //     'success'
                    // );
                    if(resp.error) {
                        let error = $('#msg-error');
                        error.removeClass('hide');
                        error.text(resp.error);
                        setTimeout(function() {
                            error.addClass('hide');
                            error.text('');
                        }, 3000);
                        // $(params.qty).val(params.qty.val() - 1);
                        $(params.input).trigger("touchspin.downonce");
                    } else {
                        let success = $('#msg-success');
                        success.removeClass('hide');
                        success.text('Cart item has been updated');
                        setTimeout(function() {
                            success.addClass('hide');
                            success.text('');
                        }, 3000);

                        $('#cart-dropdown-html').html(resp.cart_html);
                    }
                },
                error: function(err) {
                    Swal.fire(
                        'Failed!',
                        'Something went wrong',
                        'error'
                    );
                }
            });
        }

    });
</script>
@endpush