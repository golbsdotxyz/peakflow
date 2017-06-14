<?php
//============================================================+
// License: GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2016 Nils Reimers - PHP-Einfach.de
// This is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// Nachfolgend erhaltet ihr basierend auf der open-source Library TCPDF (https://tcpdf.org/)
// ein einfaches Script zur Erstellung von PDF-Dokumenten, hier am Beispiel einer Rechnung.
// Das Aussehen der Rechnung ist mittels HTML definiert und wird per TCPDF in ein PDF-Dokument übersetzt. 
// Die meisten HTML Befehle funktionieren sowie einige inline-CSS Befehle. Die Unterstützung für CSS ist 
// aber noch stark eingeschränkt. TCPDF läuft ohne zusätzliche Software auf den meisten PHP-Installationen.
// Gerne könnt ihr das Script frei anpassen und auch als Basis für andere dynamisch erzeugte PDF-Dokumente nutzen.
// Im Ordner tcpdf/ befindet sich die Version 6.2.3 der Bibliothek. Unter https://tcpdf.org/ könnt ihr erfahren, ob 
// eine aktuellere Variante existiert und diese ggf. einbinden.
//
// Weitere Infos: http://www.php-einfach.de/experte/php-codebeispiele/pdf-per-php-erstellen-pdf-rechnung/ | https://github.com/PHP-Einfach/pdf-rechnung/

include_once '../lib/php/dbconfig.php';

$datum = date("d.m.Y");
$pdfAuthor = "PeakFlow Webapp";

$pdfName = "peakflow.pdf";


//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
// stark eingeschränkt.

if(isset($_GET['month'])){ 
	$monat = $_GET['month'];
}else{ 
	$monat = date('m');
}
if(isset($_GET['year'])){ 
	$jahr = $_GET['year'];
}else{
	$jahr = date('Y');
}

    // Anzahl der Tage des jeweiligen Monat
    $number = cal_days_in_month(CAL_GREGORIAN, $monat, $jahr); 

$html = '
<table>
	<tr class="tbl-head">
        <th class="tbl-datum tbl-head">Tage</th>
        <th class="tbl-zeitpunkt tbl-head">Zeitpunkt</th>
        <th class="tbl-head">Werte</th>
        <th class="tbl-head">Bemerkungen</th>
    </tr>
    '.  
    for($i=1;$i <= $number;$i++){ 

    	// einstellige zahl mit null auffuellen links vor der zahl bis zweistellig
    	$newi = str_pad($i, 2 ,'0', STR_PAD_LEFT); 
    	$monat = str_pad($monat, 2 ,'0', STR_PAD_LEFT); 

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
    .'
    <tr class="tbl-abschnitt">
        <td style="text-align:center;" rowspan="2">'.$newi.'.'.$monat.'.'.$jahr.'</td>
        <td>Morgens</td>
        <td><div style="display:block; height:auto; width:'.$gerundeterwertfrueh.'px; border-right:5px solid green; background:green; text-align:right; padding:1px 5px;">'.$gerundeterwertfrueh.'</div></td>
        <td class="tbl-bemerkung">
        	'. 
            $statement = $db_con->prepare("SELECT * FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
            $statement->execute(array('WerteID' => $row2['ID']));
            while($zeile = $statement->fetch()) {
        	   echo $zeile['Eingabe'].", ";
            }
        	.'
        </td>
    </tr>
    <tr style="background:#CCC;" class="tbl-abschnitt">
        <td>Abends</td>
        <td><div style="display:block; height:auto; width:'.$gerundeterwertabends.'px; border-right:5px solid red; background:red; text-align:right; padding:1px 5px;">'.$gerundeterwertabends.'</div></td>
        <td class="tbl-bemerkung">
        	'.
            $statement = $db_con->prepare("SELECT * FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
            $statement->execute(array('WerteID' => $row3['ID']));
            while($zeile = $statement->fetch()) {
               echo $zeile['Eingabe'].", ";
            }
        	.'
        </td>
    </tr>
    '.}.'
';
$html .="</table>";



$html .= nl2br($rechnungs_footer);



//////////////////////////// Erzeugung eures PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

// TCPDF Library laden
require_once('tcpdf/tcpdf.php');

// Erstellung des PDF Dokuments
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($pdfAuthor);
$pdf->SetTitle($pdfAuthor);
$pdf->SetSubject($datum);


// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Image Scale 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Schriftart
$pdf->SetFont('dejavusans', '', 10);

// Neue Seite
$pdf->AddPage();

// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');

//Ausgabe der PDF

//Variante 1: PDF direkt an den Benutzer senden:
$pdf->Output($pdfName, 'I');

//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';

?>