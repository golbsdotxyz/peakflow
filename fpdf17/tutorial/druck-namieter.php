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
		//$this->Image('pdf-footer.gif',15,180,180);
	}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',11);

/* Briefadressierung
$result2 = @mysql_query("SELECT * FROM HV WHERE ID = ".$_GET['HVID']." ") or print('DB Fehler1 '.mysql_error());
while($row = @mysql_fetch_object($result2)) {
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,15,'',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,$row->HV,0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,$row->Strasse,0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,$row->PLZ.''.$row->Ort,0,1);
 	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,'',0,1);
}*/

		$pdf->Cell(12,5,'');
		$pdf->Cell(100,5,'',0,1);
		$pdf->Cell(12,5,'');
		$pdf->Cell(100,5,'Die folgenden Mieter wurden bei dem Versuch eine Wartung durchzufuhren nicht angetroffen ',0,1);
		$pdf->Cell(12,5,'');
		$pdf->Cell(100,5,'trotz Benachrichtigung mit Bitte um Ruckruf unter folgender Telefonnummer:  (Hr. Golbs) 0173-2369649.',0,1);
		$pdf->Cell(12,5,'');
		$pdf->Cell(100,5,'',0,1);
		$pdf->Cell(12,5,'');
		$pdf->Cell(100,5,'',0,1);

$result = @mysql_query("SELECT * FROM HV_Fehlendemieter WHERE HVID = ".$_GET['HVID']." ORDER BY ID asc") or print('DB Fehler '.mysql_error());
while($row = @mysql_fetch_object($result)) {
	
		//for($i=1;$i<=80;$i++)
		//$pdf->Cell(0,5,'Printing line number '.$i,0,1);
		$pdf->Cell(12,5,'');
		//$pdf->Cell(100,5,'Mieter');
		$pdf->Cell(50,5,$row->Mieter);
		$pdf->Cell(50,5,'('.$row->Lage.')');
		$pdf->Cell(20,5,$row->Strasse,0,1);
			
}

function convert_timestamp($zeitstempel,$was)
{
	$datum=substr($zeitstempel,0,10);
	$datum=strtotime($datum);
	$datum=date("d.m.Y",$datum);
	$ausgabe=$datum;
	
	$zeit=substr($zeitstempel,11,5);
	
	switch ($was) {
    case 'datum':
    $ausgabe=$datum;
    break;
    case 'zeit':
    $ausgabe=$zeit;
    break;
    case 'alles';
    $ausgabe.=" - ".$zeit.""; // um anstatt -
    break;
	}
	return($ausgabe);
}
$result = @mysql_query("SELECT * FROM HV_Fehlendemieter WHERE HVID = ".$_GET['HVID']." ORDER BY ID desc LIMIT 1") or print('DB Fehler2 '.mysql_error());
while($row = @mysql_fetch_object($result)) {
	$pdf->Cell(155,5,'');
	$pdf->Cell(12,25,'Stand: ');
	$pdf->Cell(20,25,convert_timestamp($row->Datum,'datum'),0,1);
}


/*$num_rows = mysql_num_rows($result);  // ergebnisse zaehlen
if($num_rows == "0"){
	echo "<center><br/><br/><br/><h2>Keine Suchergebnisse!</h2></center>\n";
}else{*/
	$pdf->Output();
//}

?>
