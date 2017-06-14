<?php

include_once 'lib/inc/int.header.php';
include_once 'lib/inc/int.navi.php';
?>
<script type="text/javascript" src="lib/js/validation.min.js"></script>
<script type="text/javascript" src="lib/js/profil.script.js"></script>
<script type="text/javascript" src="lib/js/pw.script.js"></script>
<div class="body-container">


  <div class="container">
    <form class="form-insert" method="post" id="insert-form">
      <h2 class="form-signin-heading">Deine Profildaten</h2><p>Alle Felder müssen ausgefüllt werden!</p><hr />
        
      <div id="error1">
        <!-- error will be shown here ! -->
      </div>

      <div class="form-group">
      <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Dein Name" value="<?php echo $row['user_name']; ?>"><br/>
      </div>
      
      <div class="form-group">
      <input type="email" class="form-control" placeholder="Emailaddresse" name="user_email" id="user_email" value="<?php echo $row['user_email']; ?>" />
      <span id="check-e"></span><br/>
      </div>

      <div class="form-group">
          <button type="submit" class="btn btn-default" name="btn-speichern" id="btn-speichern">
        <span class="glyphicon glyphicon-log-in"></span> &nbsp; Speichern
      </button> 
      </div> 
    </form>









    <p><br/></p>


    <form class="form-insert" method="post" id="pw-form">
      <h2 class="form-signin-heading">Dein Passwort ändern</h2><hr />

      <div class="form-group">
      <input type="password" class="form-control" name="password" id="password" placeholder="Passwort" value="">
      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Passwort wiederholen" value=""><br/>
      </div>

    <div class="form-group">
        <button type="submit" class="btn btn-default" name="pw-speichern" id="btn-pwspeichern">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Speichern
    </button> 
    </div> 
  </form>



  </div>

</div>

<?php
include_once 'lib/inc/int.footer.php'; 
?>