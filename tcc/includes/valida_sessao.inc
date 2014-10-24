<?php

session_start();
include '../app.control/classes/login.class.php';
include '../app.control/classes/conexao.class.php';

$conexao = new ConexaoDB();
$conexao->conexao("medicina");
$login = new Login();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
}
if (isset($_SESSION['password'])) {
    $password = $_SESSION["password"];
}
if (!(empty($username) or empty($password))) {

    $resultado = pg_query("select * from login where username = '$username'");
    if (pg_num_rows($resultado) == 1) {

        if ($password != pg_result($resultado, "password")) {
            unset($_SESSION["username"]);
            unset($_SESSION["password"]);
            $login->naologou('Voce nao efetuou o login!!!');
            exit;
        }
    } else {
        unset($_SESSION["username"]);
        unset($_SESSION["password"]);
        $login->naologou('Voce nao efetuou o login!!!');
        exit;
    }
} else {
    $login->naologou('Voce nao efetuou o login!!!');
    exit;
}
$conexao->close();
?>