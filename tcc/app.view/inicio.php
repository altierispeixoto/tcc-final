<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>       ::: INICIO :::</title>
        <link type="text/css" href="../css/style.css" rel="stylesheet" />
        <link type="text/css" href="../css/menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jscripts/jquery/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="../jscripts/menu.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.core.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.tabs.js"></script>
        <script type="text/javascript" src="../jscripts/funcoes.js"></script>
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
    </head>
    <body oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
        <div id="wrap">
            <div id="header"> <a href="../app.control/logout.php" id="linkexit">Logout<img src="../images/door_open.png" alt="" id="iconexit"></img></a>
                <div id="menux">

                    <?php
                    include '../includes/menu.inc';
                    ?>
                </div>
                <br/>
                <br/>
                <div id="postheader"> <a id="linkmap" >Home &gt;&gt;</a></div>
            </div>
            <div >
                <br/>
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1"><?php echo 'Bem vindo <b>'.$_SESSION["nome"].'</b> !'; ?></a></li>
                    </ul>
                    <div id="tabs-1">
                        <div id="content"></div>

                    </div>
                </div>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>