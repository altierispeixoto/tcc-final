<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="pragma" content="no-cache"/>
<meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>:::: Upload de Imagens  ::::</title>
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
                $("#subtabs").tabs();
            });
        </script>
        <script type="text/javascript">
            //<![CDATA[
            $(document).ready(iniciaEventos);
            function iniciaEventos(){
                $('#d').toggle(abreTextareaDiagnostico,fechaTextareaDiagnostico);
                $('#o').toggle(abreTextareaObs,fechaTextareaObs);
            }
            //]]>
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
                    <?php
                    include '../includes/menu.inc';
                    ?>
                </div>
                <br/>
                <br/>
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Upload &gt;&gt;</a> </div>
            </div>
            <div id="content" style="background-image:none;" > <br/>
                <form action="uploaded.php" method="post" id="formulario" enctype="multipart/form-data">
                      <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1"><span>Upload de Imagens</span></a> </li>
                        </ul>
                        <div id="tabs-1">
                            <div id="subtabs">
                                <ul>
                                    <li><a href="#subtabs-1"> <h5>Upload</h5></a></li>    
                                </ul>
                                <!-- SUB TAB 1  -->
                                <div id="subtabs-1">
                                    <div class="mudar">
                                        <label>Patologia Relacionada :
                                            <select name = "patologia" size="1" class="textfield" id="patologia">
                                                <option value="-1" >Selecione</option>
                                                <?php
                                                include_once '../app.control/classes/conexao.class.php';
                                                $conexao = new ConexaoDB();
                                                $conexao->conexao("medicina");
                                                $username = $_SESSION["username"];
                                                $sql = "select p.id_patologia,p.descricao
                                                   from idx_patologia p , login_area_medica la
                                                   where p.id_area_medica = la.id_area_medica
                                                   and p.status = 1 and la.username = '$username'"; // verificar a area medica logada

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
                                        <label id="categoria"  style="display: none">Categoria :
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
                                        <label id="composicao"  style="display: none">Composi&ccedil;&atilde;o :
                                            <select name="composicao" class="textfield">
                                                <option value="-1">Selecione</option>
                                                <option value="1">I</option>
                                                <option value="2">II</option>
                                                <option value="3">III</option>
                                                <option value="4">IV</option>
                                              
                                            </select>
                                        </label>
                                        <br/>
                                        <br/>
                                        <input type="hidden" name="MAX_FILE_SIZE"  value="3000000">
                                        </input>
                                        <label>Upload da Imagem :
                                            <input type="file" name="imagem" size="40" id="imagem" class="ui-corner-all">
                                            </input>
                                        </label>
                                        <br/>
                                        <br/>
                                        <br/>
                                        <fieldset><legend>Diagn&oacute;stico :<img src="../images/mais.png" id="d" alt="" ></img></legend>
                                            <textarea   name="diagnostico" cols="80" rows="9" id="diagnostico" class="ui-widget-content  ui-corner-all"></textarea>
                                        </fieldset>
                                        <br/>
                                        <fieldset><legend>Observa&ccedil;&otilde;es:<img src="../images/mais.png" id="o" alt="" ></img></legend>
                                            <textarea   name="obs" cols="80" rows="9" id="obs" class=" ui-widget-content  ui-corner-all"></textarea>
                                        </fieldset>
                                        <br/>
                                        <button type="submit"  id = "btn_upload" class="ui-corner-all" ><img src="../images/picture_add.png" align="right" style="vertical-align:middle" alt=""/>Enviar imagem</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>