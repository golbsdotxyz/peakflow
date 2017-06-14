<?php
// Beschreibung und erklaerung auf http://fpdf.de/funktionsreferenz/MultiCell


require('../lib/php/dbconfig.php');

require('../fpdf17/fpdf.php');

class PDF extends FPDF{
	//Kopfzeile
	function Header(){
	    $this->SetFont('Arial','',16);
	    function ReturnMonthName($numb){ 
			$month = array('Januar', 'Februar', 'März', 'April','Mai','Juni','Juli','August','September','Ocktober','November','Dezember'); 
			return $month[$numb-1]; 
		} 
		$this->Cell(50,4,utf8_decode('PeakFlow '.ReturnMonthName($_GET['month']).' '.$_GET['year']),0,0,'');
		if(isset($_GET['name'])){
			$this->Cell(20,4,'',0,0,'');
			$this->Cell(50,4,utf8_decode($_GET['name']),0,0,'');
		}
	    //Zeilenumbruch
	    $this->Ln(20);
	}
	
	//Fusszeile
	function Footer(){
		//Position 2,5 cm von unten
		$this->SetY(-23); //-23
		//Arial kursiv 7
		$this->SetFont('Arial','',6);
	    //Seitenzahl
	    $this->Cell(0,10,'Seite '.$this->PageNo().' von {nb}',0,0,'C');
	}
}

