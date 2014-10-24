<?php

/*
 * Autor:Altieris Marcelino Peixoto
 * Data: 20/08/2010  10:28
 */

class Imagem {

    //extensoes autorizadas
    private $extensoes_validas = array(".jpeg", ".jpg");
    //tamanho limite do arquivo em bytes
    private $tamanho_bytes = "3000000";
    private $username;

    /**
     * Metodo de realizacao do upload
     * @param $arquivo_temporario -> $_FILES['imagem']['tmp_name']
     * @param $nome_arquivo       -> $_FILES['imagem']['name']
     * @param $patologia          -> id da patologia relacionada a imagem de upload
     * @param $tamanho_arquivo    -> tamanho da imagem para upload
     * @param $observacao         -> Observacoes sobre a imagem
     * @param $categoria          -> categoria relacionada a patologia Bi-Rads
     * @param $composicao         -> composicao relacionada a patologia Bi-Rads
     * 
     */
    public function realizaUpload($arquivo_temporario, $nome_arquivo, $tamanho_arquivo, $patologia, $observacao, $diagnostico, $categoria, $composicao) {
        $this->username = $_SESSION["username"];
        // include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");
        if (empty($patologia) || $patologia == "-1") {
            $this->geraMensagemErro(3);
        } else {

            try {
                if (!empty($nome_arquivo)) {
                    //verifica se o arquivo e valido para upload
                    $this->arq_valido = $this->checaImagem($nome_arquivo);
                    if (!$this->arq_valido) {
                        $this->geraMensagemErro(1);
                    } else {
                        //verifica se o tamanho de arquivo e valido para upload
                        if ($tamanho_arquivo > $this->tamanho_bytes) {
                            $this->geraMensagemErro(2);
                        } else {

                            try {
                                $this->image = str_replace('\\', '/', $arquivo_temporario);
                                if ($patologia == 1) {

                                    if ($composicao == "-1") {
                                        $this->geraMensagemErro(8);
                                    } else if ($categoria == "-1") {
                                        $this->geraMensagemErro(8);
                                    } else {
                                        #iniciar uma transacao aqui  -- INSERCAO DE IMAGENS BI-RADS
                                        pg_query("BEGIN");
                                        $this->sql1 = "INSERT INTO imagem
                                                VALUES (default,$patologia,'$observacao','$diagnostico','$categoria','$composicao',lo_import('$this->image'),date(now()),1)";
                                        $this->stat1 = pg_query($this->sql1);

                                        $this->selectid = "SELECT MAX(id_imagem)
                                                           from imagem
                                                           where id_patologia = $patologia
                                                           and diagnostico = '$diagnostico'
                                                           and composicao ='$composicao'
                                                           and categoria = '$categoria'
                                                           and observacao = '$observacao'
                                                           and status =1";

                                        $this->resultMax = pg_query($this->selectid);
                                        $resultid = pg_fetch_row($this->resultMax, 0);

                                        $this->sql2 = "INSERT INTO login_imagem values('$this->username',$resultid[0])";
                                        $this->stat2 = pg_query($this->sql2);
                                        if (!$this->stat1 || !$this->stat2) {
                                            pg_query("ROLLBACK");
                                            $this->geraMensagemErro(4);
                                        } else {
                                            pg_query("COMMIT");
                                            echo '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>Upload realizado com sucesso';
                                            echo '<br/><br/>';
                                            $this->retornaPatologia($patologia, $categoria, $composicao, 1);
                                            echo '<br/><br/>';
                                            #chamar uma pagina com a imagem carregada
                                            echo "<img src='../app.control/visualizadorcontrol.php?id_imagem=$resultid[0]' style='height:30%;width:30%;'></img>";
                                            #chamar um visualizador para os dados de imagem : diagnostico
                                            echo '<div style="display:inline-block;float:right;margin-right:100px;">';
                                            echo"<input type='hidden' style='display:none;' id='idimagem' value='$resultid[0]'></input>";

                                            #-----------------combo de patologias-----------------------
                                            $this->comboPatologiaUsuario();
                                            $this->comboCategoria();
                                            $this->comboComposicao();

                                            #-----------------------------------------------------------

                                            echo'<br/><br/>';
                                            echo '<label>Diagnostico:<br/><br/>
                                                     <textarea disabled cols="80" rows="8" id="diag" name="diag">' . $diagnostico;
                                            echo '</textarea></label>';
                                            echo'<br/><br/>';
                                            echo '<label>Observacoes:<br/><br/>
                                                     <textarea disabled cols="80" rows="8" id="obser" name="obser">' . $observacao;
                                            echo '</textarea></label>';
                                            echo '</div>';
                                        }
                                    }
                                } else {
                                    #iniciar uma transacao aqui -- INSERCAO DE IMAGENS DE OUTRAS PATOLOGIAS
                                    pg_query("BEGIN");
                                    $this->sql1 = "INSERT INTO imagem  VALUES (default,$patologia,'$observacao','$diagnostico','','',lo_import('$this->image'),date(now()),1)";
                                    $this->stat1 = @pg_query($this->sql1);

                                    $this->selectid = "SELECT MAX(id_imagem)
                                                           from imagem
                                                           where id_patologia = $patologia
                                                           and diagnostico = '$diagnostico'
                                                           and composicao =''
                                                           and categoria = ''
                                                           and observacao = '$observacao'
                                                           and status =1";

                                    $this->resultMax = pg_query($this->selectid);
                                    $resultid = pg_fetch_row($this->resultMax, 0);

                                    $this->sql2 = "INSERT INTO login_imagem VALUES ('$this->username',$resultid[0])";
                                    $this->stat2 = pg_query($this->sql2);

                                    if (!$this->stat1 || !$this->stat2) {
                                        pg_query("ROLLBACK");
                                        $this->geraMensagemErro(4);
                                    } else {
                                        pg_query("COMMIT");
                                        echo '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>Upload realizado com sucesso';

                                        echo '<br/><br/>';
                                        $this->retornaPatologia($patologia, $categoria, $composicao, 1);
                                        echo '<br/><br/>';
                                        #chamar uma pagina com a imagem carregada
                                        echo "<img src='../app.control/visualizadorcontrol.php?id_imagem=$resultid[0]' style='height:40%;width:40%;'></img>";
                                        #chamar um visualizador para os dados de imagem : diagnostico
                                        echo '<div style="display:inline-block;float:right;">';

                                        echo"<input type='hidden' style='display:none;' id='idimagem' value='$resultid[0]'></input>";

                                        $this->comboPatologiaUsuario();
                                        $this->comboCategoria();
                                        $this->comboComposicao();

                                        echo '<label>Diagnostico:<br/><br/>
                                                     <textarea disabled cols="80" rows="8" id="diag">' . $diagnostico;
                                        echo '</textarea></label>';
                                        echo'<br/><br/>';
                                        echo '<label>Observacoes:<br/><br/>
                                                     <textarea disabled cols="80" rows="8" id="obser">' . $observacao;
                                        echo '</textarea></label>';
                                        echo '</div>';
                                    }
                                }
                            } catch (Exception $e) {
                                echo ($e->getMessage());
                            }
                        }
                    }
                } else {
                    $this->geraMensagemErro(9);
                }
            } catch (Exception $e) {
                echo ($e->getMessage());
            }
        }
        $conexao->close();
    }

