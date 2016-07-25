jQuery(function($) {
    $(".shownewproject").click(function() {
        if($(".widget-body.newprojectcontainer").is(":visible") === false) {
            $(".newproject").prop('disabled', false);
        } else {
            $(".newproject").prop('disabled', true);
        }
    });

    $('.slug').slug({
        slug:'slugx',
        hide: false,
    });

    $('.widget-box.project').each(function(index, element) {
        $('.slugname'+index).slug({
            slug:'slug'+index,
            hide: false,
        });
    });   

    $(".deleteproject").click(function(event) {
        event.preventDefault();
        var r = confirm("Weet je zeker dat je het item wilt verwijderen");
        if (r == true) {
            var url = '/admin/schools/deleteproject/' + $(this).parent().find('.project_id').val();
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(result) {
                    if(result.success == true) {
                        location.reload();
                    }
                }
            });
        } 
    });

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