// Datenbanverbindung aufbauen

	
	// Neues PDF-Dokument erstellen 
	$pdf = new PDF('P', 'mm', 'A4'); 
	
	// zaehlt alle seiten
	$pdf->AliasNbPages();
	
	// neue Seite erzeugen 
	$pdf->AddPage(); 

	$pdf->SetLeftMargin(10); // genereller Abstand von links
    $pdf->SetRightMargin(10);  // genereller Abstand von rechts
	
	
	#$pdf->Ln(6);
	#$pdf->SetFont('helvetica', 'B', 5 ); 
	#$pdf->Cell(130,4,utf8_decode('Die nachfolgenden Werte für den Monat .'),0,1); // Betreff
	
	$pdf->SetFont('helvetica', '', 7 );
	
	$pdf->SetLineWidth(0.1);
	if(isset($_GET['month'])){ 
        $monat = $_GET['month'];
    }
    else{ 
        $monat = date('m');
    }
    if(isset($_GET['year'])){ 
        $jahr = $_GET['year'];
    }
    else{
        $jahr = date('Y');
    }
    
	// Anzahl der Tage des jeweiligen Monat
    $number = cal_days_in_month(CAL_GREGORIAN, $monat, $jahr); 


    // tabelle
    #$pdf->SetWidths(array(20, 20, 50, 80)); // angeben der einzelnen Spaltenbreiten
    #$pdf->SetAligns(array('C', 'C', 'L', 'L')); // angeben der einzelnen Ausrichtungen
    #$pdf->Row(array('Datum', 'Zeitpunkt', 'Werte', 'Bemerkungen'));

    $pdf->Cell(20,3, 'Datum',0,0);
    $pdf->Cell(20,3, 'Zeitpunkt',0,0, 'C');
    $pdf->Cell(80,3, 'Bemerkungen',0,0,'L'); //80
    #$pdf->Cell(50, 3, 'Wert', 0, 1, 'L', 0);

    $pdf->SetFont('helvetica', '', 6 );
    $pdf->SetFillColor(0, 0, 0);
    $pdf->Cell(0.1, 3, '0', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '50', 0, 0, 'C');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '100', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '150', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '200', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '250', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '300', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '350', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '400', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '450', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '500', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,1, 'C', 1);

    $pdf->MultiCell( 190, 1, '', 'B', 'C', 0);

    


    $pdf->SetFont('helvetica', '', 8 );
    for($i=1;$i <= $number;$i++){
    	// einstellige zahl mit null auffuellen links vor der zahl bis zweistellig
    	$newi = str_pad($i, 2 ,'0', STR_PAD_LEFT); 
    	// einstellige zahl mit null auffuellen links vor der zahl bis zweistellig
    	$monat = str_pad($monat, 2 ,'0', STR_PAD_LEFT); 

    	$tagesdatum = $newi.".".$monat.".".$jahr;

    	// Datum umdrehen yyyy-mm-dd
    	$originalDate = $newi."-".$monat."-".$jahr;
		$newDate = date("Y-m-d", strtotime($originalDate));
		$newDate = substr($newDate, 0, 10);

		// Werte ermitteln fuer einen tag morgens
    	$stmt2 = $db_con->prepare("SELECT * FROM Werte WHERE Datum LIKE '%".$newDate."%' AND Zeitpunkt = 1");
		$stmt2->execute(array());
		$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
		$gerundeterwertfrueh = round( ($row2['Wert1']+$row2['Wert2']+$row2['Wert3'])/3);

		// Werte ermitteln fuer einen tag abends
    	$stmt3 = $db_con->prepare("SELECT * FROM Werte WHERE Datum LIKE '%".$newDate."%' AND Zeitpunkt = 2");
		$stmt3->execute(array());
		$row3=$stmt3->fetch(PDO::FETCH_ASSOC);
		$gerundeterwertabends = round( ($row3['Wert1']+$row3['Wert2']+$row3['Wert3'])/3);


		$wochentage = array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
		$zeit = strtotime($newDate);
		$wochentag = $wochentage[date("w", $zeit)];




// #############################
// MOrgens
// #############################
		$statement = $db_con->prepare("SELECT Eingabe FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
        $statement->execute(array('WerteID' => $row2['ID']));
        $bemerkungfrueh = array();
        while($zeile = $statement->fetch()) {
        	$bemerkungfrueh[] = $zeile['Eingabe'];
        }
        $bf = implode(", ", $bemerkungfrueh);
    	#$pdf->Row(array($tagesdatum, 'Morgens', $gerundeterwertfrueh, $bf ));
    	$pdf->Cell(20,3, $wochentag.' '.$tagesdatum,0,0);
    	$pdf->SetFont('helvetica', '', 6 );
    	$pdf->Cell(20,3, 'Morgens',0,0, 'C');
    	#$pdf->Cell(50,3, $gerundeterwertfrueh,0,0);
    	$pdf->Cell(80.1,3, $bf,0,0,'L'); //80
    	$pdf->SetFont('helvetica', '', 8 );

    	
    	if($gerundeterwertfrueh > 0){
    		$pdf->SetFillColor(0, 0, 0);
    		$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    		$pdf->SetFillColor(255, 200, 0);
    		$pdf->Cell($gerundeterwertfrueh/10, 3, $gerundeterwertfrueh, 0, 0, 'R', 1);
    		$pdf->Cell(0.2,3, '',0,1, 'C', 1);
    	}else{
    		$pdf->SetFillColor(0, 0, 0);
    		$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    		$pdf->SetFillColor(255, 200, 0);
    		$pdf->Cell(50, 3, '', 0, 1, 'L', 0);
    	}


// #############################
// Abedns
// #############################
    	$statement2 = $db_con->prepare("SELECT * FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
        $statement2->execute(array('WerteID' => $row3['ID']));
        $bemerkungabends = array();
        while($zeile2 = $statement2->fetch()) {
             $bemerkungabends[] = $zeile2['Eingabe'];
        }
        $ba = implode(", ", $bemerkungabends);
    	#$pdf->Row(array($tagesdatum, 'Abends', $gerundeterwertabends, $ba ));
    	$pdf->Cell(20,3, '',0,0); //$pdf->Cell(20,3, $tagesdatum,0,0);
    	$pdf->SetFont('helvetica', '', 6 );
    	$pdf->Cell(20,3, 'Abends',0,0, 'C');
    	#$pdf->Cell(50,3, $gerundeterwertabends,0,0); 
    	$pdf->Cell(80.1,3, $ba,0,0,'L'); //80
    	$pdf->SetFont('helvetica', '', 8 );

    	
    	if($gerundeterwertabends > 0){
    			$pdf->SetFillColor(0, 0, 0);
    		$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    			$pdf->SetFillColor(255, 110, 0);
    		$pdf->Cell($gerundeterwertabends/10, 3, $gerundeterwertabends, 0, 0, 'R', 1);
    		$pdf->Cell(0.2,3, '',0,1, 'C', 1);
    	}else{
    			$pdf->SetFillColor(0, 0, 0);
    		$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    			$pdf->SetFillColor(255, 110, 0);
    		$pdf->Cell(50, 3, '', 0, 1, 'L', 0);
    	}
    	
    
    	$pdf->MultiCell( 190, 0.1, '', 'B', 'C', 0);

    }
	// Automatischen Seitenumbruch aktivieren 
/*	$pdf->SetAutoPageBreak(true); 
	
	
*/	
	$pdf->Cell(20,3, '',0,0);
    $pdf->Cell(20,3, '',0,0, 'C');
    $pdf->Cell(80,3, '',0,0,'L'); //80
    #$pdf->Cell(50, 3, 'Wert', 0, 1, 'L', 0);

    $pdf->SetFont('helvetica', '', 6 );
    $pdf->SetFillColor(0, 0, 0);
    $pdf->Cell(0.1, 3, '0', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '50', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '100', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '150', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '200', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '250', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '300', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '350', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '400', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '450', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,0, 'C', 1);
    $pdf->Cell(50/10, 3, '500', 0, 0, 'R');
    	$pdf->Cell(0.2,3, '',0,1, 'C', 1);

    #$pdf->MultiCell( 190, 1, '', 'B', 'C', 0);
	
	
	
	
	
	
	
	
	
	
	
	


	// ----------------------------------------------------- //
	
	// Linienfarbe auf Blau einstellen 
	#$pdf->SetDrawColor(0, 0, 255); 
	
	// Füllung auf Rot einstellen  
	#$pdf->SetFillColor(255, 0, 0);  
	
	// Textzeile 
	#$string = 'Angebot'; 
	
	
	// Beispiel_1 
	
	/* 
	Breite 180mm, Höhe 10mm 
	$string = Text schreiben 
	B = nur Rahmen unten zeichnen 
	C = Text zentrieren 
	0 = ohne Füllung 
	*/ 
	#$pdf->MultiCell( 180, 10, $string , 'B', 'C', 0); 
	
	// Zeilenumbruch, Höhe 10mm 
	#$pdf->Ln(10); 
	
	
	// Beispiel_2 
	
	/* 
	Breite 180mm, Höhe 10mm 
	$string = Text schreiben 
	1 = mit Rahmen zeichnen 
	L = Text linkbündig 
	1 = mit Füllung 
	*/ 
	#$pdf->MultiCell( 180, 10, $string , 1, 'L', 1); 
	
	// Zeilenumbruch, Höhe 10mm 
	#$pdf->Ln(10); 
	
	
	// Beispiel_3 
	
	// Text mit Zeilenumbruch, Anführungszeichen beachten 
	#$string = "Zeile_1\nZeile_2\nTeile_3"; 
	
	/* 
	Breite 180mm, Höhe 10mm 
	$string = Text schreiben 
	0 = ohne Rahmen zeichnen 
	R = Text rechtsbündig 
	1 = mit Füllung 
	*/ 
	#$pdf->MultiCell( 180, 10, $string , 0, 'R', 1); 
	
	// Zeilenumbruch, Höhe 10mm 
	#$pdf->Ln(10); 
	
	// neue Seite erzeugen 
	#$pdf->AddPage();
	
	// Ausgabe zum Browser als test.pdf senden 
	$pdf->Output( 'peakflow.pdf', 'I'); 

?>
