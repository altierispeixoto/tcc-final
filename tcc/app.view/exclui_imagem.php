<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="pragma" content="no-cache"/>
<meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
<title>:::: Desativa&ccedil;&atilde;o / Ativa&ccedil;&atilde;o de imagens  ::::</title>
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
<script type="text/javascript" src="../jscripts/jquery/ui.droppable.js"></script>
<?php
$status = $_POST["ativacao"];
$id_patologia = $_POST["patologia"];


if ($id_patologia == "1") {
$comp = $_POST["composicao"];
$cat = $_POST["categoria"];
}
else{
  $comp = '';
  $cat = '';
}

if ($status == 1) {
echo ' <script type="text/javascript" src="../jscripts/exclui_imagens.js"></script>';
} else {
echo ' <script type="text/javascript" src="../jscripts/ativa_imagens.js"></script>';
}
$limit = $_POST["num_imagens"];
#passar as datas de inicio e fim


$dt_inicio = $_POST["dt_inicio"];
$dt_fim = $_POST["dt_fim"];

#validar a data inicial e data final --> dt_fim > dt_inicio
#mostrar o periodo de upload das imagens no painel de imagens
#recuperar os dados do periodo de upload selecionado
#colocar um efeito CSS na primeira pagina carregada pelo ajax e retirar quando trocar de pagina
?>
<script type="text/javascript">
$(document).ready(inicializaPagina);
function inicializaPagina(){
carrega();
load();
}

function load() {

$(".imagem").click(function() {
$(".imagem").css('color','black').css('background-color','white');
$.post(this.href,function(data){
$('#gallery').html(data);
});
$(this).css('color','silver').css('background-color','blue');
return false;
});
}

function carrega(){

$.get('painel.php', {'id_patologia':<?php echo $id_patologia ?>,
'ativacao':<?php echo $status ?>,
'limit':<?php echo $limit ?>,
'offset':<?php echo 0 ?>,
'dt_inicio':<?php echo "\"" . $dt_inicio . "\"" ?>,
'dt_fim':<?php echo "\"" . $dt_fim . "\"" ?>,
'cat':<?php echo "\"".$cat."\"" ?>,
'comp':<?php echo "\"".$comp."\"" ?>
}, function(data) {

$('#gallery').html(data);
return false;
});
}

</script>
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
<?php include '../includes/menu.inc'; ?>
</div>
<br/>
<br/>
<?php
/*
include_once '../app.control/classes/conexao.class.php';
$conexao = new ConexaoDB();
$conexao->conexao("medicina");
*/
if ($status == 1) {
echo '<div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a href="visualizador_exclusao.php" id="linkmap" >Desativa&ccedil;&atilde;o / Ativa&ccedil;&atilde;o de imagens &gt;&gt;</a><a id="linkmap" >Painel de Desativa&ccedil;&atilde;o de imagens &gt;&gt;</a></div>';
} else {
echo '<div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a href="visualizador_exclusao.php" id="linkmap" >Desativa&ccedil;&atilde;o / Ativa&ccedil;&atilde;o de imagens &gt;&gt;</a><a id="linkmap" >Painel de Ativa&ccedil;&atilde;o de imagens &gt;&gt;</a></div>';
}
?>
</div>
<div> <br>
</br>
<div id="tabs">
<ul>

<?php
if ($status == 1) {
echo '<li><a href="#tabs-1">Desativa&ccedil;&atilde;o de imagens</a></li>';
} else {
echo'<li><a href="#tabs-1">Ativa&ccedil;&atilde;o de imagens</a></li>';
}
include_once '../app.control/classes/imagem.class.php';
$imagem = new Imagem();
echo '<span style="float: right">';
$imagem->retornaPatologia($id_patologia, $cat, $comp, 1);
echo '</span';
?>

</ul>
<div id="tabs-1">
<div class="mudar">
<div class="demo ui-widget ui-helper-clearfix">
<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">

