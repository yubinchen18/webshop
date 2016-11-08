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
            dataType:"json",
            success: function(response) {
                if (response.success == true) {
                    $('.'+localQuantity.attr('id')).html(localQuantity.val());
                    $('.price-'+localQuantity.data('id')).html(response.cartline.subtotal.toFixed(2).toString().replace(".", ","));

                    if(response.cartline.product.has_discount == 1 && parseInt(localQuantity.val()) > 1) {
                        subTotals = $('<div/>');
                        price = parseFloat(response.cartline.product.price_ex).toFixed(2);
                        discountprice = parseFloat(response.cartline.discountprice).toFixed(2);
                        subTotals.append('<span class="quantity-'+localQuantity.data('id')+'"></span>');
                        subTotals.append('<div class="normalprice">1 x &euro; '+ price.replace('.',',') + '</div>');
                        subTotals.append('<div class="discountprice">'+ (parseInt(localQuantity.val())-1) +' x &euro; '+ discountprice.replace('.',',') + '</div>');
                        
                        $('.quantity-'+localQuantity.data('id')).parent().html(subTotals);
                    }
                    if(parseInt(localQuantity.val()) == 1) {
                        $('.quantity-'+localQuantity.data('id')).parent().html('<div class="quantity-'+localQuantity.data('id')+'">1 x &euro; '+ price.replace('.',',') + '</div>');
                    }
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                }
            },
            failure: function(response) {
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
            dataType:"json",
            success: function(response) {
                if (response.success == true) {
                    $('.'+localQuantity.attr('id')).html(localQuantity.val());
                    $('.price-'+localQuantity.data('id')).html(response.cartline.subtotal.toFixed(2).toString().replace(".", ","));

                    if(response.cartline.product.has_discount == 1 && parseInt(localQuantity.val()) > 1) {
                        subTotals = $('<div/>');
                        price = parseFloat(response.cartline.product.price_ex).toFixed(2);
                        discountprice = parseFloat(response.cartline.discountprice).toFixed(2);
                        subTotals.append('<span class="quantity-'+localQuantity.data('id')+'"></span>');
                        subTotals.append('<div class="normalprice">1 x &euro; '+ price.replace('.',',') + '</div>');
                        subTotals.append('<div class="discountprice">'+ (parseInt(localQuantity.val())-1) +' x &euro; '+ discountprice.replace('.',',') + '</div>');
                        
                        $('.quantity-'+localQuantity.data('id')).parent().html(subTotals);
                    }
                    if(parseInt(localQuantity.val()) == 1) {
                        $('.quantity-'+localQuantity.data('id')).parent().html('<div class="quantity-'+localQuantity.data('id')+'">1 x &euro; '+ price.replace('.',',') + '</div>');
                    }
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-shippingcosts').html(response.shippingCost.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                }
            },
            failure: function(response) {
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
                dataType:"json",
                success: function(response) {
                    $('.'+localQuantity.attr('id')).html(localQuantity.val());
                    $('.price-'+localQuantity.data('id')).html(response.cartline.subtotal.toString().replace(".", ","));
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-shippingcosts').html(response.shippingCost.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                },
                failure: function(response) {
                }
            });
        }
    });
    
    $('.update-orderline').on('click', function(e){
        var cartline_id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
        var cartlineData = JSON.parse($(this).attr('data-cartline'));
        console.log();
        $.ajax({
            url: '/carts/updateFreeProductInCartline',
            data: {
                cartline_id: cartline_id,
                cartline_photo_id: cartlineData.photo_id
            },
            method: 'POST',
            success: function() {
                window.location.href = "/carts/display";
            }
        });
    });
    
    $('.cartline-close').on('click', function() {
       if(confirm('Weet u zeker dat u dit product wilt verwijderen?')) {
          var divId = $(this).parent().attr('id');
          $.ajax({
            url: '/carts/delete/'+ divId +'.json',
            success: function(response) {
                $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                $('#order-shippingcosts').html(response.shippingCost.toFixed(2).toString().replace(".", ","));
                $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                $('div#'+divId).next('.navigation-groups-picture').remove();
                $('div#'+divId).remove();
                if(response.removeGroup !== "") {
                    $('div#'+response.removeGroup).remove();
                }     
            }
          });
       }
    });
    
    $('#alternative-address').hide();
    if($('#different-address').prop('checked')) {
        $('#alternative-address').show();
    }
    $('#different-address').change(function() {
        if(this.checked) {
            $('#alternative-address').show();
        } else {
            $('#alternative-address').hide();
        }
    });
    
    $('#ideal-issuers').hide();
    if($('#paymentmethod').val() == 'ideal') {
        $('#ideal-issuers').show();
    }
    $('#paymentmethod').on('change', function() {
        $('#ideal-issuers').hide();
        if($('#paymentmethod').val() == 'ideal') {
            $('#ideal-issuers').show();
        }
    });
});
