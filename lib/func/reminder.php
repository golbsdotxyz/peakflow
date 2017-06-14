<?php
function doRemindMe(){

	$stmt = $db_con->prepare("SELECT * FROM Reminder WHERE ID = 1");
	$stmt->execute(array());
	$row=$stmt->fetch(PDO::FETCH_ASSOC);

	
	$date1 = substr($row['Date'],0,7);
	$date2 = substr(date('Y-m-d'),0,7);
	
	#$date3 = substr(date('Y-m-d'),5,-3);
	$date3 = date('m');
	$monat = FALSE;
	if($date3 == 01) $monat = "Januar"; 
	if($date3 == 02) $monat = "Februar"; 
	if($date3 == 03) $monat = "M&auml;rz"; 
	if($date3 == 04) $monat = "April"; 
	if($date3 == 05) $monat = "Mai"; 
	if($date3 == 06) $monat = "Juni"; 
	if($date3 == 07) $monat = "Juli"; 
	if($date3 == 08) $monat = "August"; 
	if($date3 == 09) $monat = "September"; 
	if($date3 == 10) $monat = "Oktober"; 
	if($date3 == 11) $monat = "November"; 
	if($date3 == 12) $monat = "Dezember"; 
	
	
	
	
	
	
	 
	if ($date1 > $date2 OR $date1 == $date2){
		// $date1 ist neuer oder gleich als $date2
	 	
	}else{
		
		// email versenden mit erinnerung start
		# +++++++++++++++++++++++++++++++++++++++ #
		$empfaenger = "<andre@golbs.xyz>";
		# +++++++++++++++++++++++++++++++++++++++ #
		$sender 	= "PeakFlow";
		$titel = "PeakFlow Protokoll";
		$header = "MIME-Version: 1.0\n";
		$header.= "Content-type: text/html; charset=UTF-8\n";
		$header.= "From:PeakFlowDoku Software <paekflow@golbs.xyz>";
		$mailbody = 	"<style>table {width: 100%; border: 1px solid #000;} th, tr, td {border: 1px solid #000;}.tbl-datum {width: 100px; text-align: center;}".
						".tbl-zeitpunkt {width:80px; text-align: center;}.tbl-bemerkung {min-width: 300px;}</style>".	
						"<div style=\"width:auto; padding:0; background:#FFFFFF; border:0px solid #000000; color:#000000; box-shadow:1px 1px 10px;\">".
							"<div style=\"width:auto; height:60px; margin:0; color:#FFFFFF; font-size:120%; padding:20px; background:#F60; text-align:center; border:0px solid #000000; box-shadow:1px 1px 10px; text-shadow:2px 2px 2px #000;\">".$titel."</div>".
							
							"<div style=\"width:auto; margin:30px 40px; background:none;\">".
							#################################################################
							"<table>".
								"<tr class=\"tbl-head\">".
							        "<th class=\"tbl-datum tbl-head\">Tage</th>".
							        "<th class=\"tbl-zeitpunkt tbl-head\">Zeitpunkt</th>".
							        "<th class=\"tbl-head\">Werte</th>".
							        "<th class=\"tbl-head\">Bemerkungen</th>".
							    "</tr>".
							    $monat = date('m')-1;
								$jahr = date('Y');
						    	#$ausgabe = $db_con->prepare("SELECT * FROM Werte WHERE Datum LIKE '%".$jahr."-".$monat."%'");
							    #$ausgabe->execute(array());
							    #while($ausgabezeile = $ausgabe->fetch()) {
							    /*for($i=1;$i <= $number;$i++):*/

							    	#$newDate = substr($ausgabezeile['Datum'], 0, 10);

									// Werte ermitteln fuer einen tag morgens
							    	/*$stmt2 = $db_con->prepare("SELECT * FROM Werte WHERE Datum LIKE '%".$newDate."%' AND Zeitpunkt = 1");
									$stmt2->execute(array());
									$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
									$gerundeterwertfrueh = round( ($row2['Wert1']+$row2['Wert2']+$row2['Wert3'])/3);

									// Werte ermitteln fuer einen tag abends
							    	$stmt3 = $db_con->prepare("SELECT * FROM Werte WHERE Datum LIKE '%".$newDate."%' AND Zeitpunkt = 2");
									$stmt3->execute(array());
									$row3=$stmt3->fetch(PDO::FETCH_ASSOC);
									$gerundeterwertabends = round( ($row3['Wert1']+$row3['Wert2']+$row3['Wert3'])/3);*/

								"<tr>".
							        "<td></td>".
							        "<td>Morgens</td>".
							        "<td></td>".
							        "<td>".
							        	#$statement = $db_con->prepare("SELECT * FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
							            #$statement->execute(array('WerteID' => $row2['ID']));
							            #while($zeile = $statement->fetch()) {
							        	#   echo $zeile['Eingabe'].", ";
							            #}
							        "</td></tr>".

							    // <!-- Morgens -->
							    /*"<tr class=\"tbl-abschnitt\">".
							        "<td style=\"text-align:center;\" rowspan=\"2\">".$ausgabezeile['Datum']."</td>".
							        "<td>Morgens</td>".
							        "<td><div style=\"display:block; height:auto; width:".$gerundeterwertfrueh."px; border-right:5px solid green; background:green; text-align:right; padding:1px 5px;\">".$gerundeterwertfrueh."</div></td>".
							        "<td class=\"tbl-bemerkung\">".
							        	#$statement = $db_con->prepare("SELECT * FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
							            #$statement->execute(array('WerteID' => $row2['ID']));
							            #while($zeile = $statement->fetch()) {
							        	#   echo $zeile['Eingabe'].", ";
							            #}
							        "</td>".
							    "</tr>".*/
							    // <!-- Abends -->
							    /*"<tr style=\"background:#CCC;\" class=\"tbl-abschnitt\">".
							        "<td>Abends</td>".
							        "<td><div style=\"display:block; height:auto; width:".$gerundeterwertabends."px; border-right:5px solid red; background:red; text-align:right; padding:1px 5px;\">".$gerundeterwertabends."</div></td>".
							        "<td class=\"tbl-bemerkung\">".
							        	$statement = $db_con->prepare("SELECT * FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
							            $statement->execute(array('WerteID' => $row3['ID']));
							            while($zeile = $statement->fetch()) {
							               echo $zeile['Eingabe'].", ";
							            }
							        "</td>".
							    "</tr>".*/
							    /*endfor;*/
								#}
							"</table>".

							#################################################################
							

								
							"</div>".
						"</div>";
		mail($empfaenger, $titel, $mailbody, $header);
		// email versenden mit erinnerung ende
		
		// datenbank aktualisieren
		$setzeneuesdate = date('Y-m-d');
	 	//DB insert
		#$sql = "UPDATE Reminder SET aktiviert = :aktiviert WHERE ID = :ID";
		#$stmt = $pdo->prepare($sql);
		#$stmt->bindParam(':Date', $setzeneuesdate);
		#$stmt->bindParam(':ID', '1');
		#$stmt->execute();
	}	
}