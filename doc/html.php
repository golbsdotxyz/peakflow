<?php

require('../lib/php/dbconfig.php');


$rechnungs_nummer = "743";
$rechnungs_datum = date("d.m.Y");
$lieferdatum = date("d.m.Y");
$pdfAuthor = "PHP-Einfach.de";


$pdfName = "Rechnung_".$rechnungs_nummer.".pdf"

//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
// stark eingeschränkt.

$html = '
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
	<tr>
		<td></td>
	   <td style="text-align: right">
	   	Rechnungsnummer <br>
		Rechnungsdatum: </td>
	</tr>
	<tr>
		 <td style="font-size:1.3em; font-weight: bold;">
<br><br>
Rechnung
<br>
		 </td>
	</tr>
	<tr>
		<td colspan="2">dia da</td>
	</tr></table>';







//////////////////////////// Erzeugung eures PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// TCPDF Library laden
include('../pdf/tcpdf/tcpdf.php');
// Erstellung des PDF Dokuments
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($pdfAuthor);
$pdf->SetTitle('Rechnung');
$pdf->SetSubject('Rechnung');
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