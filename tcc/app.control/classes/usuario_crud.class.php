<?php

/*
 * UsuarioCrud
 * Autor:Altieris Marcelino Peixoto
 * Data 03/08/2010 20:43
 *
 */

class UsuarioCrud {

    /**
     * Metodo de cadastro de novos usuarios
     * @param $nome ->nome de usuario
     * @param $email -> email do usuario
     * @param $senha -> senha do usuario
     * @param $nv_acess -> nivel de acesso do usuario a ser cadastra do para permissao de uso do sistema
     * @param $area_medica -> id da area medica que o usuario (medico) atua
     */
    public function cadastraUsuario($nome, $email, $username, $senha, $nv_acess, $area_medica) {

        include_once 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        if (strlen($nome) == 0) {
            echo "Por favor,preencha o campo Nome";
        } elseif (strlen($nome) > 50) {
            echo "Por favor,preencha o campo Nome com no maximo 50 caracteres.";
        } elseif (strlen($email) == 0) {
            echo "Por favor preencha o campo de email!";
        } elseif (strstr($email, ' ') != FALSE) {
            echo "O email nao pode conter espacos em branco";
        } elseif (strlen($email) > 30) {
            echo "Por favor,preencha o email com no maximo 30 caracteres.";
        } elseif (strstr($username, ' ') != FALSE) {
            echo "O Nome de usuario nao pode conter espacos.";
        } elseif (strlen($username) < 4 || strlen($username) > 15) {
            echo "Por favor,preencha o campo de Nome de Usuario com no minimo 4 e no maximo 15 caracteres.";
        } elseif (strlen($senha) == 0) {
            echo "Por favor preencha o campo de senha";
        } elseif (strstr($senha, ' ') != FALSE) {
            echo "A senha nao pode conter espacos em branco !";
        } else {
            try {

                $this->sql = "select username from login where username ='$username'";
                $this->stmt = @pg_query($this->sql);
                $this->res = pg_num_rows($this->stmt);

                if ($this->res) {
                    echo "Nome de usuario ja existente.Por favor, digite outro nome de usuario!!!";
                }
//o usuario a ser cadastrado e medico
                elseif ($nv_acess == 2) {

                    pg_query("BEGIN");
//insere os dados na tabela de login
                    $this->sql_tab1 = "insert into login values('$username',md5('$senha'),$nv_acess,1)";
                    $this->stmt1 = pg_query($this->sql_tab1);

//insere os dados na tabela de usuario
                    $this->sql_tab2 = "insert into usuario values(default,'$nome','$email','$username',1)";
                    $this->stmt2 = pg_query($this->sql_tab2);

//INSERE OS DADOS NA TABELA DE LOGIN_AREA_MEDICA
                    $this->sql_tab3 = "insert into login_area_medica values('$username',$area_medica)";
                    $this->stmt3 = pg_query($this->sql_tab3);

                    if ($this->stmt1 && $this->stmt2 && $this->stmt3) {
//cadastra o usuario no banco
                        pg_query("COMMIT");
                        echo "Usuario Cadastrado com sucesso!!!";
                    } else {
                        pg_query("ROLLBACK");
                        echo "Ocorreu um erro inesperado.Erro ao tentar cadastrar o usuario!!!";
                        $conexao->close();
                    }
                }
// o usuario nao e um medico
                else {
                    pg_query("begin");
//insere os dados na tabela de login
                    $this->sql_tab1 = "insert into login values('$username',md5('$senha'),$nv_acess,1)";
                    $this->stmt1 = pg_query($this->sql_tab1);

//insere os dados na tabela de usuario
                    $this->sql_tab2 = "insert into usuario values(default,'$nome','$email','$username',1)";
                    $this->stmt2 = pg_query($this->sql_tab2);


                    if ($this->stmt1 && $this->stmt2) {
//cadastra o usuario no banco
                        pg_query("commit");
                        echo "<span class=\"ui-icon ui-icon-circle-check\" style=\"float:left; margin:0 7px 50px 0;\"></span>Usuario Cadastrado com sucesso!!!";
                    } else {
                        pg_query("rollback");
                        echo "<span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 50px 0;\"></span>Ocorreu um erro inesperado.Erro ao tentar cadastrar o usuario!!!";
                        $conexao->close();
                    }
                }
            } catch (Exception $e) {
                echo ($e->getMessage());
            }
        }
        $conexao->close();
    }

    /**
     * Metodo de exclusao de usuarios --> desabilitar o uso do sistema
     * @param $username -> nome de usuario do sistema
     */
    public function desativaUsuario($username) {
        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        try {
            $this->sql = "update login set status = 0 where username = '$username'";
            $this->stmt = pg_query($this->sql);
            if ($this->stmt) {
                echo '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>Usuario desativado com sucesso!!!';
            } else {
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Erro ao desativar o usuario!!!';
            }
        } catch (Exeption $e) {
            echo ($e->getMessage());
        }
        $conexao->close();
    }
/**
     * Metodo de ativacao de usuarios --> habilitar o uso do sistema
     * @param $username -> nome de usuario do sistema
     */
    public function ativaUsuario($username) {
        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        try {
            $this->sql = "update login set status = 1 where username = '$username'";
            $this->stmt = pg_query($this->sql);
            if ($this->stmt) {
                echo '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>Usuario ativado com sucesso!!!';
            } else {
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Erro ao ativar o usuario!!!';
            }
        } catch (Exeption $e) {
            echo ($e->getMessage());
        }
        $conexao->close();
    }


    /**
     * Metodo de alteracao de senha
     * @param $username -> nome de usuario para alteracao de senha
     * @param $senha -> senha do usuario
     * @param $novasenha -> senha para alteracao
     * @param $novasenha2 -> confirmacao da nova senha
     */
    public function alteraSenha($username, $senha, $nova_senha, $nova_senha2) {
        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        if (strlen($username) == 0) {
            echo "Por favor preencha o campo nome de usuario!!!";
        } elseif (strlen($senha) == 0) {
            echo "Por favor preecha o campo de senha!!!";
        } elseif (strlen($nova_senha) == 0) {
            echo "Por favor preecha o campo de nova senha!!!";
        } elseif (strlen($nova_senha2) == 0) {
            echo "Por favor preecha novamente o campo de nova senha!!!";
        } elseif ($nova_senha != $nova_senha2) {
            echo "As novas senhas digitadas nao conferem!!!";
        } else {
            try {

                $this->sql = "SELECT * FROM LOGIN WHERE USERNAME = '$username' AND PASSWORD = md5('$senha')";
                $this->stmt = @pg_query($this->sql);
                $this->rows = @pg_num_rows($this->stmt);

                if ($this->rows == 1) {
                    $this->sql = "UPDATE LOGIN SET PASSWORD = md5('$nova_senha') WHERE USERNAME = '$username' AND PASSWORD = md5('$senha')";
                    $this->stmt = @pg_query($this->sql);
                    if ($this->stmt) {
                        echo 'Senha alterada com sucesso!!!';
                    } else {
                        echo 'Falha ao tentar alterar a senha';
                    }
                } else {
                    echo 'Nome de usuario e senha nao encontrados no banco de dados!!!';
                }
            } catch (Exception $e) {
                echo ($e->getMessage());
            }
        }
        $conexao->close();
    }
}
?>