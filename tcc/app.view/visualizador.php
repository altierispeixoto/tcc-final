<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>:::: Visualizador ::::</title>
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
        <script type="text/javascript">
            $(function(){
                $('#patologia').change(function(){
                    if( $(this).val() == "1" )
                    {
                        $('#categoria').show();
                        $('#composicao').show();
                    }
                    else{
                        $('#categoria').hide();
                        $('#composicao').hide();
                    }
                });
            });
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
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Visualizador de Imagens M&eacute;dicas &gt;&gt;</a> </div>
            </div>
            <div id="content" style="background-image:none;" > <br/>
                <div id="container">
                    <form action="painel_imagens.php" method="get">
                        <div id="tabs">
                            <ul>
                                <li><a href="#tabs-1"><span> Busca de Imagens</span></a> </li>
                            </ul>
                            <div id="tabs-1">
                                <div class="mudar ui-corner-all" style="background-color:#CCC;border: 2px double #999;" >
                                    <br/>
                                    <br/>
                                    <input type="hidden" name="pagina" value="1" id="pagina" />
                                    <label class="label1" style="width: auto">Patologia Relacionada :
                                        <select name = "patologia" class="textfield" id="patologia">
                                            <option value="-1" >Selecione</option>
                                            <?php
                                            include_once '../app.control/classes/conexao.class.php';
                                            $conexao = new ConexaoDB();
                                            $conexao->conexao("medicina");

                                            $sql = "select id_patologia,descricao from idx_patologia where status = 1";// verificar a area medica logada
                                            $stmt = pg_query($sql);
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
                                    </label>
                                    <label id="categoria" style="display: none;width: auto" class="label1">Categoria :
                                        <select name="categoria" class="textfield">
                                            <option value="-1">Selecione</option>
                                            <option value="0">0</option>
                                            <option value="1">I</option>
                                            <option value="2">II</option>
                                            <option value="3">III</option>
                                            <option value="4">IV</option>
                                            <option value="4A">IV-A</option>
                                            <option value="4B">IV-B</option>
                                            <option value="4C">IV-C</option>
                                            <option value="5">V</option>
                                        </select>
                                    </label>
                                    <label id="composicao" style="display: none;width: auto" class="label1">Composi&ccedil;&atilde;o :
                                        <select name="composicao" class="textfield">
                                            <option value="-1">Selecione</option>
                                            <option value="1">I</option>
                                            <option value="2">II</option>
                                            <option value="3">III</option>
                                            <option value="4">IV</option>
                                         
                                        </select>
                                    </label>
                                    <br />
                                    <br />
                                    <br /><br />
                                    <label id="num_imagens" class="label1">N&uacute;mero de Imagens por p&aacute;gina
                                        <select name="num_imagens" id="select_num_imagens">
                                            <option value="10" >10</option>
                                            <option value="20" >20</option>
                                            <option value="30" >30</option>
                                            <option value="40" >40</option>
                                            <option value="50" >50</option>
                                        </select>
                                    </label>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <button type="submit"  id = "btn_upload" class=" ui-corner-all" style="float:left;margin-left:20px;"><img src="../images/go.png" align="right" style="vertical-align:middle" alt="" />Buscar imagens</button>
                                    <br/>
                                    <br/>
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>