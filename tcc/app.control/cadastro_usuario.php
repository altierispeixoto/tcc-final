<?php
include 'classes/usuario_crud.class.php';
$usuario = new UsuarioCrud();
$usuario->cadastraUsuario($_POST["nome"],$_POST["email"],$_POST["username"],$_POST["senha"],$_POST["nv_acess"],$_POST["area_medica"]);
?>
 