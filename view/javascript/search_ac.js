jQuery(document).ready(function ($){  
    var acs_action = 'search_autocomplete';  
   
    
    $("input[name='users']").autocomplete({
      source: function( request, response ) {
        $.ajax({
            url: MyAcSearch.url + '?callback=?&action=' + acs_action + '&term=' + encodeURIComponent(request.term),
            dataType: "json",
            data: {
                q: request.term
            },
            complete: function( data ) {
                var json = JSON.parse(data.responseText);

                response($.map(json, function(item) {
                    return {
                            label: item.name,
                            value: item.phone
                        }
                }));
            }
        });
        },
        select: function(event, ui) {
            $('.customer').each(function () {
                if($(this).attr('data-phone') == ui.item.value) 
                    $(this).remove();
            });
            $('input[name="users"]').val("");
            $('#adding_users').next('#added_users').find('.numbers_scrollbar').find('ul').append('<li><span class="customer" data-phone="'+ui.item.value+'"><span class="phone_entry">'+ui.item.label+'</span><i class="dashicons dashicons-no-alt"></i></span</li>');

            $('.customer').delegate('.dashicons-no-alt', 'click', function() {
                    $(this).parent().remove();
            });

            return false;    
        },

    });
});  

