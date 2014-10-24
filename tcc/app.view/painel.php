<html>
    <head>
        <?php
        include '../includes/valida_sessao.inc';
        
       $categoria = $_GET["cat"];
       $composicao =$_GET["comp"];

        $status = $_GET["ativacao"];
        $limit = $_GET["limit"];
        $id_patologia = $_GET["id_patologia"];
        $offset = $_GET["offset"];
        $dt_inicio = $_GET["dt_inicio"];
        $dt_fim = $_GET["dt_fim"];
      
        ?>
        <script type="text/javascript">
            $('document').ready(inicializa);
        </script>
    </head>
<?php
      
        $conexao = new ConexaoDB();
        $conexao->conexao("medicina");

         $username = $_SESSION['username'];

        $sql = "SELECT i.id_imagem,i.dt_upload
                from imagem i,login_imagem li
                where
                i.id_imagem = li.id_imagem and
                i.id_patologia = $id_patologia and
                i.categoria = '$categoria' and
                i.composicao = '$composicao' and
                li.username = '$username' and
                i.status = $status and
                i.dt_upload BETWEEN '$dt_inicio' AND '$dt_fim'
                ORDER BY i.id_imagem ASC LIMIT $limit OFFSET $offset
               ";
        
        $stmt = pg_query($sql);
        $rows = pg_num_rows($stmt);

        $i = 0;
        while ($i < $rows) {
            $data = pg_fetch_row($stmt, $i);
            echo '<li class="ui-widget-container ui-corner-tr" id="' . $data[0] . '">';
            echo '<h5 class="ui-widget-header">'.$data[1].'</h5>';
            echo '<img src="../app.control/visualizador_tumb.php?id_imagem=' . $data[0] . '"/>';
            echo '<a href="../app.control/visualizadorcontrol.php?id_imagem=' . $data[0] . '" title="Visualizar imagem" class="ui-icon ui-icon-zoomin">View larger</a>';
            if ($status == 1) {
                echo '<a href="../app.control/deleta_imagem.php?id_imagem=' . $data[0] . '" title="Desativar esta imagem" class="ui-icon ui-icon-trash"></a>';
            } else {
                echo '<a href="../app.control/ativa_imagem.php?id_imagem=' . $data[0] . '" title="Ativar esta imagem" class="ui-icon ui-icon-refresh"></a>';
            }
            echo '</li>';
            $i++;
        }
        $conexao->close();
?>
    </body>
</html>