jQuery(function($) {
    // beforeAdd popup
    $('.plus-sign').click(function(){
        var data = $(this).data();
        var selfContainer = $(this).parent().parent().parent().parent();
        var optionsData = [];
        $('.photos-view-buttons-box').each(function() {
            var optionObject = $(this).children('.photos-view-buttons-selected').data('option-value');
            optionsData.push(optionObject);
        });
        data.cartline.product_options = optionsData;
        $.post('/carts/beforeAdd', data, function(response){
            selfContainer.append(response);
        });
    });
    
    // close popup
    $('.photos-product-index').on('click', '.addToCartPopup-layer', function(e){
	e.preventDefault();
        $(this).parent().remove();
    });
    
    // decrease amount
    $('.photos-product-index').on('click', '.addToCartPopup-minus img', function(e){
	e.preventDefault();
        var selfContainer = $(this).parent().parent().parent().parent();
         var price = parseFloat(selfContainer.find('.addToCartPopup-header').data('price')).toFixed(2);
        
        var quantityLabel = selfContainer.find('.addToCartPopup-quantity-bottom');
        var quantity = parseInt(quantityLabel.html());
        if(quantity > 1) {
            quantity--;
        }
        
        var discountPrice = parseFloat(selfContainer.find('.addToCartPopup-header').data('discount'));
        
        if(discountPrice < 1) {
            discountPrice = price;
        }
        
        totalPrice = parseFloat(price);
        for(n=2;n<=quantity;n++) {
            totalPrice += parseFloat(discountPrice);
        }
        var priceLabel = selfContainer.find('.addToCartPopup-header span');
        priceLabel.html(totalPrice);
        quantityLabel.html(parseInt(quantity));
    });
    
    // increase amount
    $('.photos-product-index').on('click', '.addToCartPopup-plus img', function(e){
        totalPrice = 0.00;
	e.preventDefault();
        var selfContainer = $(this).parent().parent().parent().parent();
        
        var price = parseFloat(selfContainer.find('.addToCartPopup-header').data('price')).toFixed(2);
        
        var quantityLabel = selfContainer.find('.addToCartPopup-quantity-bottom');
        var quantity = parseInt(quantityLabel.html());
            quantity++;

        var discountPrice = parseFloat(selfContainer.find('.addToCartPopup-header').data('discount'));
        
        if(discountPrice < 1) {
            discountPrice = price;
        }
        
        totalPrice = parseFloat(price);
        for(n=2;n<=quantity;n++) {
            totalPrice += parseFloat(discountPrice);
        }

        var priceLabel = selfContainer.find('.addToCartPopup-header span');
        
        priceLabel.html(parseFloat(totalPrice).toFixed(2).replace('.',','));
        quantityLabel.html(parseInt(quantity));
    });
    
    
    //ajax save cartline
    $('.photos-product-index').on('click', '.addToCartPopup-addButton', function(e){
        e.preventDefault();
        var data = $(this).data();
        var quantity = parseInt($(this).parent().parent().find('.addToCartPopup-quantity-bottom').html());
        data.cartline.quantity = quantity;
        var cartline = data.cartline;
        $.ajax({
            url: '/carts/add.json',
            data: {
                photo_id: cartline.photo_id,
                product_id: cartline.product_id,
                product_name: cartline.product_name,
                product_options: cartline.product_options,
                product_price: cartline.product_price,
                discount: cartline.discount,
                quantity: cartline.quantity
            },
            method: 'POST',
//            dataType:"json",
            success: function(response) {
                $('.addToCartPopup').parent().remove();
                
                // add confirmation message
                if(response.success == true) {
                    $('.addToCartPopup-confirmation').addClass('alert-success');
                    $('#msg').html(response.message);
                    $('.addToCartPopup-confirmation').show();
                    setTimeout(function() {
                        $('.addToCartPopup-confirmation').hide();
                    },2000);
                } else {
                    $('.addToCartPopup-confirmation').addClass('alert-danger');
                    $('#msg').html(response.message);
                    $('.addToCartPopup-confirmation').show();
                    setTimeout(function() {
                        $('.addToCartPopup-confirmation').hide();
                    },2000);
                }
            },
            failure: function(response) {
                console.log(response.error);
            }
        });
    });
});