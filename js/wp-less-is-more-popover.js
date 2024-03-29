jQuery.noConflict();
jQuery( document ).ready( function( $ ){
    $('[data-toggle="tooltip"]').tooltip();
    $('.triggerpopover').popover({
        container: 'div.popoverContainer',
        html: true,
        content: function () {
        return '<code>' + wp_less_is_more_popover.allowed_tags + '</code>';
      },
    });
    $('#commenttext').each(function () {
      this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
      this.style.height = 'auto';
      this.style.height = (this.scrollHeight) + 'px';
    });
    $('#commenttext').css('height', '35');
    $('#commenttext').focus(function(){
       $('#form-input').collapse();
    });

    if ( wp_less_is_more_popover.commenttextfocus ) $('#commenttext').focus();
});
