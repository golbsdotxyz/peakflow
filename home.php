<?php

include_once 'lib/inc/int.header.php';
include_once 'lib/inc/int.navi.php';
#include_once 'lib/func/reminder.php';
#doRemindMe();
?>
<div class="body-container">

  <div class="container">
      <div class='alert alert-success'>
  		  <button class='close' data-dismiss='alert'>&times;</button>
  			<strong>Hallo <?php echo $row['user_name']; ?></strong>, willkommen im Mitgliedsbereich.
      </div>
  </div>

  <div class="container">
    <h1>Willkommen bei PeakFlow</h1>


    <p>Wähle aus dem oben dargestellten Menü aus.</p>
    <p>
      Mit dem Führen eines Asthma-Tagebuchs können Sie sich einen guten Überblick über Ihre gesundheitliche Verfassung verschaffen. Hier vermerken Sie täglich im monatlichen Verlauf neben Ihren Peak-Flow-Messwerten auch Ihre einzelnen Beschwerden (tagsüber und nachts), Begleiterscheinungen (zum Beispiel tränende Augen, Fließschupfen) die eingenommenen Medikamente und besondere Ereignisse (zum Beispiel Urlaub, Krankheit, Stresssituationen, besonderes Ess- und Trinkverhalten). An diesen Kalender-Aufzeichnungen lässt sich dann direkt ablesen, zu welchen Zeiten, wie oft und wie stark ihre Bronchien verengt waren. So kann der Arzt beurteilen, ob die gewählten Medikamente richtig für Sie sind und auch von der Menge her ausreichen.
Insbesondere bei Veränderungen sollten Sie Ihre Beobachtungen festhalten, zum Beispiel bei Einnahme eines neuen Medikaments, Änderung der einzunehmenden Menge eines bisherigen Medikaments, neu auftretenden Beschwerden oder aber solchen, die verschwinden. So können Sie Ihre Erfahrungen miteinander vergleichen und sehen, ob sie übereinstimmen oder nicht. Das gibt Ihnen (wie beim Peak-Flow-Protokoll) die Möglichkeit den Verlauf Ihrer Asthmaerkrankung objektiver zu verfolgen und zu beurteilen. Beide Methoden können in vielen Fällen wichtige Hinweise liefern.
    </p>



  </div>

</div>

<?php
include_once 'lib/inc/int.footer.php'; 

  
?>