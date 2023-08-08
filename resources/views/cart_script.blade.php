<script src="{{ URL::asset('/assets/frontend/js/jquery.toast.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
<script>
    $(function() {

        let logged_user = "{{ auth()->user() ? auth()->user()->id : 0 }}";

        $(document).on('click', '.add_to_cart', function(event) {
            let _this = $(this);
            if(logged_user == 0) {
                $.toast({
                    heading: 'Login Required',
                    text: 'Please login before to continue...',
                    hideAfter: 3000,
                    icon: 'error',
                    positon: 'top-right'
                });
                return;
            }
            $.ajax({
                url: "{{ route('add_to_cart') }}",
                type: 'post',
                data: { 'user_id': logged_user, 'product_id': _this.data('id'), 'quantity': 1, '_token': "{{ csrf_token() }}" },
                success: function(resp) {
                    // Swal.fire(
                    //     'Success!',
                    //     'Item added into cart',
                    //     'success'
                    // );

                    $.toast({
                        heading: 'Success',
                        text: 'Item added to your cart successfully',
                        hideAfter: 3000,
                        icon: 'success',
                        positon: 'top-right'
                    });

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
        });

        $(document).on('click', '.remove_cart_item', function(event) {
            let _this = $(this);
            
            $.ajax({
                url: "{{ route('remove_cart_item') }}",
                type: 'post',
                data: { 'user_id': logged_user, 'product_id': _this.data('id'), '_token': "{{ csrf_token() }}" },
                success: function(resp) {
                    // Swal.fire(
                    //     'Removed!',
                    //     'Item has been removed from cart',
                    //     'success'
                    // );

                    $.toast({
                        heading: 'Success',
                        text: 'Item has been removed from cart',
                        hideAfter: 3000,
                        icon: 'info',
                        positon: 'top-right'
                    });

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
        });

    });
</script>