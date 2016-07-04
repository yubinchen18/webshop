jQuery(function($) {
    $(".shownewproject").click(function() {
        if($(".widget-body.newprojectcontainer").is(":visible") === false) {
            $(".newproject").prop('disabled', false);
        } else {
            $(".newproject").prop('disabled', true);
        }
    });

    $('.slugx').slug({
        slug:'slugx',
        hide: false,
    });

    $('.widget-box.project').each(function(index, element) {
        $('.slug'+index).slug({
            slug:'slug0',
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

   

});