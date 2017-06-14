<?php
require('../../../config.php');
require('../fpdf.php');
require('../../../func/func_monteurname.php');

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		//Logo
		#$this->Image('pdf-header.gif',15,0,180);
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

/*$result = @mysql_query("SELECT * 
												FROM Kunden 
												WHERE (`Wartungs_Monat` LIKE '".$_GET["Suchwort_Monat"]."' AND `Wartungskunde` LIKE '1') 
												ORDER BY ID asc") or print('DB Fehler '.mysql_error());*/
$result = @mysql_query("	SELECT 
				Kunden.*,
				Kunden_Anlage.KundenID,
				Kunden_Anlage.AnlagentypID,
				Kunden_Anlage.Anlage,
				Kunden_Anlage.HerstellerNr,
				Kunden_Anlage.Bemerkung,
				Kunden_Anlage.Baujahr,
				Kunden_Anlage.Standort_Name,
				Kunden_Anlage.Standort_Strasse,
				Kunden_Anlage.Standort_PLZ,
				Kunden_Anlage.Standort_Ort,
				Kunden_Anlage.Standort_TelefonNr,
				Kunden_Anlage.Standort_TelefonNr2 
				FROM Kunden INNER JOIN Kunden_Anlage ON Kunden.ID=Kunden_Anlage.KundenID 
				WHERE (Kunden.Wartungs_Monat LIKE '".$_GET["Suchwort_Monat"]."' AND Kunden.Wartungskunde LIKE '1') ORDER BY Kunden.ID asc") or print('DB Fehler '.mysql_error());
while($row = @mysql_fetch_object($result)) {


//for($i=1;$i<=80;$i++)
	//$pdf->Cell(0,5,'Printing line number '.$i,0,1);
	#$pdf->Cell(6,5,'',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,'Kunde');
	$pdf->Cell(20,5,'Standort',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,$row->Eigentum_Name);
	$pdf->Cell(20,5,$row->Standort_Name,0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,$row->Eigentum_Strasse);
	$pdf->Cell(20,5,$row->Standort_Strasse,0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(100,5,$row->Eigentum_PLZ.' '.$row->Eigentum_Ort);
	$pdf->Cell(20,5,$row->Standort_PLZ.' '.$row->Standort_Ort,0,1);
	$pdf->Cell(6,5,'');
		if($row->Eigentum_TelefonNr2==""){
			$pdf->Cell(100,5,'Tel: '.$row->Eigentum_TelefonNr.'  '.$row->Eigentum_TelefonNr2);
		}else{
			$pdf->Cell(100,5,'Tel: '.$row->Eigentum_TelefonNr.' | '.$row->Eigentum_TelefonNr2);
		}
		if($row->Standort_TelefonNr2==""){
			$pdf->Cell(20,5,'Tel: '.$row->Standort_TelefonNr.'  '.$row->Standort_TelefonNr2,0,1);
		}else{
			$pdf->Cell(20,5,'Tel: '.$row->Standort_TelefonNr.' | '.$row->Standort_TelefonNr2,0,1);
		}
		//$pdf->Cell(100,5,'Tel: '.$row->Eigentum_TelefonNr.' | '.$row->Eigentum_TelefonNr2);
		//$pdf->Cell(20,5,'Tel: '.$row->Standort_TelefonNr.' | '.$row->Standort_TelefonNr2,0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(6,5,'__________________________________________________________________________________________',0,1);
	$pdf->Cell(6,5,'');
	$pdf->Cell(20,5,'Anlage: '.$row->Anlage,0,1);
	$pdf->Cell(6,5,'');
	//$pdf->Cell(20,5,'Letzte Wartung: '.$row->Wartungs_Tag.'.'.$row->Wartungs_Monat.'.'.$row->Wartungs_Jahr,0,1);
		if($row->HerstellerNr!=""){
			$pdf->Cell(100,5,'Hersteller-Nr.: '.$row->HerstellerNr);
			$pdf->Cell(20,5,'Letzte Wartung: '.$row->Wartungs_Tag.'.'.$row->Wartungs_Monat.'.'.$row->Wartungs_Jahr,0,1);
		}else{
			$pdf->Cell(20,5,'Letzte Wartung: '.$row->Wartungs_Tag.'.'.$row->Wartungs_Monat.'.'.$row->Wartungs_Jahr,0,1);
		}
	$pdf->Cell(6,5,'');
	//$pdf->Cell(20,5,'Betreut durch Monteur: Hr. '.$row->Nachname,0,1); // print_Monteurname($id)
	$pdf->Cell(20,5,'Betreut durch Monteur: Hr. '.print_Monteurname($row->MonteurID),0,1);
		$pdf->Cell(6,5,'');
		$pdf->Cell(20,5,'Bemerkung : '.$row->Bemerkung,0,1);
	
	$pdf->Cell(0,20,'',0,1);
	$pdf->Image('pdf-text.gif',15,100,180);
	#####################################################################################
	// die mit # beginnende folgende Zeile wurde herausgenomme seit v3
	#####################################################################################
	#$pdf->Cell(0,174,'',0,1);
	
	
	//$pdf->Cell(0,180,'',0,1);

	


}
//$num_rows = mysql_num_rows($result);  // ergebnisse zaehlen
//if($num_rows == "0"){
	//echo "<center><br/><br/><br/><h2>Keine Suchergebnisse!</h2></center>\n";
//}else{
	$pdf->Output();
//}
?>
