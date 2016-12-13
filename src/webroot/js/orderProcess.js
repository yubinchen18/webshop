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
                            subTotals.append('<div class="normalprice">1 x &euro; '+ cartlines[line]['product']['price_ex'].toFixed(2).toString().replace('.',',') + '</div>');
                            subTotals.append('<div class="discountprice">'+ (cartlines[line]['quantity']-1) +' x &euro; '+ response['discountPrice'].toFixed(2).toString().replace('.',',') + '</div>');
                        } else {
                            subTotals.append('<div class="normalprice">'+ cartlines[line]['quantity'] +' x &euro; '+ cartlines[line]['product']['price_ex'].toFixed(2).toString().replace('.',',') + '</div>');
                        }
                        qtyRow.find('.cartline-product-unitPrice').html(subTotals);
                        qtyRow.find('.price-' + cartlines[line]['id']).html(cartlines[line]['subtotal'].toFixed(2).replace('.',','));
                    }
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-shippingcosts').html(response.shippingCost.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                    //animate cart count
                    updateCartCount(response.cartCount);
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
                            subTotals.append('<div class="normalprice">1 x &euro; '+ cartlines[line]['product']['price_ex'].toFixed(2).toString().replace('.',',') + '</div>');
                            subTotals.append('<div class="discountprice">'+ (cartlines[line]['quantity']-1) +' x &euro; '+ response['discountPrice'].toFixed(2).toString().replace('.',',') + '</div>');
                        } else {
                            subTotals.append('<div class="normalprice">'+ cartlines[line]['quantity'] +' x &euro; '+ cartlines[line]['product']['price_ex'].toFixed(2).toString().replace('.',',') + '</div>');
                        }
                        qtyRow.find('.cartline-product-unitPrice').html(subTotals);
                        qtyRow.find('.price-' + cartlines[line]['id']).html(cartlines[line]['subtotal'].toFixed(2).replace('.',','));
                    }
                    
                    $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                    $('#order-shippingcosts').html(response.shippingCost.toFixed(2).toString().replace(".", ","));
                    $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                    //animate cart count
                    updateCartCount(response.cartCount);
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
                    updateCartCount(response.cartCount);
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
                console.log(response);
                $('#order-subtotal').html(response.orderSubtotal.toFixed(2).toString().replace(".", ","));
                $('#order-shippingcosts').html(response.shippingCost.toFixed(2).toString().replace(".", ","));
                $('#order-total').html(response.orderTotal.toFixed(2).toString().replace(".", ","));
                $('div#'+divId).next('.navigation-groups-picture').remove();
                $('div#'+divId).remove();
                if(response.removeGroup !== "") {
                    $('div#'+response.removeGroup).remove();
                }
                //animate cartCount
                updateCartCount(response.cartCount);
                disableCheckoutButton();
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
    
    $('.auto-zipcode').change(function() {
        var zipcode = $(this).val().replace(" ", "");
        var id = $(this).attr('id');
        var url = '/carts/zipcode/'+zipcode;
        $.ajax({
            type: 'GET',
            url: url
        })
        .success($.proxy(function(response) {
            var data = JSON.parse(response);
            if(data.success == 1){
                if(id == 'order-info-zipcode') {
                    $('#order-info-street').val(data.street);
                    $('#order-info-city').val(data.town);
                }else if (id == 'order-info-alternative-zipcode') {
                    $('#order-info-alternative-street').val(data.street);
                    $('#order-info-alternative-city').val(data.town);
                }
            }
        }, this));
    });
    function updateCartCount(count) {
        var cartLabel = $('div.small-cart div.label');
        if (cartLabel.hasClass('label-animate')) {
            cartLabel.removeClass('label-animate');
        }
        cartLabel.html(count).addClass('label-animate');
        setTimeout(function () {      
            cartLabel.removeClass("label-animate");         
       }, 340);
    }

    if($('.navigation-groups-picture').size() > 0) {
        $('.order-place-order .btn-success').addClass('disabled');
    }
    disableCheckoutButton();
});

function disableCheckoutButton()
{
    $('.order-place-order .btn-success').removeClass('disabled');
    if($('.navigation-groups-picture').size() > 0) {
        $('.order-place-order .btn-success').addClass('disabled');
    }
}