<?php
include_once '../app.control/classes/usuario_crud.class.php';
$usuario = new UsuarioCrud();
$usuario->desativaUsuario($_POST["username"]);
?>
