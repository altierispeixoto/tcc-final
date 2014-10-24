<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="pragma" content="no-cache"/>
<meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
<title>:::: Cadastro de &Aacute;rea M&eacute;dica ::::</title>
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
    <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Cadastro de &Aacute;rea M&eacute;dica &gt;&gt;</a> </div>
  </div>
  <div id="content"  style="background-image:none;"> <br/>
    <div id="container">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Cadastro de &Aacute;rea M&eacute;dica</a></li>
        </ul>
        <!-- CADASTRO DE AREA MEDICA -->
        <!-- TAB 1 -->
        <div id="tabs-1">
          <div class="mudar">
            <form action="../app.control/cadastro_area_medica.php" method="post">
                <label id="label1" style="width:100px;">&Aacute;rea M&eacute;dica: </label>
                <input type="text" maxlength="60" name="area_medica" id="area_medica" class=" textfield text ui-widget-content ui-corner-all" />
             
              <!-- dialog -->
              <div class="demo" style="display:none">
                <div id="dialog_area_medica" title="CADASTRO DE AREA MEDICA">
                  <p> </p>
                </div>
              </div>
              <!-- FIM DIALOG -->
              <br/>
              <br/>
              <button type="submit" id="btn_upload" class="ui-corner-all" onclick="return cadastraAreaMedica();"><img src="../images/book_add.png" align="right" style="vertical-align:middle" alt=""/>Cadastrar</button>
            </form>
          </div>
        </div>
        <!--  FIM CADASTRO DE AREA MEDICA -->
      </div>
    </div>
    <div id="footer"></div>
  </div>
</div>
</body>
</html>