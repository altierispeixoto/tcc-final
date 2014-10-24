<?php
include_once 'classes/ima.class.php';
$imagem = new Imagem();
$imagem ->geraMiniatura($_GET['id_imagem'],7);
?>
