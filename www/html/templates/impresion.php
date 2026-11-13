<?php
require_once __DIR__ . '/../config.php'; 
require('fpdf.php'); 

class PDF extends FPDF 
{ 
function header() 
{ 
$this->Image('2.jpeg',16,10,33); 
$this->SetFont('arial','B',15); 
$this->Cell(50); 
$this->Cell(80,10,'Monitores Registrados',0,0,'C'); 
$this->Ln(15); 
$this->Cell(80,10,'_____________________________________________________________________________________________________________',0,0,'C');
$this->Ln(15); 
} 
function Footer() 
{ 
$this->SetY(-10); 
$this->SetFont('Arial','I',8); 
$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C'); 
} 
} 
$pdf=new PDF(); 
$pdf->AliasNbPages(); 
$pdf->AddPage(); 


$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME_4'));
$cola="select id, usuario from usuarios where control='1'";
$control=array();
$resultado=$db->query($cola);
$valor=$resultado->fetch_array();
while($resultado = mysql_fetch_array($cola)){ 

$pdf->Cell(45,5,$resultado['id'],1,0,'C'); 
$pdf->Cell(45,5,$resultado['numero'],1,0,'C'); 
$pdf->Cell(45,5,$resultado['detalle'],1,0,'C'); 
$pdf->Cell(45,5,$resultado['obs'],1,0,'C'); 
$pdf->Ln(); 
} 
$pdf->Output(); 
?> 