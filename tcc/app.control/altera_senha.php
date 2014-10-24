<?php
include 'classes/usuario_crud.class.php';
$usuario =  new UsuarioCrud();
$usuario ->alteraSenha($_POST['username'],$_POST['senha'],$_POST['nova_senha'],$_POST['nova_senha2']);
?>