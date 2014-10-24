<?php
include 'classes/ima.class.php';
$imagem = new Imagem();
$imagem->atualizaDados($_POST['id_imagem'],$_POST['id_patologia'],$_POST['categoria'],
        $_POST['composicao'],$_POST['diagnostico'],$_POST['observacao']);
?>
