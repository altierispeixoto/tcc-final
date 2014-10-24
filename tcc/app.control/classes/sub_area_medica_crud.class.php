<?php

/*
 * Autor : Altieris Marcelino Peixoto
 * Data: 10/07/2010 10:33
 */

class SubAreaMedica {

    /**
     * Metodo de cadastro de sub area medica
     * @param $sub_area_medica -> nome da sub area medica
     * @param $id_area_medica -> chave primaria da tabela de area medica
     */
    public function cadastraSubAreaMedica($sub_area_medica,$id_area_medica) {

        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        try {
            if (strlen($sub_area_medica) == 0) {
                echo 'Por favor,preencha o campo de sub area medica!!!';
            } elseif (strlen($id_area_medica) == 0) {
                echo 'Por favor,selecione uma area medica!!!';
            } elseif (strlen($sub_area_medica) <= 20 && strlen($id_area_medica) > 0) {

                //verificar se a sub area medica ja esta cadastrada
                $this ->sql = "SELECT DESCRICAO FROM SUBAREA WHERE DESCRICAO = '$sub_area_medica' AND ID_AREA_MEDICA = $id_area_medica";
                $this->stmt = pg_query($this->sql);
                $this->res = pg_num_rows($this->stmt);

                if ($this->res == 0) {
                    $this->sql = "INSERT INTO SUBAREA VALUES(default,$id_area_medica,'$sub_area_medica',1)";
                    $this->stat = pg_query($this->sql);

                    if (!$this->stat) {
                        echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Nao foi possivel realizar o cadastro !!! Contate o Administrador! ';
                    } else {
                        echo '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>Cadastro realizado com sucesso !!!';
                    }
                } else {
                    echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Esta Sub area ja se encontra cadastrada nesta Area Medica !!!';
                }
            } else {
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Por favor, preencha o campo Sub Area M�dica com no m�ximo 10 caracteres!!!';
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }
}
?>
