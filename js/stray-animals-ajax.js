jQuery(document).ready(function($) {
    $('#stray-animals-filter-form').submit(function(event) {
        event.preventDefault();
        var filterData = $(this).serialize();
        
        $.ajax({
            url: ajax_object.ajax_url, // Ensure ajax_object is properly localized in your PHP file
            type: 'POST',
            data: {
                action: 'filter_stray_animals', // The WP hook action
                formData: filterData, // Pass the serialized data here
                nonce: ajax_object.nonce // Assuming you've localized a nonce as well
            },
            success: function(response) {
                // Update the results container with filtered content
                $('#stray-animals-results').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle errors here
                console.error('Error: ', textStatus, errorThrown);
                $('#stray-animals-results').html('<p>There was an error processing your request.</p>');
            }
        });
    });
});
