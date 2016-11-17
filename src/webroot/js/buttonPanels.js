jQuery(function($) {
    $('.photos-view-buttons-button').click(function(){
        if (!$(this).hasClass('photos-view-buttons-selected')) {
            var parentClassName = $(this).parent().attr('class').split(' ').pop();
            var selfClassName = $(this).attr('class').split(' ')[0];
            var childrenDivs = $('.'+parentClassName).children();
            var selectedOptions = $('.'+selfClassName);
            // clear other options
            childrenDivs.removeClass('photos-view-buttons-selected');
            childrenDivs.children('.photos-view-buttons-select').remove();
            // highlight this option in both boxes
            selectedOptions.addClass('photos-view-buttons-selected');
            selectedOptions.append('<div class="photos-view-buttons-select"></div>')
            //
        }
    });
    
    $('.photos-view-buttons-box2').children('.photos-view-buttons-button').click(function(){
        var productGroup = $(this).parent().parent().data('product-group');
        var photoId = $(this).parent().parent().data('photo-id');
        var filter = $(this).data('option-value')['value'];
        $.ajax({
            url: '/photos/product-group/'+productGroup+'/'+photoId +'/'+filter,
            method: 'POST',
            success: function(response) {
                var container = $('.photos-product-left-panel');
                container.children('.photos-product-container').remove();
                container.append(response);
            },
            failure: function(response) {
            }
        });
    })
});