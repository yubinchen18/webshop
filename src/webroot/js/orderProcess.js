jQuery(function($) {
    $('.quantity-right-plus').click(function(e){
        var localQuantity = $(this).parent().parent().find('.input-number');
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt(localQuantity.val());
        // If is not undefined
            localQuantity.val(quantity + 1);
            // Increment
        $.ajax({
            url: '/carts/update.json',
            data: {
                cartline_id: localQuantity.data('id'),
                cartline_quantity: localQuantity.val(),
            },
            method: 'POST',
//            dataType:"json",
            success: function(response) {
                if (response.success == true) {
                    $('.'+localQuantity.attr('id')).html(localQuantity.val());
                    $('.price-'+localQuantity.data('id')).html(response.cartline.subtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                }
            },
            failure: function(response) {
                console.log(response);
            }
        });
     });

     $('.quantity-left-minus').click(function(e){
         var localQuantity = $(this).parent().parent().find('.input-number');
        e.preventDefault();
        var quantity = parseInt(localQuantity.val());
        if(quantity>1){
            localQuantity.val(quantity - 1);
        }
        $('.'+localQuantity.attr('id')).html(localQuantity.val());
        
        $.ajax({
            url: '/carts/update.json',
            data: {
                cartline_id: localQuantity.data('id'),
                cartline_quantity: localQuantity.val(),
            },
            method: 'POST',
//            dataType:"json",
            success: function(response) {
                $('.'+localQuantity.attr('id')).html(localQuantity.val());
                $('.price-'+localQuantity.data('id')).html(response.cartline.subtotal.toString().replace(".", ","));
                $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
            },
            failure: function(response) {
                console.log(response);
            }
        });
    });
    
    $('.input-number').on('keypress', function (e) {
        if(e.which === 13){
            var localQuantity = $(this);
            e.preventDefault();
           $.ajax({
                url: '/carts/update.json',
                data: {
                    cartline_id: localQuantity.data('id'),
                    cartline_quantity: localQuantity.val(),
                },
                method: 'POST',
    //            dataType:"json",
                success: function(response) {
                    $('.'+localQuantity.attr('id')).html(localQuantity.val());
                    $('.price-'+localQuantity.data('id')).html(response.cartline.subtotal.toString().replace(".", ","));
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                },
                failure: function(response) {
                    console.log(response);
                }
            });
        }
    });
});