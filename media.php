<?php 

    // Database connection
    require("database.php");
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

 <head>
  <title>Media</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/layout.css" rel="stylesheet" type="text/css" />
  <link href="/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="/jquery-ui-1.8.18.custom/js/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js"></script>
  <script type="text/javascript" src="/javascripts/main.js"></script> 
  <style>
    #content {
	text-align:center;
	margin-left:0px;
}
  </style>
 </head>

 <body id="page3">
  <div id="site_center">
   <div id="main">

    <!-- header -->
    <script language="JavaScript" type="text/javascript" src="javascripts/header.js"></script>

    <!-- content -->
    <div id="content" style="width:900px">
    <h3><a href="audio.php" title="audio" id="audio"><img src="images/audio.png" alt="" /></a></h3><br />
       <h3><a href="reading.php" title="reading" id="reading"><img src="images/reading.png" alt="" /></a></h3>
    </div>
    <div style="clear:both;margin-bottom:20px"></div>
    <!-- footer -->
    <script language="JavaScript" type="text/javascript" src="javascripts/footer.js"></script>
   </div>
  </div>	
  <script type="text/javascript" src="http://mediaplayer.yahoo.com/js"></script>
 </body>
</html>