<?php

class Imagem {

    /**
     * Metodo para geracao da imagem a partir de um id com relacao ao banco de dados
     * @param $id_imagem -> id da imagem para visualizacao
     *
     */
    public function geraImagem($id_imagem) {

        try {
            include'classes/conexao.class.php';
            $conexao = new ConexaoDB();
            $conexao->conexao("medicina");

            $sql = "SELECT imagem FROM imagem WHERE id_imagem = $id_imagem";
            $result = pg_exec($sql);
            $data = pg_fetch_row($result, 0);
            if (!$data) {
                echo "Erro ao abrir imagem!!!";
            } else {
                // Header ("Content-type: image/jpg");
                @pg_exec("BEGIN");
                $ofp = pg_loopen($data[0], "r");
                if (!$ofp) {
                    echo "Erro ao abrir imagem!!!";
                }
                $im = pg_lo_read($ofp, 59999999);

                pg_loclose($ofp);
                pg_exec("END");
                $img = imagecreatefromstring($im);
                Header("Content-type: image/jpg");
                imagejpeg($img);
                imagedestroy($img);
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        $conexao->close();
    }

    /**
     * Metodo de geracao da miniatura da imagem
     *
     */
    public function geraMiniatura($id_imagem, $fator) {
        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        try {

            $sql = "SELECT imagem FROM imagem WHERE id_imagem = $id_imagem";
            $result = @pg_query($sql);
            $data = @pg_fetch_row($result, 0);
            if (!$data) {
                echo 'Erro ao conectar com o banco de dados!!!Tente novamente mais tarde!!!';
            } else {
                @pg_query("BEGIN");
                $ofp = @pg_loopen($data[0], "r");
                if (!$ofp) {
                    echo 'Erro ao abrir a imagem!!!';
                } else {
                    $im = @pg_lo_read($ofp, 59999999);
                    @pg_loclose($ofp);
                    @pg_query("END");
                    $img = imagecreatefromstring($im);
                    $origem_x = imagesx($img);
                    $origem_y = imagesy($img);
                    $x = $origem_x / $fator;
                    $y = $origem_y / $fator;
                    $img_final = imagecreatetruecolor($x, $y);
                    imagecopyresampled($img_final, $img, 0, 0, 0, 0, $x + 1, $y + 1, $origem_x, $origem_y);
                    Header("Content-type: image/jpg");
                    @imagejpeg($img_final);
                    @imagedestroy($img_final);
                    @imagedestroy($img);
                }
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        $conexao->close();
    }

    /*
     * Metodo de desativacao de visualizacao da imagem no banco de dados
     * @param $id_imagem 
     */

    public function excluiImagem($id_imagem) {

        include'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");


        $sql = "update imagem set status = 0 where id_imagem = $id_imagem";
        $stmt = pg_query($sql);
        if ($stmt) {
            echo 'imagem excluida';
        } else {
            echo 'nao pode excluir a imagem';
        }
        $conexao->close();
    }

    /**
     * Metodo de ativacao da imagem para  visualizacao
     * @param $id_imagem
     * 
     */
    public function ativaImagem($id_imagem) {
        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        $sql = "update imagem set status = 1 where id_imagem = $id_imagem";
        $stmt = pg_query($sql);
        if ($stmt) {
            echo 'imagem ativada';
        } else {
            echo 'nao pode ativar a imagem';
        }
        $conexao->close();
    }

    /**
     * Metodo de atualizacao de dados da imagem apos upload
     * @param $id_imagem    -> id da imagem selecionada
     * @param $id_patologia -> id da patologia relacionada com a imagem
     * @param $composicao   -> composicao da imagem relacionada a Bi_rads
     * @param $categoria    -> categoria da imagem relacionada a Bi_rads
     * @param $diagnostico  -> diagnostico relacionado a imagem
     * @param $observacao   ->observacao relacionada a imagem
     *
     */
    public function atualizaDados($id_imagem, $id_patologia, $categoria, $composicao, $diagnostico, $observacao) {
        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        try {

           if($id_patologia != -1){
            //se o id da patologia for 1{BI_RADS} e  a composicao ou a categoria da imagem nao estiver selecionada
            if ($id_patologia == 1) {
                if ($categoria > -1 && $composicao > -1 && $categoria != '' && $composicao != '') {
                    $sql = "UPDATE imagem SET id_patologia =$id_patologia,categoria='$categoria',composicao='$composicao',diagnostico='$diagnostico',
            observacao='$observacao' WHERE id_imagem = $id_imagem";
                } else {
                    echo ' Por favor,escolha a categoria e a composicao para a imagem selecionada.';
                }
            } else if ($id_patologia > 1) {
                $sql = "UPDATE imagem SET id_patologia =$id_patologia,categoria='',composicao='',diagnostico='$diagnostico',
            observacao='$observacao' WHERE id_imagem = $id_imagem";
            } else {
                echo 'Erro ao alterar os dados da imagem.Contate o administrador do sistema para resolver o problema.';
            }
            $stmt = @pg_query($sql);
            if ($stmt) {
                echo 'Dados atualizados com sucesso!!!';
            } else {
                echo '<h5>Erro ao atualizar os dados.Por favor contate o administrador do sistema para resolucao do problema.</h5>';
            }
           }
           else{
               echo ' Por favor selecione a patologia relacionada com a imagem.';
           }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        $conexao->close();
    }

}

?>