</ul>
<div id="trash" class="ui-widget-content ui-state-default">
<h4 class="ui-widget-header"><span class="ui-icon

                                   <?php
                                   if ($status == 1) {
                                       echo 'ui-icon-trash';
                                   } else {
                                       echo 'ui-icon-circle-check';
                                   }
                                   ?>

                                   "></span>
                                   <?php
                                   if ($status == 1) {
                                       echo 'Imagens Desativadas';
                                   } else {
                                       echo 'Imagens Ativadas';
                                   }
                                   ?>
                            </h4>
                            </div>
                            </div>
                            </div>
                            </div>

                            <center>
                            <?php
                                   include_once '../app.control/classes/conexao.class.php';
                                   $conexao = new ConexaoDB();
                                   $conexao->conexao("medicina");
                                   $username = $_SESSION["username"];
                                   try {
                                       
                                       if ($id_patologia != -1) {

                                       #testar se a patologia e bi-rads e imagens relacionadas a determinado usuario
                                           if ($id_patologia == 1) {
                                                if($categoria == -1 || $categoria == ' ' || $composicao == -1 || $composicao == ' '){
                                                    echo 'Por favor, selecione a composicao e a categoria da imagem, na pagina anterior';
                                                }
                                                else{
                                                    # monta string sql corretamente para imagens
                                                 $sql="SELECT i.id_imagem from imagem i  INNER JOIN login_imagem li
                                                         ON(i.id_imagem = li.id_imagem)
                                                         AND i.id_patologia = $id_patologia
                                                         AND i.categoria = '$cat'
                                                         AND i.composicao = '$comp'
                                                         AND dt_upload BETWEEN '$dt_inicio' AND '$dt_fim'
                                                         AND li.username ='$username'
                                                         AND i.status = $status";
                                                }
                                           } else {
                                              
                                               #montar string sql para imagens de patologias diferentes de Bi_Rads
                                               $sql="SELECT i.id_imagem from imagem i  INNER JOIN login_imagem li
                                                         ON(i.id_imagem = li.id_imagem)
                                                         AND i.id_patologia = $id_patologia
                                                         AND i.categoria = ''
                                                         AND i.composicao = ''
                                                         AND dt_upload BETWEEN '$dt_inicio' AND '$dt_fim'
                                                         AND li.username ='$username'
                                                         AND i.status = $status";

                                           }
                                           $rs = @pg_query($sql);
                                           if (!$rs) {
                                               echo 'Nao foi possivel realizar a busca de imagens.Por favor contate o administrador do sistema.';
                                           } else {
                                               $total = @pg_num_rows($rs);

                                               if ($total == 0)
                                                   echo 'Nao foram encontradas imagems com estes requisitos na base de dados.';
                                               else {
                                                   
                                                   echo '<a href="painel.php?offset=0&&ativacao=' . $status . '&&limit=' . $limit . '&&id_patologia=' . $id_patologia . '&&dt_inicio=' . $dt_inicio . '&&dt_fim=' . $dt_fim . '&&cat='.$cat.'&&comp='.$comp.'" class="imagem">1</a>';

                                                   $j = 2;
                                                   // a partir de n imagens

                                                   $offset = $limit;
                                                   for ($i = $offset; $i <= $total; $i+=$offset) {

                                                       if ($i > $offset && $i % $tamanho_pagina == 0 && $i < $total) {
                                                           $resto = $total - $i;

                                                           echo '<a href="painel.php?offset=' . $i . '&&ativacao=' . $status . '&&limit=' . $limit . '&&id_patologia=' . $id_patologia . '&&dt_inicio=' . $dt_inicio . '&&dt_fim=' . $dt_fim .'&&cat='.$cat.'&&comp='.$comp.'" class="imagem" id="' . $j . '">' . $j . '</a>';
                                                       } else {
                                                           echo '<a href="painel.php?offset=' . $i . '&&ativacao=' . $status . '&&limit=' . $limit . '&&id_patologia=' . $id_patologia . '&&dt_inicio=' . $dt_inicio . '&&dt_fim=' . $dt_fim .'&&cat='.$cat.'&&comp='.$comp.'" class="imagem" id="' . $j . '">' . $j . '</a>';
                                                       }
                                                       $j++;
                                                   }
                                               }
                                           }
                                       } else {
                                           echo 'Por favor,selecione corretamente a patologia para a busca de imagens.';
                                       }
                                   } catch (Exception $e) {

                                       echo ($e->getMessage());
                                   }
                                   $conexao->close();
?>

</center>
</div>
</div>
<div id="footer"></div>
</div>
</body>
</html>