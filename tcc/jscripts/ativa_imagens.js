 function inicializa() {
                // there's the gallery and the trash
                var $gallery = $('#gallery'), $trash = $('#trash');

                // let the gallery items be draggable
                $('li',$gallery).draggable({
                    cancel: 'a.ui-icon',// clicking an icon won't initiate dragging
                    revert: 'invalid', // when not dropped, the item will revert back to its initial position
                    containment: $('#demo-frame').length ? '#demo-frame' : 'document', // stick to demo-frame if present
                    helper: 'clone',
                    cursor: 'move'
                });

                // funcao de ativacao de imagem
                function ativaImage($item,item2) {

                    //troca o icone de refresh pelo icone de lixeira imagem
                    var recycle_icon = '<a href="../app.control/ativa_imagem.php?'+item2+'" title="Desativar esta imagem" class="ui-icon ui-icon-trash">Recycle image</a>';
                    $item.fadeOut(function() {
                        var $list = $('ul',$trash).length ? $('ul',$trash) : $('<ul class="gallery ui-helper-reset"/>').appendTo($trash);
                         //remove o icone de refresh
                        $item.find('a.ui-icon-refresh').remove();
                        //adiciona o icone de lixeira
                        $item.append(recycle_icon).appendTo($list).fadeIn(function() {
                            $item.animate({ width: 'auto' }).find('img').animate({ height: 'auto' });
                        });
                    });

                    $.get("../app.control/ativa_imagem.php",{'id_imagem':item2});
                }

                // image recycle function
                function desativaImage($item,item2) {

                    //troca o icone de lixeira pelo de refresh
                    var trash_icon = '<a href="../app.control/deleta_imagem.php?'+item2+'" title="Ativar esta imagem" class="ui-icon ui-icon-refresh">Delete image</a>';

                    $item.fadeOut(function() {
                        $item.find('a.ui-icon-trash').remove();
                        $item.css('width','auto').append(trash_icon).find('img').css('height','auto').end().appendTo($gallery).fadeIn();
                    });
                    $.get("../app.control/deleta_imagem.php",{'id_imagem':item2});
                }

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
                                modal: true,
                                position: ['center','top']
                            });
                        }, 1);
                    }
                }

                // resolve the icons behavior with event delegation
                $('ul.gallery > li').click(function(ev) {
                    var $item = $(this);
                    var item2 = this.id;

                    var $target = $(ev.target);

                    if ($target.is('a.ui-icon-refresh')) {
                        ativaImage($item,item2);
                    } else if ($target.is('a.ui-icon-zoomin')) {
                        viewLargerImage($target);
                    } else if ($target.is('a.ui-icon-trash')) {
                        desativaImage($item,item2);
                    }
                    return false;
                });
            }

