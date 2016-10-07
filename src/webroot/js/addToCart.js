jQuery(function($) {
    $('.plus-sign').click(function(){
        var data = $(this).data();
        var selfContainer = $(this).parent().parent().parent().parent();
        console.log(selfContainer);
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
});