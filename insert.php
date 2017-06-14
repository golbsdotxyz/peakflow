<?php
include_once 'lib/inc/int.header.php';
include_once 'lib/inc/int.navi.php';
require_once 'lib/php/dbconfig.php';
?>
<script type="text/javascript" src="bootstrap/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap-datepicker.css"/> 
<!--<script type="text/javascript" src="lib/js/insert.script.js"></script>-->

<div class="body-container">

  <div class="container">


    <h1>Neue Werte eigeben</h1>
    <?php
    if(isset($_POST['btn-speichern'])){
		$errors = array();
		// Prueft, ob ein Name eingegeben wurde
		if(!isset($_POST["Datum"]) || trim($_POST["Datum"]) == "")
			$errors[] = "Das Datum fehlt !";
		if(!isset($_POST["Zeitpunkt"]) || trim($_POST["Zeitpunkt"]) == "0")
			$errors[] = "Du hast keinen Zeitpunkt gewählt !";
		if(!isset($_POST["Wert1"]) || trim($_POST["Wert1"]) == "")
			$errors[] = "Du hast den 1. Wert nicht eingetragen!";
		if(!isset($_POST["Wert2"]) || trim($_POST["Wert2"]) == "")
			$errors[] = "Du hast den 2. Wert nicht eingetragen!";
		if(!isset($_POST["Wert3"]) || trim($_POST["Wert3"]) == "")
			$errors[] = "Du hast den 3. Wert nicht eingetragen!";
		if(count($errors)){
			echo "<div class=\"box-error\">";
			foreach($errors as $error)
			echo "<li>".$error."</li>\n";
			echo "</div>\n";
		}else{
			$datum 		= trim($_POST['Datum']);
			$zeitpunkt 	= trim($_POST['Zeitpunkt']);
			$wert1 		= trim($_POST['Wert1']);
			$wert2 		= trim($_POST['Wert2']);
			$wert3 		= trim($_POST['Wert3']);
			#$bemerkung 	= trim($_POST['Bemerkung']);




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
		            $neue_id = $db_con->lastInsertId();

		            if(isset($_POST['Bemerkung'])){
	            		foreach ($_POST['Bemerkung'] as $bemerkung) {
	                		$stmt2 = $db_con->prepare("INSERT INTO WerteZusatzEingabe VALUES (:ID, :WerteID, :Eingabe)");
				            $stmt2->execute(array(
				                'ID' => NULL,
				                'WerteID' => $neue_id,
				                'Eingabe' => $bemerkung
				            ));
	            		}            
	       			}
				}
				catch(PDOException $e){
					echo $e->getMessage();
				}
			
			?>
			<div class='alert alert-success'> 
		  		<button class='close' data-dismiss='alert' onclick="window.location.replace('showdata.php')">&times;</button>
		  		Eintrag erfolgreich gespeichert.
		    </div>
		    <script>setTimeout(' window.location.href = "showdata.php"; ',500);</script>
			<?php

		}
	}
	?>

	<script language="javascript">
	function msgBox()
	{
	  return window.confirm("Wollen Sie wirklich speichern ??");
	}
	</script>	

    <form class="form-insert" method="post" id="insert-form">
    <fieldset><legend>Datum / Zeitpunkt</legend>
    <div class="form-group"> <!-- Date input -->
        <label class="control-label" for="date">Datum</label>
        <input class="form-control" id="date" name="Datum" placeholder="MM.DD.YYYY" type="text" value="<?php echo date('d.m.Y');?>"/>
    </div>
	<script>
	    $(document).ready(function(){
	      var date_input=$('input[name="Datum"]'); //our date input has the name "date"
	      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	      var options={
	        language: "de",
	        format: "dd.mm.yyyy",
	        container: container,
	        todayBtn: true,
	        todayHighlight: true,
	        autoclose: true,
	      };
	      date_input.datepicker(options);
	    })
	</script>

	<div class="form-group">
		<label class="control-label" for="zeitpunkt">Zeitpunkt</label>
		<select name="Zeitpunkt" id="zeitpunkt">
			<option value="0" selected>Bitte auswählen</option>
			<option value="1">Morgens</option>
			<option value="2">Abends</option>
		</select>
	</div>
	</fieldset>
	<p><br/></p>
	<fieldset><legend>Werte</legend>
	    <input type="tel" name="Wert1" id="wert1" maxlength="3" onkeyup="if (this.value.length == 3) this.form.Wert2.focus();" placeholder="1. Wert eingeben" value="<?php if(isset($_POST['Wert1'])) echo $_POST['Wert1'];?>"><br/>
	    <input type="tel" name="Wert2" id="wert2" maxlength="3" onkeyup="if (this.value.length == 3) this.form.Wert3.focus();" placeholder="2. Wert eingeben" value="<?php if(isset($_POST['Wert2'])) echo $_POST['Wert2'];?>"><br/>
	    <input type="tel" name="Wert3" id="wert3" maxlength="3" placeholder="3. Wert eingeben" value="<?php if(isset($_POST['Wert3'])) echo $_POST['Wert3'];?>"><br/>
	</fieldset>
	<p><br/></p>
    <fieldset><legend>Bemerkung</legend>
    	<?php
    	$stmt = $db_con->prepare("SELECT * FROM WerteZusatz ORDER BY ID ASC");
		$stmt->execute(array());
		while($row = $stmt->fetch()) {
			?>
			<input type="checkbox" name="Bemerkung[]" id="<?php echo $row['WerteZusatz'];?>" value="<?php echo $row['WerteZusatz'];?>"> <span for="<?php echo $row['WerteZusatz'];?>"><?php echo $row['WerteZusatz'];?></span><br/>
			<?php
		}
    	?>
    </fieldset>
    <p><br/></p>
    <div class="form-group">
    	<p>Bitte überprüfe nochmal deine Eingaben bevor du speicherst!</p>
        <button type="submit" class="btn btn-default" name="btn-speichern" id="btn-speichern" onclick="return msgBox(); this.style.visibility='hidden';">
    	<span class="glyphicon glyphicon-log-in"></span> &nbsp; Speichern
		</button> 
    </div> 
	</form>

  </div>

</div>

<?php
include_once 'lib/inc/int.footer.php'; 
?>