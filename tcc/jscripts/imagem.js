function inicializaImagem() {
    // there's the gallery and the trash
    var $gallery = $('#gallery');

// image preview function, demonstrating the ui.dialog used as a modal window
function viewLargerImage($link) {
    var src = $link.attr('href');
    var title = $link.siblings('img').attr('alt');
    var $modal = $('img[src$="'+src+'"]');
    
    if ($modal.length) {
        $modal.dialog('open')
    } else {
        var img = $('<img alt="'+title+'" width="auto" height="auto" style="display:none;padding: 8px;" />')
        .attr('src',src).appendTo('body');
        setTimeout(function() {
         
          img.dialog({

                title: title,
                width: 'auto',
                height: 'auto',
                modal: true,
                position: ['center','top']
                               
            });
        }, 1);
    }
}

// resolve the icons behavior with event delegation
$('ul.gallery > li').click(function(ev) {
    var $item = $(this);
                   
    var $target = $(ev.target);               
    if ($target.is('a.ui-icon-zoomin')) {
        viewLargerImage($target);
    }
    return false;
});
}
