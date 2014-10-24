<?php

include '../../phplot-5.1.3/phplot.php';
include '../../app.control/classes/conexao.class.php';
$conexao = new ConexaoDB();
$conexao->conexao();

$sql = 'select * from graficoAreaMedica()';

$result = pg_query($sql);
$numrows = pg_num_rows($result);

$dados = array();
for ($i = 0; $i < $numrows; $i++) {
    $dados[] = @pg_fetch_array($result, $i);
}

$legenda = pg_fetch_all_columns($result, 1);

$grafico = new PHPlot(550, 350);
//Set titles
$grafico->SetRGBArray('large');
$grafico->SetTitle("Usabilidade do sistema por area medica\n\r");

$grafico->SetDataType("text-data-single");
$grafico->SetPlotType("pie");

$grafico->SetLegend($legenda);


$grafico->SetBackgroundColor('gray80');


$grafico->SetDataValues($dados);

$grafico->DrawBackground();
//Draw it
$grafico->DrawGraph();
?>
