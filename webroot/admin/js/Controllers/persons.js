jQuery(function($) {

    $( "#firstname" ).keydown(function() {
        setfullname();
    });

    $( "#prefix" ).keydown(function() {
        setfullname();
    });

    $( "#lastname" ).keydown(function() {
        setfullname();
    });

    function setfullname() {

        var value = $( "#firstname" ).val() + ' ' + $( "#prefix" ).val() + ' ' + $( "#lastname" ).val();
        $('input[name=full_name]').val(value);
        $('input[name=full_name]').slug({
            slug:'slug',
            hide: false,
            direct:true
        });

    };

    
});

