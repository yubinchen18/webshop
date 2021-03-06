jQuery(function($) {
    $('#generate-coupon-code').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url: '/admin/coupons/generateCouponCode/',
            type: 'get',
            success: function(result) {
                $('input[name="coupon_code"]').val(jQuery.parseJSON(result).coupon_code);
                $('input[name="coupon_code_hidden"]').val(jQuery.parseJSON(result).coupon_code);
            }
        });
    });
    
    $('#school-id').on('change', function() {
        $.ajax({
            url: '/admin/projects/' + $(this).val() +'.json',
            dataType: 'json',
            success: function(response) {
                $('#project-id').html('<option value="">Kies een project</option>');
                $('#group-id').html('<option value="">Selecteer een project</option>');
                $('#person-id').html('<option value="">Selecteer een klas</option>');
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
                $('#group-id').html('<option value="">Kies een klas</option>');
                $('#person-id').html('<option value="">Selecteer een klas</option>');
                for(item in response.groups) {
                    option = $('<option>').val(item).html(response.groups[item]);
                    $('#group-id').append(option);
                }
            }
        });
    });
    
    $('#group-id').on('change', function() {
        $.ajax({
            url: '/admin/groups/getStudentsByGroup/' + $(this).val(),
            dataType: 'json',
            success: function(response) {
                $('#person-id').html('<option value="">Kies een persoon</option>');
                for(item in response.groups.persons) {
                    var name = response.groups.persons[item].firstname + ' ' + response.groups.persons[item].prefix + ' ' + response.groups.persons[item].lastname;
                    option = $('<option>').val(response.groups.persons[item].id).html(name);
                    $('#person-id').append(option);
                }
            }
        });
    });
    
    $('#add-to-person').click(function() {
        $('.find-person').hide();
        
        if(this.checked) {
            $('.find-person').show();
        }
    });
    
    $('.find-person').hide();
    if($('#add-to-person')[0].checked) {
        $('.find-person').show();
    }
});