    public function comboPatologiaUsuario() {

        echo '<label>Alterar a patologia relacionada:
                <select name="patologia" id="patologia" class="textfield" disabled>
                    <option value="-1">Selecione</option>';

        $this->sql = "select ip.id_patologia,ip.descricao
                           from idx_patologia ip ,area_medica am,login_area_medica la
                           where
                           ip.id_area_medica = am.id_area_medica
                           and la.id_area_medica = am.id_area_medica
                           and la.username = 'anderson' and
                           am.status = 1 and ip.status = 1
                          ";

        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");
        $this->stmt = pg_query($this->sql);
        $this->rows = pg_numrows($this->stmt);
        for ($this->i = 0; $this->i < $this->rows; $this->i++) {
            $this->data = pg_fetch_row($this->stmt, $this->i);

            echo "<option  value='";
            echo $this->data[0];
            echo "'>";
            echo $this->data[1];
                    echo "</option>";
        }
       
        echo' </select> </label>';
    }

    public function comboCategoria() {
        #combo de categoria --> Imagens Bi-rads
        echo "<label id=\"categoria\" style=\"display:none;width: auto\"> Categoria :
              <select name=\"categoria\" class=\"textfield\" id=\"cat\" disabled >
                <option value=\"-1\">Selecione</option>
                <option value=\"0\">0</option>
                <option value=\"1\">I</option>
                <option value=\"2\">II</option>
                <option value=\"3\">III</option>
                <option value=\"4\">IV</option>
                <option value=\"4A\">IV-A</option>
                <option value=\"4B\">IV-B</option>
                <option value=\"4C\">IV-C</option>
                <option value=\"5\">V</option>
                </select>
                </label>
                <br/><br/>

                                ";
    }

