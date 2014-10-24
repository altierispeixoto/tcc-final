<?php

/* ------------------------------------------------------------------+
 * Autor:Altieris Marcelino Peixoto
 * Data: 10/07/2010 06:43
 */
#------------------------------------------------------------------+

/**
 * Classe para manipulacao de Area Medica
 *
 */
class AreaMedica {

    /**
     * metodo de cadastro de area medica
     * @param $area_medica-> nome da area medica para cadastro
     */
    public function cadastraAreaMedica($area_medica) {

        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        try {
            if (strlen($area_medica) == 0) {
                echo 'Por favor preencha o campo area medica !!!';
            } elseif (strlen($area_medica) < 60) {
                //verificar se a area medica ja esta cadastrada
                $this->sql = "SELECT AREA FROM AREA_MEDICA WHERE AREA = '$area_medica'";
                $this->stmt = @pg_query($this->sql);
                $this->res = pg_num_rows($this->stmt);
                if ($this->res == 0) {
                    try {
                        $this->sql = "INSERT INTO AREA_MEDICA VALUES(default,'$area_medica',1)";
                        $this->stmt = @pg_query($this->sql);
                        $this->rows = pg_affected_rows($this->stmt);
                        if ($this->rows == 1) {

                            echo '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>Cadastro realizado com sucesso !!!';
                        } else {

                            echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Nao foi possivel realizar o cadastro de Area Medica!!!';
                        }
                    } catch (Exception $e) {
                        echo ($e->getMessage());
                    }
                } else {
                    echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Esta Area Medica ja se escontra cadastrada!!!';
                }
            } else {
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Por favor, preencha o campo Area Medica com no maximo 60 caracteres!!!';
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        $conexao->close();
    }

    public function excluiAreaMedica($area_medica) {
        
    }
}
?>
