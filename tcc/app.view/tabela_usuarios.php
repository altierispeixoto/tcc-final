<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>:::: Tabela de Usu&aacute;rios ::::</title>
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
        <script type="text/javascript" language="javascript" src="../media/js/jquery.dataTables.js"></script>
        <style type="text/css" title="currentStyle">
            @import "../media/css/demo_page.css";
            @import "../media/css/demo_table_jui.css";
        </style>
        <script type="text/javascript">
            $(function() {
                $("#tabs").tabs();
            });
        </script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                oTable = $('#example').dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers"
                });
            } );
        </script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(desativaUsuario);
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
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Tabela de Usu&aacute;rios &gt;&gt;</a> </div>
            </div>
            <div> <br>
                </br>
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Pesquisar Usu&aacute;rios</a></li>
                        <form method="post" action="relatorios/relatorio_usuarios.php">
                            <button type="submit" id="btn_upload" style="width: auto" class="ui-corner-all"><img src="../images/page_gear.png" align="right" style="vertical-align:middle" alt=""/>Gerar Relat&oacute;rio de Usu&aacute;rios</button>
                        </form>
                    </ul>
                    <!--FORMULARIO DE BUSCAR DE USUARIOS -->
                    <div id="tabs-1">
                        <div class="mudar">

                            <div id="dt_example">
                                <div id="container2">

                                    <div class="demo_jui">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <?php
                                            include_once '../app.control/classes/conexao.class.php';
                                            $conexao = new ConexaoDB();
                                            $conexao->conexao("medicina");
                                            ?>
                                            <thead>
                                                <tr>
                                                    <th >ID</th>
                                                    <th align="justify">Nome</th>
                                                    <th >Nome de Usuario</th>
                                                    <th >Email</th>
                                                    <th >Nivel de Acesso</th>
                                                    <th >Status</th>
                                                    <th >Desativar Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT USUARIO.ID_USUARIO,USUARIO.NOME,USUARIO.USERNAME,USUARIO.EMAIL,LOGIN.NV_ACESS,LOGIN.STATUS
   FROM USUARIO USUARIO,LOGIN LOGIN WHERE USUARIO.USERNAME = LOGIN.USERNAME AND LOGIN.STATUS = 1 AND USUARIO.STATUS = 1 ORDER BY USUARIO.NOME ASC";

                                                $stmt = pg_query($sql);
                                                $rows = pg_num_rows($stmt);
                                                for ($i = 0; $i < $rows; $i++) {
                                                    $data = pg_fetch_row($stmt, $i);
                                                    echo '<tr class="gradeC">';
                                                    echo '<td >' . $data[0] . '</td>';   //id_usuario
                                                    echo '<td >' . $data[1] . '</td>'; // nome
                                                    echo '<td >' . $data[2] . '</td>'; //username
                                                    echo '<td >' . $data[3] . '</td>'; //email
                                                    if ($data[4] == 1) {
                                                        echo '<td ><img src="../images/user.png"/>Aluno</td>'; //nv_acess
                                                    } else if ($data[4] == 2) {
                                                        echo '<td ><img src="../images/user_suit.png"/>Medico</td>'; //nv_acess
                                                    } else if ($data[4] == 3) {
                                                        echo '<td ><img src="../images/user_gray.png"/>Administrador</td>'; //nv_acess
                                                    }
                                                    echo '<td id=' . status . $data[2] . '>Ativo</td>'; // status
                                                    echo '<td><button type="submit" id=' . $data[2] . '  class=" btn_upload ui-corner-all" style="font-family:\'Arial Black\', Gadget, sans-serif">Desativar</button></td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [[ FIM DO FORMULARIO ]] -->
                        <div class="demo" style="display:none">
                            <div id="usuario" title="DESATIVACAO DE USUARIO">
                                <p> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>