    public function comboComposicao() {
        #combo de composicao--> imagens Bi-Rads
        echo "<label id=\"composicao\" style=\"display:none;width: auto\">Composi&ccedil;&atilde;o :
                                    <select name=\"composicao\" class=\"textfield\" id=\"comp\"disabled>
                                        <option value=\"-1\">Selecione</option>
                                        <option value=\"1\">I</option>
                                        <option value=\"2\">II</option>
                                        <option value=\"3\">III</option>
                                        <option value=\"4\">IV</option>
                                    </select>
                                </label>
                                <br/><br/>
                                ";
    }

    /**
     * Verifica se o arquivo indicado e uma imagem valida para upload
     * @param $nome_arquivo -> nome do arquivo para upload
     * @return Boolean 
     */
    private function checaImagem($nome_arquivo) {
        $this->ext = strrchr($nome_arquivo, '.');
        if (!in_array($this->ext, $this->extensoes_validas)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Metodo de retorno de mensagem de erro
     * @param $cod_erro -> codigo do erro a ser retornado
     */
    private function geraMensagemErro($cod_erro) {

        switch ($cod_erro) {
            case 1:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Extensao invalida para upload!!! Sao arquivos validos somente com extensao JPEG ou JPG.';
                break;
            case 2:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Tamanho de arquivo invalido para upload!!!';
                break;
            case 3:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Selecione a patologia a ser relacionada com  a imagem de upload!!!';
                break;
            case 4:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Erro ao conectar com o banco de dados!!!Contate o administrador do sistema para resolucao do problema!!!';
                break;
            case 5:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Erro ao gerar miniatura da imagem de upload!!!';
                break;
            case 6:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Erro ao abrir imagem!!!';
                break;
            case 7:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Nenhuma imagem encontrada!';
                break;
            case 8:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>A patologia Bi-Rads deve ser composta de uma categoria e uma composicao.Por favor selecione a categoria e a composicao corretamente!';
                break;
            case 9:
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Campo de imagem para upload vazio. Por favor, selecione a imagem na pagina de upload.';
                break;
            default :
                echo '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>Erro ao realizar o upload!!!';
                break;
        }
    }

    /**
     * Metodo que mostra o numero de imagens retornadas relacionadas a uma patologia
     * @param $id_patologia -> id da patologia que é relacionada com  a imagem
     * @param $categoria -> categoria das imagens  relacionadas a Bi-Rads
     * @param $composicao -> composicao das imagens relacionadas a Bi-Rads
     * @param $status -> status relacionado as imagens  [1] -> ativo [0]-> inativo
     * 
     */
    public function retornaNumImagens($id_patologia, $categoria, $composicao, $status) {
        include_once 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");
        if ($id_patologia != "-1") {

            if ($id_patologia == "1") {
                if ($composicao == "-1") {
                    echo '';
                } else if ($categoria == "-1") {
                    echo '';
                } else {
                    $this->sql = "select id_imagem from imagem where id_patologia =$id_patologia and categoria = '$categoria' and
                          composicao = '$composicao' and status = $status";
                }
            } else {
                $this->sql = "select id_imagem from imagem where id_patologia =$id_patologia and status = $status";
            }
            try {

                $this->rs = @pg_query($this->sql);
                if (!$this->rs) {
                    $this->geraMensagemErro(7);
                } else {
                    $this->total = @pg_num_rows($this->rs);

                    if ($this->total == 0)
                        $this->geraMensagemErro(7);
                    else {
                        echo "Quantidade de imagens encontradas: $this->total";
                    }
                }
            } catch (Exception $e) {
                echo ($e->getMessage());
            }
        } else {
            echo 'Selecione uma patologia para a busca de imagens';
        }
        $conexao->close();
    }

    /**
     * Metodo de construcao do painel de imagens
     * @param $pagina         -> numero da pagina a ser mostrada
     * @param $id_patologia   -> id da patologia relacionada com as imagens a serem buscadas
     * @param $tamanho_pagina -> numero de imagens a serem mostradas por pagina
     * @param $composicao     -> composicao relacionada a patologia BiRads
     * @param $categoria      -> categoria relacionada a patologia BiRads
     *
     */
    public function painelImagensBiRads($pagina, $id_patologia, $tamanho_pagina, $composicao, $categoria) {
        include_once 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        if ($id_patologia != "-1") {
            if ($composicao == "-1") {
                $this->geraMensagemErro(8);
            } else if ($categoria == "-1") {
                $this->geraMensagemErro(8);
            } else {
                try {
                    $this->inicio = ($pagina - 1) * $tamanho_pagina;
                    $this->sql = "select id_imagem from imagem where id_patologia = $id_patologia and categoria = '$categoria' and
                            composicao = '$composicao' and status = 1";
                    $this->rs = pg_query($this->sql);
                    $this->total = pg_num_rows($this->rs);
                    $this->sql = "select id_imagem from imagem where id_patologia = $id_patologia and categoria = '$categoria' and
                            composicao = '$composicao' and status =1 limit $tamanho_pagina offset $this->inicio";
                    $this->stmt = pg_query($this->sql);
                    $this->rows = pg_num_rows($this->stmt);
                    if ($this->rows == 0) {
                        $this->geraMensagemErro(7);
                    } else {
                        $this->i = 0;
                        while ($this->i < $this->rows) {
                            $this->data = @pg_fetch_row($this->stmt, $this->i);
                            echo '<li class="ui-widget-container ui-corner-tr" id="' . $this->data[0] . '">';
                            echo '<img src="../app.control/visualizador_tumb.php?id_imagem=' . $this->data[0] . '"/>';
                            echo '<a href="../app.control/visualizadorcontrol.php?id_imagem=' . $this->data[0] . '" title="Visualizar imagem" class="ui-icon ui-icon-zoomin">View larger</a>';
                            echo '<h5><a href="#" rel="../app.control/observacoes.php?id_imagem=' . $this->data[0] . '" title="Diagnostico e Observacoes" class="ui-icon ui-icon-comment">Diagnostico e Observacoes</a></h5>';
                            echo '</li>';
                            $this->i++;
                        }
                    }
                } catch (Exception $e) {
                    echo ($e->getMessage());
                }
            }
        } else {
            echo 'Selecione uma patologia valida para visualizacao';
        }
        $conexao->close();
    }

    /**
     * Metodo de construcao do painel de imagens
     * @param $pagina -> numero da pagina a ser mostrada
     * @param $id_patologia -> id da patologia relacionada com as imagens a serem buscadas
     * @param $tamanho_pagina -> numero de imagens a serem mostradas por pagina
     *
     */
    public function painelImagens($pagina, $id_patologia, $tamanho_pagina) {
        include_once 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");
        if ($id_patologia != "-1") {
            try {
                $this->inicio = ($pagina - 1) * $tamanho_pagina;
                $this->sql = "select id_imagem from imagem where id_patologia = $id_patologia and status = 1";
                $this->rs = pg_query($this->sql);
                $this->total = pg_num_rows($this->rs);
                $this->sql = "select id_imagem from imagem where id_patologia = $id_patologia and status =1 limit $tamanho_pagina offset $this->inicio";
                $this->stmt = pg_query($this->sql);
                $this->rows = pg_num_rows($this->stmt);
                if ($this->rows == 0) {
                    $this->geraMensagemErro(7);
                } else {
                    $this->i = 0;
                    while ($this->i < $this->rows) {
                        $this->data = pg_fetch_row($this->stmt, $this->i);
                        echo '<li class="ui-widget-container ui-corner-tr" id="' . $this->data[0] . '">';
                        echo '<img src="../app.control/visualizador_tumb.php?id_imagem=' . $this->data[0] . '"/>';
                        echo '<a href="../app.control/visualizadorcontrol.php?id_imagem=' . $this->data[0] . '" title="Visualizar imagem" class="ui-icon ui-icon-zoomin">View larger</a>';
                        echo '<h5><a href="#" rel="../app.control/observacoes.php?id_imagem=' . $this->data[0] . '" title="Diagnostico e Observacoes" class="ui-icon ui-icon-comment">Diagnostico e Observacoes</a></h5>';
                        echo '</li>';
                        $this->i++;
                    }
                }
            } catch (Exception $e) {
                echo ($e->getMessage());
            }
        } else {
            echo 'Selecione uma patologia valida para visualizacao';
        }
        $conexao->close();
    }

    /**
     * Metodo de paginacao de resultados
     * @param $pagina -> numero da pagina a ser mostrada
     * @param $id_patologia -> id da patologia relacionada com as imagens a serem buscadas
     * @param $tamanho_pagina -> numero de imagens a serem mostradas por pagina
     *
     */
    public function paginador($pagina, $id_patologia, $tamanho_pagina) {
        include_once 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");


        // TODO: verificar os parametros  Gerar erros de link
        try {
            $this->sql = "select id_imagem from imagem where id_patologia =$id_patologia and status = 1";
            $this->rs = @pg_query($this->sql);
            if (!$this->rs) {
                $this->geraMensagemErro(7);
            } else {
                $this->total = @pg_num_rows($this->rs);

                if ($this->total == 0)
                    $this->geraMensagemErro(7);
                else {

                    // Calculando pagina anterior
                    $this->menos = $pagina - 1;

                    // Calculando pagina posterior
                    $this->mais = $pagina + 1;

                    $this->pgs = ceil($this->total / $tamanho_pagina);
                    if ($this->pgs > 1) {
                        if ($this->menos > 0)
                            echo "<a href=\"?pagina=$this->menos&&patologia=$id_patologia&&num_imagens=$tamanho_pagina\" class=\"paginador\" >Anterior</a>";

                        if (($pagina - 4) < 1)
                            $this->anterior = 1;
                        else
                            $this->anterior = $pagina - 4;
                        if (($pagina + 4) > $this->pgs)
                            $this->posterior = $this->pgs;
                        else
                            $this->posterior = $pagina + 4;

                        for ($this->i = $this->anterior; $this->i <= $this->posterior; $this->i++)
                            if ($this->i != $pagina)
                                echo "<a href=\"?pagina=$this->i&&patologia=$id_patologia&&num_imagens=$tamanho_pagina\"  class=\"paginador\">$this->i</a>";
                            else
                                echo ' <strong class="paginadord">' . $this->i . '</strong>';
                        if ($this->mais <= $this->pgs)
                            echo "<a href=\"?pagina=$this->mais&&patologia=$id_patologia&&num_imagens=$tamanho_pagina\"  class=\"paginador\">Proxima</a>";
                    }
                }
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        $conexao->close();
    }

    /**
     * Metodo de paginacao de resultados de imagens Bi-Rads
     * @param $pagina -> numero da pagina a ser mostrada
     * @param $id_patologia -> id da patologia relacionada com as imagens a serem buscadas
     * @param $tamanho_pagina -> numero de imagens a serem mostradas por pagina
     *
     */
    public function paginadorBiRads($pagina, $id_patologia, $tamanho_pagina, $categoria, $composicao) {
        include_once 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");


        // TODO: verificar os parametros  Gerar erros de link
        try {
            $this->sql = "select id_imagem from imagem where id_patologia =$id_patologia and categoria = '$categoria'
                    and composicao = '$composicao' and status = 1";
            $this->rs = @pg_query($this->sql);
            if (!$this->rs) {
                $this->geraMensagemErro(7);
            } else {
                $this->total = @pg_num_rows($this->rs);

                if ($this->total == 0)
                    $this->geraMensagemErro(7);
                else {

                    // Calculando pagina anterior
                    $this->menos = $pagina - 1;

                    // Calculando pagina posterior
                    $this->mais = $pagina + 1;

                    $this->pgs = ceil($this->total / $tamanho_pagina);
                    if ($this->pgs > 1) {
                        if ($this->menos > 0)
                            echo '<a href="?pagina='.$this->menos.'&&patologia='.$id_patologia.'&&num_imagens='.$tamanho_pagina.'&&categoria='.$categoria.'&&composicao='.$composicao.'" class="paginador" >Anterior</a>';

                        if (($pagina - 4) < 1)
                            $this->anterior = 1;
                        else
                            $this->anterior = $pagina - 4;
                        if (($pagina + 4) > $this->pgs)
                            $this->posterior = $this->pgs;
                        else
                            $this->posterior = $pagina + 4;

                        for ($this->i = $this->anterior; $this->i <= $this->posterior; $this->i++)
                            if ($this->i != $pagina)
                                echo '<a href="?pagina='.$this->i.'&&patologia='.$id_patologia.'&&num_imagens='.$tamanho_pagina.'&&categoria='.$categoria.'&&composicao='.$composicao.'"  class="paginador">'.$this->i.'</a>';
                            else
                                echo ' <strong class="paginadord">' . $this->i . '</strong>';
                        if ($this->mais <= $this->pgs)
                            echo "<a href=\"?pagina=$this->mais&&patologia=$id_patologia&&num_imagens=$tamanho_pagina&&categoria=$categoria&&composicao=$composicao\"  class=\"paginador\">Proxima</a>";
                    }
                }
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        $conexao->close();
    }

    /**
     * Metodo de construcao de diagostico relacionado a imagem
     * @param $id_imagem -> id da imagem relacionada com o diagnostico
     *
     */
    public function geraDiagnostico($id_imagem) {

        include 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        try {
            $this->sql = 'SELECT DIAGNOSTICO,OBSERVACAO FROM IMAGEM WHERE ID_IMAGEM = ' . $id_imagem;
            $this->stmt = @pg_query($this->sql);
            $this->rows = @pg_num_rows($this->stmt);
            if ($this->rows == 0) {
                echo ' ';
            } else {
                $this->i = 0;
                while ($this->i < $this->rows) {
                    $this->data = pg_fetch_row($this->stmt, $this->i);
                    echo '<ul>';
                    echo '<li><strong>Diagnostico:</strong>' . $this->data[0] . '</li>';
                    echo '</ul><ul>';
                    echo '<li><strong>Observacoes:</strong> ' . $this->data[1] . '</li>';
                    echo '</ul>';
                    $this->i++;
                }
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }

    /**
     * Metodo que retorna o nome da patologia selecionada
     * @param  $id_patologia -> id da patologia relacionada as imagens para busca
     * @param  $categoria -> categoria de imagens relacionadas a Bi-Rads
     * @param  $composicao -> composicao de imagens relacionadas a Bi-Rads
     *
     */
    public function retornaPatologia($id_patologia, $categoria, $composicao, $status) {
        include_once 'conexao.class.php';
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

        if ($id_patologia != "-1") {
            if ($id_patologia == "1") {
                if ($composicao == "-1") {
                    $this->geraMensagemErro(8);
                } else if ($categoria == "-1") {
                    $this->geraMensagemErro(8);
                } else {
                    echo "Patologia Selecionada :: Bi-Rads || Categoria :: " . $categoria . " || Composicao :: $composicao";
                }
            } else {
                try {
                    $this->sql = "select descricao from idx_patologia  where id_patologia = $id_patologia and status = $status";
                    $this->rs = @pg_query($this->sql);
                    if (!$this->rs) {
                        $this->geraMensagemErro(7);
                    } else {
                        $this->rows = @pg_num_rows($this->rs);

                        if ($this->rows == 0)
                            $this->geraMensagemErro(7);
                        else {

                            $this->i = 0;
                            while ($this->i < $this->rows) {
                                $this->data = pg_fetch_row($this->rs, $this->i);
                                echo "Patologia Selecionada :: " . $this->data[0];
                                $this->i++;
                            }
                        }
                    }
                } catch (Exception $e) {
                    echo ($e->getMessage());
                }
            }
        } else {
            echo 'Selecione uma patologia para a busca de imagens';
        }
        $conexao->close();
    }

}
?>

