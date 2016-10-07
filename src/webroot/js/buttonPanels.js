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
});