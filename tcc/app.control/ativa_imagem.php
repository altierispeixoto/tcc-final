<?php
include_once 'classes/ima.class.php';
$imagem = new Imagem();
$imagem->ativaImagem($_GET['id_imagem']);
?>
