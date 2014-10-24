<?php
include_once 'classes/ima.class.php';
$imagem = new Imagem();
$imagem->geraImagem($_GET["id_imagem"]);
?>
