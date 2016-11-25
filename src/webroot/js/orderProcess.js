jQuery(function($) {
    $('.quantity-right-plus').click(function(e){
        var localQuantity = $(this).parent().parent().find('.input-number');
        e.preventDefault();
        var quantity = parseInt(localQuantity.val());
            localQuantity.val(quantity + 1);

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
                    var cartlines = response.cart.cartlines;
                    for(line in cartlines) {
                        qtyRow = $('#'+ cartlines[line]['id']);
                        subTotals = $('<div/>');
                        subTotals.append('<span class="quantity-'+cartlines[line]['id']+'"></span>');
                        if(cartlines[line]['product']['has_discount'] == 1 && 
                           cartlines[line]['product']['price_ex'] != response['discountPrice'] && 
                           cartlines[line]['quantity'] > 1) {
                            subTotals.append('<div class="normalprice">1 x &euro; '+ cartlines[line]['product']['price_ex'].toString().replace('.',',') + '</div>');
                            subTotals.append('<div class="discountprice">'+ (cartlines[line]['quantity']-1) +' x &euro; '+ response['discountPrice'].toString().replace('.',',') + '</div>');
                        } else {
                            subTotals.append('<div class="normalprice">'+ cartlines[line]['quantity'] +' x &euro; '+ cartlines[line]['product']['price_ex'].toString().replace('.',',') + '</div>');
                        }
                        qtyRow.find('.cartline-product-unitPrice').html(subTotals);
                        qtyRow.find('.price-' + cartlines[line]['id']).html(cartlines[line]['subtotal'].toFixed(2).replace('.',','));
                    }
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-shippingcosts').html(response.shippingCost.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                    //animate cart count
                    $('div.small-cart div.label').html(response.cartCount).css({
                        'font-size': '3em', 'right': '58px', 'top': '23px'
                    }).animate({
                        right: '74px', top: '34px', fontSize: '1.8em'
                    }, 350, 'swing');
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
                    var cartlines = response.cart.cartlines;
                    for(line in cartlines) {
                        qtyRow = $('#'+ cartlines[line]['id']);
                        subTotals = $('<div/>');
                        subTotals.append('<span class="quantity-'+cartlines[line]['id']+'"></span>');
                        if(cartlines[line]['product']['has_discount'] == 1 && 
                           cartlines[line]['product']['price_ex'] != response['discountPrice'] && 
                           cartlines[line]['quantity'] > 1) {
                            subTotals.append('<div class="normalprice">1 x &euro; '+ cartlines[line]['product']['price_ex'].toString().replace('.',',') + '</div>');
                            subTotals.append('<div class="discountprice">'+ (cartlines[line]['quantity']-1) +' x &euro; '+ response['discountPrice'].toString().replace('.',',') + '</div>');
                        } else {
                            subTotals.append('<div class="normalprice">'+ cartlines[line]['quantity'] +' x &euro; '+ cartlines[line]['product']['price_ex'].toString().replace('.',',') + '</div>');
                        }
                        qtyRow.find('.cartline-product-unitPrice').html(subTotals);
                        qtyRow.find('.price-' + cartlines[line]['id']).html(cartlines[line]['subtotal'].toFixed(2).replace('.',','));
                    }
                    
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-shippingcosts').html(response.shippingCost.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                    //animate cart count
                    $('div.small-cart div.label').html(response.cartCount).css({
                        'font-size': '3em', 'right': '58px', 'top': '23px'
                    }).animate({
                        right: '74px', top: '34px', fontSize: '1.8em'
                    }, 350, 'swing');
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
                $('div.small-cart div.label').html(response.cartCount).css({
                    'font-size': '3em', 'right': '58px', 'top': '23px'
                }).animate({
                    right: '74px', top: '34px', fontSize: '1.8em'
                }, 350, 'swing');
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
