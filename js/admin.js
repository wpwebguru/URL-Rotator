jQuery(document).ready(function () {
    jQuery('.url_rotator_mgs_delete_form').submit(function(e) {
        if ((!confirm('Are you sure you want to delete the field?'))) {
            return false;
        }
    });
    
    jQuery('.url_rotator_mgs_reset_form').submit(function(e) {
        if ((!confirm('Are you sure you want to reset the counter?'))) {
            return false;
        }
    });
    
    jQuery('.url_rotator_mgs_delete_url_form').submit(function(e) {
        if ((!confirm('Are you sure you want to delete the field?'))) {
            return false;
        }
    });
    
    jQuery('#url_rotator_mgs_name').keyup(function() {
        var val = jQuery('#url_rotator_mgs_name').val();
        jQuery('#url_rotator_mgs_name').val( val.replace(" ","-") );

    });

    jQuery('#url_rotator_mgs_name').change(function () {

        jQuery.each(aName, function (key, value) {
            if (value.name == jQuery('#url_rotator_mgs_name').val()) {
                jQuery('#url_rotator_mgs_link').val(value.link);

                jQuery('#url_rotator_mgs_submit').val('Modify');
                jQuery('#url_rotator_mgs_name').prop('readonly', true);
                jQuery('#url_rotator_mgs_cancel').show();
            }
        })
    })

    jQuery('.edit').click(function () {
        jQuery(this).parent().parent().css('border', 'solid 1x red');
        name = jQuery(this).attr('data-name');
        key = jQuery(this).attr('data-key');
        url = jQuery(this).attr('data-url');

        jQuery('#url_rotator_mgs_key_' + name).val(key);
        jQuery('#url_rotator_mgs_url_' + name).val(url);

        jQuery('#url_rotator_mgs_new_url_submit_' + name).val('Modify');
        jQuery('#url_rotator_mgs_new_url_cancel_' + name).show();
    });

    jQuery('.url_rotator_mgs_new_url_cancel').click(function () {
        name = jQuery(this).attr('data-name');
        
        jQuery('#url_rotator_mgs_key_' + name).val(null);
        jQuery('#url_rotator_mgs_url_' + name).val(null);
        jQuery('#url_rotator_mgs_new_url_submit_' + name).val('Save');

        jQuery('#url_rotator_mgs_new_url_cancel_' + name).hide();
    });
})