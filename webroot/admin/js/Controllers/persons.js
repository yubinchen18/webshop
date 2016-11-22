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
    
    $('#school-id').on('change', function() {
        $.ajax({
            url: '/admin/projects/' + $(this).val() +'.json',
            dataType: 'json',
            success: function(response) {
                $('#project-id').html('<option value="">Selecteer een project</option>');
                for(item in response.projects) {
                    option = $('<option>').val(item).html(response.projects[item]);
                    $('#project-id').append(option);
                }
            }
        });
    });
    
    $('#project-id').on('change', function() {
        $.ajax({
            url: '/admin/groups/' + $(this).val() +'.json',
            dataType: 'json',
            success: function(response) {
                $('#group-id').html('<option value="">Selecteer een klas</option>');
                for(item in response.groups) {
                    option = $('<option>').val(item).html(response.groups[item]);
                    $('#group-id').append(option);
                }
            }
        });
    });
});

