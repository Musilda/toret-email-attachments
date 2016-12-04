(function ( $ ) {
	"use strict";

	$(function () {

		jQuery( document ).on( 'click', '.insert-media', function( event ) {
		
			var textfieldid = jQuery(this).prev().attr('id');
      
    		wp.media.editor.send.attachment = function(props, attachment){
      			jQuery('#' + textfieldid).val(attachment.url);
    		}
    		wp.media.editor.open(this);
			return false;
		
		});

	});

}(jQuery));