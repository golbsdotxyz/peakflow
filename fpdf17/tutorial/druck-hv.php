<?php
require('../../../config.php');
require('../fpdf.php');

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		//Logo
		$this->Image('pdf-header.gif',15,5,170);
		//Arial bold 15
		$this->SetFont('Arial','B',44);
		//Move to the right
		$this->Cell(1);
		$this->Ln(20);
	}


	//Page footer
	function Footer()
	{
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Logo
		$this->Image('pdf-footer.gif',15,180,180);
	}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',11);



//for($i=1;$i<=80;$i++)
	//$pdf->Cell(0,5,'Printing line number '.$i,0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,'Kunde');
	$pdf->Cell(20,5,'Standort',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,'naME');
	$pdf->Cell(20,5,'name',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,'Strasse');
	$pdf->Cell(20,5,'str',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,'plz');
	$pdf->Cell(20,5,'pls',0,1);
	$pdf->Cell(6,5,'');
	
	$pdf->Cell(100,5,'Tel: 1234');
	$pdf->Cell(20,5,'Tel: 54321',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(6,5,'__________________________________________________________________________________________',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(20,5,'Anlage: ',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(20,5,'Letzte Wartung: ',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(20,5,'Betreut durch Monteur: Hr. ',0,1);
		$pdf->Cell(6,5,'');
		$pdf->Cell(20,5,'Bemerkung: ',0,1);
	
	$pdf->Cell(0,20,'',0,1);
	$pdf->Image('pdf-text.gif',15,100,180);
	$pdf->Cell(0,174,'',0,1);
	//$pdf->Cell(0,180,'',0,1);

	


	$pdf->Output();

?>
