<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
          <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>:::: Cadastro de Sub&aacute;rea M&eacute;dica ::::</title>
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
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Cadastro de Sub&aacute;rea M&eacute;dica &gt;&gt;</a> </div>
            </div>
            <div id="content"  style="background-image:none;"> <br/>
                <div id="container">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-2">Cadastro de Sub&aacute;rea M&eacute;dica</a></li>
                        </ul>
                        <!-- CADASTRO DE SUB AREA MEDICA -->
                        <!-- TAB 2 -->
                        <div id="tabs-2">
                            <div class="mudar">
                                <form action="../app.control/cadastro_sub_area_medica.php" method="post">
                                    <label id="label1" style="width:130px;">&Aacute;rea M&eacute;dica :  </label>
                                    <select name = "id_area_medica" size="1" id="select_area_medica" class="textfield">
                                        <?php
                                        include_once '../app.control/classes/conexao.class.php';
                                        $conexao = new ConexaoDB();
                                        $conexao->conexao("medicina");
                                        $username = $_SESSION["username"];
                                        $sql = "select am.id_area_medica,am.area
                                                from area_medica am,login_area_medica la
                                                where la.id_area_medica = am.id_area_medica
                                                and am.status = 1 and la.username =  '$username'
                                               ";
                                        $stmt = @pg_query($sql);
                                        $rows = pg_numrows($stmt);
                                        for ($i = 0; $i < $rows; $i++) {
                                            $data = pg_fetch_row($stmt, $i);
                                        ?>
                                            <option  value="<?php echo $data[0] ?>"><?php echo $data[1] ?></option>
                                        <?php
                                        }
                                        $conexao->close();
                                        ?>
                                    </select>
                                    <br/>
                                    <br/>
                                    <label id="label1" style="width:130px;">Sub&aacute;rea Relacionada: </label>
                                    <input type="text"  name="sub_area" id="sub_area_medica" class=" textfield text ui-widget-content ui-corner-all"/>
                                    <div class="demo" style="display:none">
                                        <div id="dialog_sub_area" title="CADASTRO DE SUB AREA MEDICA">
                                            <p> </p>
                                        </div>
                                    </div>
                                    <br/>
                                    <br/>
                                    <button type="submit" id="btn_upload" class="ui-corner-all" onclick="return cadastraSubArea();"><img src="../images/book_add.png" align="right" style="vertical-align:middle" alt=""/>Cadastrar</button>
                                </form>
                            </div>
                        </div>
                        <!-- FIM CADASTRO DE  SUB AREA MEDICA -->
                    </div>
                </div>
                <div id="footer"></div>
            </div>
        </div>
    </body>
</html>