jQuery(function($) {
    function calcSubmitHeight() {
        var submitButton = $('.submit-button');
        var submitWidth = submitButton.width()/4.57;
        submitButton.css('height', submitWidth);
    }
    
    calcSubmitHeight();
    
    $('.login-add-child').click(function(){
        $('.login-inputs-panel-after-hidden').slideToggle();
        calcSubmitHeight();
    });
    
    $(window).resize(function() {
        calcSubmitHeight();
    });
});