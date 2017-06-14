<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://peakflow.golbs.xyz/home.php">PeakFlow</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if($_SERVER['PHP_SELF']=="/home.php"){echo "class=\"active\"";}?> ><a href="home.php">Startseite</a></li>
            <li <?php if($_SERVER['PHP_SELF']=="/insert.php"){echo "class=\"active\"";}?> ><a href="insert.php">Neue Eingabe</a></li>
            <li <?php if($_SERVER['PHP_SELF']=="/showdata.php"){echo "class=\"active\"";}?> ><a href="showdata.php">Übersicht</a></li>
            <li <?php if($_SERVER['PHP_SELF']=="/info.php"){echo "class=\"active\"";}?> ><a href="info.php">Info</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			         <span class="glyphicon glyphicon-user"></span>&nbsp;Hallo <?php echo $row['user_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="profil.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Profil ändern</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>