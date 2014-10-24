<?php
include_once 'classes/ima.class.php';
$imagem = new Imagem();
$imagem->excluiImagem($_GET['id_imagem']);
?>
