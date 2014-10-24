<?php

/**
 * Autor : Altieris Marcelino Peixoto
 * Data:10/07/2010 21:21
 */
class PatologiaCrud {

    /**
     * Metodo de cadastro de patologia
     * @param $id_area_medica -> chave primaria da tabela de area medica
     * @param $descricao -> nome da patologia
     */

    public function cadastraPatologia($id_area_medica, $descricao,$id_subarea) {

        include_once 'conexao.class.php';
        $conexao= new ConexaoDB();
        $conexao->conexao("medicina");

        if (strlen($descricao) == 0) {
            echo 'Por favor,preencha o campo de Patologia!!!';
        } elseif (strlen($id_area_medica) == 0) {
            echo 'Por favor,selecione uma area medica!!!';
        } elseif (strlen($descricao) < 60 && strlen($id_area_medica) > 0) {

            try{
            $this->sql = "SELECT DESCRICAO FROM IDX_PATOLOGIA WHERE DESCRICAO = '$descricao' AND ID_SUBAREA = $id_subarea AND ID_AREA_MEDICA = $id_area_medica";
            $this->stmt = @pg_query($this->sql);
            $this->res = @pg_num_rows($this->stmt);

            if ($this->res == 0) {
                $this->sql = "INSERT INTO IDX_PATOLOGIA VALUES(default,$id_subarea,$id_area_medica,'$descricao',1)";
                $this->stat = @pg_query($this->sql);

                if (!$this->stat) {
                    echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Nao foi possivel realizar o cadastro !!! Contate o Administrador! ';
                } else {
                    echo '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>Cadastro realizado com sucesso !!!';
                }
            } else {
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Esta Patologia ja se encontra cadastrada nesta Area Medica !!!';
            }
            }catch(Exception $e){
                echo ($e->getMessage());
            }
        } else {
            echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Por favor, preencha o campo Patologia com no maximo 60 caracteres!!!';
        }
        $conexao->close();
        }
        
}
?>
