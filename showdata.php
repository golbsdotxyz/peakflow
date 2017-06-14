<?php
include_once 'lib/inc/int.header.php';
include_once 'lib/inc/int.navi.php';
?>


<div class="body-container">

  <div class="container">
    <h1>Datenübersicht</h1>


<!-- NAVIGATION START -->
    <?php
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
    ?>
    <div class="form-group">
        <label class="control-label" for="year">Jahr</label>
        <select name="year" id="year" onChange="window.location.href=this.options[this.selectedIndex].value">
            <option value="?year=<?php echo date('Y');?>" selected><?php echo $jahr;?></option>
            <?php
            $jahrstart = 2016;
            while($jahrstart <= date('Y')){?>
                <option value="?year=<?php echo $jahrstart;?>"><?php echo $jahrstart;?></option>";
                <?php $jahrstart++;
            } ?>
        </select>
        <label class="control-label" for="month">Monat</label>
        <select name="month" id="month" onChange="window.location.href=this.options[this.selectedIndex].value">
            <option value="?month=<?php echo $monat;?>" selected><?php echo $monat;?></option>
            <?php
            $monatstart = 01;
            while($monatstart <= 12){?>
                <option value="?month=<?php echo str_pad($monatstart, 2 ,'0', STR_PAD_LEFT);?>"><?php echo str_pad($monatstart, 2 ,'0', STR_PAD_LEFT);?></option>";
                <?php $monatstart++;
            } ?>
        </select>

        <a href="doc/index.php?year=<?php echo $jahr;?>&month=<?php echo $monat;?>" target="_blank">Drucken</a>
    </div>
<!-- NAVIGATION ENDE -->







<table>
    <tr class="tbl-head">
        <th class="tbl-datum tbl-head">Tage</th>
        <th class="tbl-zeitpunkt tbl-head">Zeitpunkt</th>
        <th class="tbl-head">Werte</th>
        <th class="tbl-head">Bemerkungen</th>
    </tr>
    <?php  
    for($i=1;$i <= $number;$i++): 

        // einstellige zahl mit null auffuellen links vor der zahl bis zweistellig
        $newi = str_pad($i, 2 ,'0', STR_PAD_LEFT); 
        // einstellige zahl mit null auffuellen links vor der zahl bis zweistellig
        $monat = str_pad($monat, 2 ,'0', STR_PAD_LEFT); 

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


    ?>
    <!-- Morgens -->
    <tr class="tbl-abschnitt">
        <td style="text-align:center;" class="headdate" rowspan="2"><?php echo $newi.".".$monat.".".$jahr;?></td>
        <td>Morgens</td>
        <?php $o = $gerundeterwertfrueh; ?>
        <td><div data-toggle="tooltip" title="<?php echo $row2['Datum'];?>" style="display:block; height:auto; width:<?php echo $o;?>px; border-right:5px solid green; background:green; text-align:right; padding:1px 5px;"><?php echo $gerundeterwertfrueh;?></div></td>
        <td class="tbl-bemerkung">
            <?php 
            $statementf = $db_con->prepare("SELECT * FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
            $statementf->execute(array('WerteID' => $row2['ID']));
            while($zeilef = $statementf->fetch()) {
               echo substr($zeilef['Eingabe'], 0, 10).", ";
            }
            ?>
        </td>
    </tr>
    <!-- Abends -->
    <tr style="background:#CCC;" class="tbl-abschnitt">
        <td>Abends</td>
        <?php $o = $gerundeterwertabends; ?>
        <td><div data-toggle="tooltip" title="<?php echo $row3['Datum'];?>" style="display:block; height:auto; width:<?php echo $o;?>px; border-right:5px solid red; background:red; text-align:right; padding:1px 5px;"><?php echo $gerundeterwertabends;?></div></td>
        <td class="tbl-bemerkung">
            <?php 
            $statement = $db_con->prepare("SELECT * FROM WerteZusatzEingabe WHERE WerteID = :WerteID");
            $statement->execute(array('WerteID' => $row3['ID']));
            while($zeile = $statement->fetch()) {
               echo substr($zeile['Eingabe'], 0, 10).", "; 
            }
            ?>
        </td>
    </tr>
    <?php endfor; ?>
</table>





<!-- NAVIGATION START -->
    <?php
    if(isset($_GET['month'])){ $monat = $_GET['month'];}
    else{ $monat = date('m');}
    if(isset($_GET['year'])){ $jahr = $_GET['year'];}
    else{$jahr = date('Y');}
    // Anzahl der Tage des jeweiligen Monat
    $number = cal_days_in_month(CAL_GREGORIAN, $monat, $jahr); 
    ?>
    <div class="form-group">
        <label class="control-label" for="year">Jahr</label>
        <select name="year" id="year" onChange="window.location.href=this.options[this.selectedIndex].value">
            <option value="?year=<?php echo date('Y');?>" selected><?php echo $jahr;?></option>
            <?php
            $jahrstart = 2016;
            while($jahrstart <= date('Y')){?>
                <option value="?year=<?php echo $jahrstart;?>"><?php echo $jahrstart;?></option>";
                <?php $jahrstart++;
            } ?>
        </select>
        <label class="control-label" for="month">Monat</label>
        <select name="month" id="month" onChange="window.location.href=this.options[this.selectedIndex].value">
            <option value="?month=<?php echo $monat;?>" selected><?php echo $monat;?></option>
            <?php
            $monatstart = 01;
            while($monatstart <= 12){?>
                <option value="?month=<?php echo str_pad($monatstart, 2 ,'0', STR_PAD_LEFT);?>"><?php echo str_pad($monatstart, 2 ,'0', STR_PAD_LEFT);?></option>";
                <?php $monatstart++;
            } ?>
        </select>
    </div>
<!-- NAVIGATION ENDE -->


<br/><br/>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>





  </div>

</div>

<?php
include_once 'lib/inc/int.footer.php'; 
?>