<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>:::: Relatorios ::::</title>
        <link type="text/css" href="../css/style.css" rel="stylesheet" />
        <link type="text/css" href="../css/menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jscripts/jquery/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="../jscripts/menu.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.core.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.tabs.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.draggable.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.resizable.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.dialog.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/jquery.bgiframe.js"></script>
        <link type="text/css" href="../css/jquery/demos.css" rel="stylesheet" />
        <link type="text/css" href="../css/jquery/ui.all.css" rel="stylesheet" />
        <script type="text/javascript">
            $(function() {
                $("#tabs").tabs();
            });
        </script>
        <script type="text/javascript">
            //<![CDATA[
            $(document).ready(function(){
                $('#menu_left').css('height', 'auto');
                $('#menu_left ul').hide();
                $('#menu_left h3').click(function(){
                    $(this).next().slideToggle(800)
                    .siblings('ul:visible').slideUp(800);
                    $(this).toggleClass('corrente');
                    $(this).siblings('#menu_left h3').removeClass('corrente');
                });
            });
            // ]]>
        </script>
    </head>
    <body oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
        <div id="wrap">
            <div id="header"> <a href="../app.control/logout.php" id="linkexit">Logout<img src="../images/door_open.png" alt="" id="iconexit"></img></a>
                <div id="menux">
                    <?php include '../includes/menu.inc'; ?>
                </div>
                <br/>
                <br/>
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Relatorios do Sistema</a> </div>
            </div>
            <div id="content" style="background-image:none;" > <br/>
                <div id="container">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1"><span> Busca de Imagens</span></a> </li>
                        </ul>
                        <div id="tabs-1">
                            <div class="mudar ui-corner-all" style="background-color:#CCC;border: 2px double #999;" >


                                <div>
                                    <div id="graficos" style="border: #999 1px solid;">
                                        <img src="../phplot-5.1.3/grafico.php"></img>
                                    </div>
                                    <!-- inicio menu left -->
                                    <div id="menu_left" class ="ui-corner-all">

                                        <h3>Relatorios PDF</h3>
                                        <ul>
                                            <li><a href="../app.view/relatorios/relatorio_usuarios.php" title="Relacao de Usuarios Ativos no Sistema">Relatorio de Usuarios</a></li>
                                            <li><a href="#" title="Relacao de Areas Medicas , Subareas e Patologias ativas no Sistema">Relatorio de Areas Medicas, Subareas e Patologias ativas no Sistema</a></li>
                                        </ul>

                                        <h3>Relatorios Gráficos</h3>
                                        <ul>
                                            <li><a href="#" title="Grafico de Utilizacao do Sistema">Grafico de Utilizacao do Sistema</a></li>
                                            <li><a href="#" title="Grafico de Imagens por Subarea Medica">Grafico de Imagens por Subarea Medica</a></li>
                                        </ul>
                                       
                                    </div>
                                    <!-- fim menu left -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer"></div>

    </body>
</html>