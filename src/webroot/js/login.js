jQuery(function($) {
    $('.inlog-form #login-extra-child').click(function(event) {
        $('.inlog-form #login-type').val('login-extra-child');
    });
    
    $('.inlog-form #login').click(function(event) {
        $('.inlog-form #login-type').val('login');
    });
});