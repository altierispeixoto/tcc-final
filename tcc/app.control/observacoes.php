<?php
include_once 'classes/imagem.class.php';
$imagem = new Imagem();
$imagem->geraDiagnostico($_GET['id_imagem']);
?>
