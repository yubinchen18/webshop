jQuery(function($) {
    $('#name').slug({
        slug:'slug',
        hide: false,
    });

    $(".showstudents").click(function(event) {
        var groupId = $('.group-id', $(this)).val();
        event.preventDefault(); {
            $.ajax({
                url: '/admin/groups/getStudentsByGroup/' + groupId,
                type: 'POST',
                 success: function(result) {
                    $('.projectdetails').html(result);
                }
            });
        }
    });

    $('#photographer').change(function() {
        $('#sync-button').prop('disabled', true);
        if($('#photographer').val() !== '') {
            $('#sync-button').prop('disabled', false);
        }
    });
});
