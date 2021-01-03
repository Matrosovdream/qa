jQuery(document).on( 'click', '.gform_button, .gform_next_button', function() {
	jQuery(this).after('<img id="gform_ajax_spinner_2" class="gform_ajax_spinner" src="/wp-content/plugins/gravityforms/images/spinner.gif" alt="" style="padding-left: 0;">');
})