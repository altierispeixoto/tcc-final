<?php

define('FPDF_FONTPATH', '../../fpdf/font/');
require_once '../../fpdf/fpdf.php';
require_once '../../app.control/classes/conexao.class.php';

class PDF extends FPDF {

//Page header
public function Header() {

        $this->SetFont('Times', 'I', 9);
//Move to the right
        $this->Cell(5);
//Title
        $this->Cell(100, 10, 'Information System of Medical Images', 0, 0, 'L');
//Line break
        $this->Ln(20);
    }

//Page footer
public function Footer() {
//Position at 1.5 cm from bottom
        $this->SetY(-15);
//Arial italic 8
        $this->SetFont('Arial', 'I', 8);
//Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}
$conexao = new ConexaoDB();
$conexao->conexao("medicina");

$sql = "select usuario.id_usuario,usuario.nome,login.nv_acess,usuario.email,login.username
    from usuario usuario inner join login login on (usuario.username = login.username)
    and login.status = 1 and usuario.status = 1 order by usuario.nome asc";

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Open();
$pdf->AddPage('P', 'A4');
$pdf->SetXY(10, 20);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(0, 5, 'Relatorio de Usuarios', 1, 0, 'C');
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell(10, 5, 'ID', 0, 0);
$pdf->Cell(50, 5, 'Nome', 0, 0);
$pdf->Cell(30, 5, 'Tipo', 0, 0);
$pdf->Cell(60, 5, 'Email', 0, 0);
$pdf->Cell(15, 5, 'Username', 0, 0);

$stmt = @pg_query($sql);
$rows = @pg_num_rows($stmt);
$pdf->SetFontSize(10);
$pdf->SetTextColor(0, 0, 0);
$y = 35;
for ($i = 0; $i < $rows; $i++) {
    $registro = pg_fetch_row($stmt);
    $pdf->SetFillColor(153, 153, 153);
    $pdf->SetXY(10, $y);

    $pdf->SetFillColor(153, 153, 153);
    $pdf->Cell(10, 10, $registro[0], 0, 0);
    $pdf->Cell(50, 10, $registro[1], 0, 0);
    if ($registro[2] == 1) {
        $pdf->Cell(30, 10, 'Aluno', 0, 0);
    } else if ($registro[2] == 2) {
        $pdf->Cell(30, 10, 'Medico', 0, 0);
    } else if ($registro[2] == 3) {
        $pdf->Cell(30, 10, 'Administrador', 0, 0);
    }
    $pdf->Cell(60, 10, $registro[3], 0, 0);
    $pdf->Cell(15, 10, $registro[4], 0, 0);
    $y +=5;
}
$pdf->Output();
$conexao->close();
?>