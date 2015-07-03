jQuery(document).ready( function($) {
    $('.postbox').prepend('<div class="handlediv" title="Click to toggle">&nbsp;</div>');
    $('.postbox h3').click( function() {
        $($(this).parent().get(0)).toggleClass('closed');
    });

    $('.meta-box-sortables').sortable({
        opacity: 0.65,
        cursor: 'move',
        handle: '.hndle'
    });
});
