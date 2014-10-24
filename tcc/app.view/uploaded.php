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
            });
        </script>
        <script type="text/javascript">
            $(document).ready(edita_e_envia);
    
     function edita_e_envia(){
          $('#edit').toggle(ativa_textareas,enviaDadosAlterados);
     }
        </script>
      <script type="text/javascript">
            $(function(){
                $('#patologia').change(function(){
                    if( $(this).val() == "1" )
                    {
                        $('#categoria').show();
                        $('#composicao').show();
                        $('#cat').removeAttr('disabled');
                        $('#comp').removeAttr('disabled');
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
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a  href="upload.php" id="linkmap" >Upload &gt;&gt;</a><a id="linkmap" >Imagem Carregada &gt;&gt;</a> </div>
            </div>
            <div id="content" style="background-image:none;" > <br/>
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1"><span>Upload de Imagens</span></a> </li>
                        <form method="post" action="upload.php">
                            <button  type="submit" class="btn_upload ui-corner-all" style="width:auto; font-family:'Arial Black', Gadget, sans-serif;"><img src="../images/picture_add.png" align="right" style="vertical-align:middle" alt=""/>Enviar outra imagem</button>
                            <button  type="button" id="edit" class="btn_upload ui-corner-all" style="margin-left: 5px;width:auto; font-family:'Arial Black', Gadget, sans-serif;">Editar dados da imagem</button>
                        </form>
                    </ul>
                    <div id="tabs-1">
                        <br/>
                        <?php
                        include_once '../app.control/executa_upload.php';
                        ?>
                        <br/>
                        <br/>
                    </div>
                </div>
                   <!-- dialog -->
              <div class="demo" style="display:none">
                <div id="dialog_imagem" title="ALTERACAO DE DADOS DA IMAGEM">
                  <p> </p>
                </div>
              </div>
              <!-- FIM DIALOG -->
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>