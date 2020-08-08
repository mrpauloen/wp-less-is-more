jQuery.noConflict();

jQuery( document ).ready( function( $ ){

var element = $( document.querySelectorAll('[data-customize-setting-link="display_footer_text"]' ));
var target = $( '#customize-control-custom_footer_control' );

	if ( element.is(':checked') ) {
			target.show();
        } else {
			target.hide();
        }

	$( element ).click( function () {
		if ( $( this ).is( ':checked' )) {
			target.show();
		} else {
			target.hide();
		}
	});
});
