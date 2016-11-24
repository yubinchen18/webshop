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

