jQuery(function($) {
    $("#orderstatus").change(function() {
        var orderId = $(this).data('id');
        var orderstatusId = $('option:selected', this).val();
        $.ajax({
            url: '/admin/orders/edit/'+ orderId +'.json',
            data: {
                orderstatus_id: orderstatusId,
            },
            method: 'POST',
            dataType:"json",
            success: function(response) {
                if (response.success == true) {
                    $('#statusHistory').prepend(
                        "<tr><th>" + response.orderstatusChange.formattedCreated + "</th><td>"
                        + response.orderstatusChange.orderstatus.name + "</td></tr>"
                    )
                }
            }
        });
    });
    
    $("#orderstatus-supplier").change(function() {
        var orderId = $(this).data('id');
        var orderstatusId = $('option:selected', this).val();
        $.ajax({
            url: '/supplier/orders/edit/'+ orderId +'.json',
            data: {
                orderstatus_id: orderstatusId,
            },
            method: 'POST',
            dataType:"json",
            success: function(response) {
                if (response.success == true) {
                    $('#statusHistory').prepend(
                        "<tr><th>" + response.orderstatusChange.formattedCreated + "</th><td>"
                        + response.orderstatusChange.orderstatus.name + "</td></tr>"
                    )
                }
            }
        });
    });
    
});