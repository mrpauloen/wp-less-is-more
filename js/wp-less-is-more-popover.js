jQuery.noConflict();
jQuery( document ).ready( function( $ ){

    $('[data-toggle="tooltip"]').tooltip();
    $('.triggerpopover').popover({
container: 'div.popoverContainer',
html: true,
content: function () {
        return '<code><?php echo allowed_tags(); ?></code></div>';
      },
    });

    $('#textarea').each(function () {
      this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
      this.style.height = 'auto';
      this.style.height = (this.scrollHeight) + 'px';
    });
    $('#textarea').css('height', '52');
});
