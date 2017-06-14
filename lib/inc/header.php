<?php
session_start();

if(isset($_SESSION['user_session'])!=""){
	header("Location: home.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PeakFlowDoku</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="lib/js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="lib/js/validation.min.js"></script>
<link href="lib/css/style.css" rel="stylesheet" type="text/css" media="screen">
<script type="text/javascript" src="lib/js/script.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="lib/img/_icons/favicon.ico"/>
<link rel="icon" type="image/x-icon" href="lib/img/_icons/favicon.ico"/>
<link rel="icon" type="image/gif" href="lib/img/_icons/favicon.gif"/>
<link rel="icon" type="image/png" href="lib/img/_icons/favicon.png"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon.png"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-57x57.png" sizes="57x57"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-60x60.png" sizes="60x60"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-72x72.png" sizes="72x72"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-76x76.png" sizes="76x76"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-114x114.png" sizes="114x114"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-120x120.png" sizes="120x120"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-128x128.png" sizes="128x128"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-144x144.png" sizes="144x144"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-152x152.png" sizes="152x152"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-180x180.png" sizes="180x180"/>
<link rel="apple-touch-icon" href="lib/img/_icons/apple-touch-icon-precomposed.png"/>
<link rel="icon" type="image/png" href="lib/img/_icons/favicon-16x16.png" sizes="16x16"/>
<link rel="icon" type="image/png" href="lib/img/_icons/favicon-32x32.png" sizes="32x32"/>
<link rel="icon" type="image/png" href="lib/img/_icons/favicon-96x96.png" sizes="96x96"/>
<link rel="icon" type="image/png" href="lib/img/_icons/favicon-160x160.png" sizes="160x160"/>
<link rel="icon" type="image/png" href="lib/img/_icons/favicon-192x192.png" sizes="192x192"/>
<link rel="icon" type="image/png" href="lib/img/_icons/favicon-196x196.png" sizes="196x196"/>
<meta name="msapplication-TileImage" content="lib/img/_icons/win8-tile-144x144.png"/>
<meta name="msapplication-TileColor" content="#ffffff"/>
<meta name="msapplication-navbutton-color" content="#ffffff"/>
<meta name="application-name" content="PeakFlowDoku"/>
<meta name="msapplication-tooltip" content="PeakFlowDoku"/>
<meta name="apple-mobile-web-app-title" content="PeakFlowDoku"/>
<meta name="msapplication-square70x70logo" content="lib/img/_icons/win8-tile-70x70.png"/>
<meta name="msapplication-square144x144logo" content="lib/img/_icons/win8-tile-144x144.png"/>
<meta name="msapplication-square150x150logo" content="lib/img/_icons/win8-tile-150x150.png"/>
<meta name="msapplication-wide310x150logo" content="lib/img/_icons/win8-tile-310x150.png"/>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

</head>

<body>

<body>