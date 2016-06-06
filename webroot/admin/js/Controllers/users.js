jQuery(function($) {
    function togglemailaddress(show) {
        $('.mailaddress input').each(function (i, value){
            $(value).prop('disabled', !show)
        })
        
        if(show == true) {
            return $('.mailaddress').show();
        }
        return $('.mailaddress').hide();
    }

    togglemailaddress($("input[name='differentmail']" ).is(':checked'));

    $( "input[name='differentmail']" ).click(function() {
        togglemailaddress($("input[name='differentmail']" ).is(':checked'));
    });
});
