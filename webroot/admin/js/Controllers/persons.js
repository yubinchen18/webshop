jQuery(function($) {

    $( "#firstname" ).keyup(function() {
        setfullname();
    });

    $( "#prefix" ).keyup(function() {
        setfullname();
    });

    $( "#lastname" ).keyup(function() {
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
    
    $(".showstudents").show(function() {
        _this = this;
        var personsId = $('.persons-id', $(_this)).val();
        event.preventDefault(); {
            $.ajax({
                url: '/admin/persons/showPhotosStudent/' + personsId,
                type: 'POST',
                 success: function(result) {
                    $('.studentdetails').html(result);
                    console.log(result);
                }
            });
        }
    });
});

