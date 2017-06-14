<?php
	session_start();
	require_once 'dbconfig.php';

	if(isset($_POST['btn-speichern'])){
		if(isset($_POST['Datum']) AND $_POST['Datum']!="")

		$datum = trim($_POST['Datum']);
		$zeitpunkt = trim($_POST['Zeitpunkt']);
		$wert1 = trim($_POST['Wert1']);
		$wert2 = trim($_POST['Wert2']);
		$wert3 = trim($_POST['Wert3']);
		$bemerkung = trim($_POST['Bemerkung']);

		$originalDate = $datum;
		$newDate = date("Y-m-d", strtotime($originalDate))." ".date("H:i:s");
		
		
		try{	

			//DB insert
			$stmt = $db_con->prepare("INSERT INTO Werte VALUES (:ID, :Datum, :Wert1, :Wert2, :Wert3, :Zeitpunkt)");
            $stmt->execute(array(
                'ID' => NULL,
                'Datum' => $newDate,
                'Wert1' => $wert1,
                'Wert2' => $wert2,
                'Wert3' => $wert3,
                'Zeitpunkt' => $zeitpunkt
            ));
			
		
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>