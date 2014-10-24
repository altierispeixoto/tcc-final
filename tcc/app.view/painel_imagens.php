<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>:::: Painel de Imagens ::::</title>
        <link type="text/css" href="../css/style.css" rel="stylesheet" />
        <link type="text/css" href="../css/menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jscripts/jquery/jquery-1.3.2.js"></script> 
        <script type="text/javascript" src="../jscripts/jquery/ui.core.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.tabs.js"></script>        
        <script type="text/javascript" src="../jscripts/imagem.js"></script>
        <link type="text/css" href="../css/jquery/demos.css" rel="stylesheet" />
        <link type="text/css" href="../css/jquery/ui.all.css" rel="stylesheet" />
        <link type="text/css" href="../css/global.css" rel="stylesheet" />
        <script type="text/javascript" src="../jscripts/jquery/ui.draggable.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.resizable.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.dialog.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.droppable.js"></script>
        <script type="text/javascript" src="../jscripts/plugins/qtip-1.0.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#tabs").tabs();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(inicializaImagem); 
        </script>
        <script type="text/javascript">
            // Create the tooltips only on document load
            $(document).ready(function()
            {
                // Use the each() method to gain access to each elements attributes
                $('#gallery li h5 a[rel]').each(function()
                {
                    $(this).qtip(
                    {
                        content: {
                            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
                            text: '<img  src="../images/loader.gif" alt="Loading..." />',
                            url: $(this).attr('rel'), // Use the rel attribute of each element for the url to load
                            title: {
                                text: '<strong>Diagnostico e Observacoes</strong>', // Give the tooltip a title using each elements text
                                button: '<img src="../images/cancel.png" alt="Fechar"></img>' // Show a close link in the title
                            }
                        },
                        position: {
                            corner: {
                                target: 'bottomMiddle', // Position the tooltip above the link
                                tooltip: 'topMiddle'
                            },
                            adjust: {
                                screen: true // Keep the tooltip on-screen at all times
                            }
                        },
                        show: {
                            when: 'click',
                            solo: true // Only show one tooltip at a time
                        },
                        hide: 'unfocus',
                        style: {
                            tip: true, // Apply a speech bubble tip to the tooltip at the designated tooltip corner
                            border: {
                                width: 0,
                                radius: 2
                            },
                            name: 'light', // Use the default light style
                            width: 570 // Set the tooltip width
                        }
                    })
                });
            });
        </script>
    </head>
    <body oncontextmenu="return false" ondragstart="return false" onselectstart="return false" onkeydown="return false">
        <div id="wrap">
            <div id="header"> <a href="../app.control/logout.php" id="linkexit">Logout<img src="../images/door_open.png" alt="" id="iconexit"></img></a>
                <div id="menux">
                    <?php
                    include '../includes/menu.inc';
                    ?>
                </div>
                <br/>
                <br/>
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a href="visualizador.php" id="linkmap" >Visualizador de Imagens &gt;&gt;</a> <a id="linkmap" >Painel de Imagens &gt;&gt;</a> </div>
            </div>
            <div id="content" style="background-image:none;" > <br/>
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1"><span>
                                    <?php
                                    include_once '../app.control/classes/imagem.class.php';
                                    $imagem = new Imagem();
                                    $imagem->retornaPatologia($_GET["patologia"], $_GET["categoria"], $_GET["composicao"],1);
                                    ?>
                                </span></a> </li>
                        <span style="float: right">
                            <?php
                                    $imagem->retornaNumImagens($_GET["patologia"], $_GET["categoria"], $_GET["composicao"], 1);
                            ?>
                                </span>
                            </ul>
                            <div id="tabs-1">
                                <div class="mudar" style="background-color:#CCC;border:2px double #999">

                                    <br/>
                                    <div class="demo ui-widget ui-helper-clearfix">
                                        <ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix" style="width: auto;">
                                    <?php
                                    if ($_GET["patologia"] == "1") {
                                        $imagem->painelImagensBiRads($_GET["pagina"], $_GET["patologia"],
                                                $_GET["num_imagens"], $_GET["composicao"],$_GET["categoria"]);
                                    } else {
                                        $imagem->painelImagens($_GET["pagina"], $_GET["patologia"], $_GET["num_imagens"]);
                                    }
                                    ?>
                                </ul>
                            </div>
                            <br/>
                            <br/>
                            <center>
                                <?php
                                    if ($_GET["patologia"] == "1") {
                                        $imagem->paginadorBiRads($_GET["pagina"], $_GET["patologia"], $_GET["num_imagens"], $_GET["categoria"], $_GET["composicao"]);
                                    } else {
                                        $imagem->paginador($_GET["pagina"], $_GET["patologia"], $_GET["num_imagens"]);
                                    }
                                ?>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>