<?php

/*
 * Classe de Verificacao de Login de Usuario
 * Autor : Altieris Marcelino Peixoto
 * Data : 9/07/2010  09:35
 *
 */

class Login {

    public function checkLogin() {

        if (isset($_POST["username"]) and isset($_POST["password"])) {

            $usuario = $_POST["username"];
            $senha = md5($_POST["password"]);

            include 'conexao.class.php';
            $conexao = new ConexaoDB();
            $conexao->conexao("medicina");

            $query = @pg_query("select username,password from login where username = '$usuario'
                                and password = '$senha' and status  = 1");

            $linhas = pg_num_rows($query);
            if ($linhas == 0) {
                $this->naologou("Senha ou Nome de Usuario Incorretos!!!");
            }// fim if
            else {
                if ($senha != pg_result($query, "password")) {
                    $this->naologou("Senha ou Nome de Usuario Incorretos!!!");
                } else {
                    $sql = "select usuario.nome,login.nv_acess from usuario usuario inner join login login on
                       (usuario.username = login.username) and login.username ='$usuario' and login.status = 1
                           and usuario.status = 1";

                    $stmt = @pg_query($sql);
                    $rows = @pg_num_rows($stmt);
                    for($i=0;$i<$rows;$i++){
                        $data =@pg_fetch_row($stmt,$i);
                    }
                    session_start();
                    $_SESSION["nome"] = $data[0];
                    $_SESSION["nv_acess"]=$data[1];
                    $_SESSION["username"] = $usuario;
                    $_SESSION["password"] = $senha;
                    
                    # se nivel de acesso igual a 2 entao o usuario e medico
                    if($_SESSION["nv_acess"]==2){
                        $sql ="select  am.area
                                     from login l INNER JOIN login_area_medica la ON l.username = la.username
                                     INNER JOIN area_medica am ON am.id_area_medica = la.id_area_medica
                                     AND l.username ='$usuario'";
                        $stmt = @pg_query($sql);
                        $rows = @pg_num_rows($stmt);
                        for($i=0;$i<$rows;$i++){
                            $area = pg_fetch_row($stmt,$i);
                        }
                        $_SESSION["area_medica"] = $area[0];
                    }
                    header('location: ../app.view/inicio.php');
                }
            }
        } //fim isset
        else {
            $this->naologou('Voce nao efetuou o login!!!');
        }
        $conexao->close();
    }

    /*
     * Metodo   que mostra retorna para a tela de login
     *
     */

    public function naologou($mensagem) {

        echo '
			<html>
			<head>
			<title>Error</title>
			<link href="../css/login.css" type="text/css" rel="stylesheet" />
			</head>
			<body>
				<div id="wrap">
				<div id="div_form_Login">
					<ul>
						<p>' . $mensagem . '</p>
						<form name="login" method="post" action="../app.control/entrar.php" onSubmit="return verifica();">
						  <table border="0" cellspacing="2" cellpadding="2">
							<tr>
								<td><p align="\center\">Clique<a href ="../app.view/login.php">aqui</a>para realizar  o login.</p></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
						  </table>
						</form>
					</ul>
				</div>
				</div>
			</body>
			</html>
			';
    }

    public function logout() {
        session_start();
        $_SESSION = array();
        session_destroy();
        header("location: ../app.view/login.php");
    }

//fim funcao logout
}
?>
