jQuery(document).ready(function($) {
    $('#stray-animals-filter-form').submit(function(event) {
        event.preventDefault();
        var filterData = $(this).serialize();
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: 'action=filter_stray_animals&' + filterData,
            success: function(response) {
                // Update the results container with filtered content
                $('#stray-animals-results').html(response);
            }
        });
    });
});
