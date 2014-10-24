<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="pragma" content="no-cache"/>
<meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
<title>:::: Altera&ccedil;&atilde;o de Senha  ::::</title>
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
      <?php include '../includes/menu.inc';?>
    </div>
    <br/>
    <br/>
    <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Alterar Senha &gt;&gt;</a> </div>
  </div>
  <div id="content" style="background-image: none;" > <br>
    </br>
    <div id="tabs">
      <ul>
          <li><a href="#tabs-1">Altera&ccedil;&atilde;o de Senha</a></li>
      </ul>
      <div id="tabs-1">
      <div class="mudar">
        <form action="../app.control/altera_senha.php" method="post">
            <label id="label1">Digite seu nome de usu&aacute;rio:    </label>
            <input type="text" name="username" id="username"  class=" textfield text ui-widget-content ui-corner-all"/>
            <br/>
            <br/>
          <label id="label1">Digite sua senha:    </label>
            <input type="password" name="senha" id="senha"  class=" textfield text ui-widget-content ui-corner-all" />
          <br/>
          <br/>
          <label id="label1">Digite a nova senha:  </label>
            <input type="password" name="nova_senha" id="nova_senha"  class=" textfield text ui-widget-content ui-corner-all"/>
          <br/>
          <br/>
          <label id="label1">Digite novamente a nova senha: </label>
            <input type="password" name="nova_senha2" id="nova_senha2"  class=" textfield text ui-widget-content ui-corner-all"/>
          <br/>
          <br/>
          <!-- dialog -->
              <div class="demo" style="display:none">
                <div id="dialog_troca_senha" title="ALTERAR SENHA">
                  <p> </p>
                </div>
              </div>
              <!-- FIM DIALOG -->
            
              <button  type="button" id="btn_tr_senha" class="btn_upload ui-corner-all" onclick="return trocaSenha();"><img src="../images/bullet_key.png" align="right" style="vertical-align:middle" alt=""/>Trocar senha</button>
        </form>
        </div>
      </div>
    </div>
  </div>
  <div id="footer"></div>
</div>
</body>
</html>