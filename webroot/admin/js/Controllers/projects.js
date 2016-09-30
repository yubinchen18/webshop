jQuery(function($) {
    $('#name').slug({
        slug:'slug',
        hide: false,
    });

    $(".showstudents").click(function() {
        _this = this;
        var groupId = $('.group-id', $(_this)).val();
        event.preventDefault(); {
            $.ajax({
                url: '/admin/groups/getStudentsByGroup/' + groupId,
                type: 'POST',
                 success: function(result) {
                    $('.projectdetails').html(result);
                    console.log(result);
                }
            });
        }
    });

});
