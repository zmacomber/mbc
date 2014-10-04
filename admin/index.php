<?php 
session_start(); 
if (isset($_SESSION['login_success']) == false) {
header('Location: http://midcoastbaptistchurch.com/admin/admin_login.php');
}
?>
<html> 
    <head>
        <title>MBC Administration</title>
        <link type="text/css" href="/css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
        <link type="text/css" href="/css/admin.css" rel="stylesheet" />
        <script type="text/javascript" src="/javascripts/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/javascripts/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>
        <script type="text/javascript" src="/javascripts/admin.js"></script>
    </head>
    <body>
        <!-- Menu and Header -->
        <?php require("menu.php"); ?>

        <!-- Content Area -->
        <div id="content"></div>
    </body>
</html>
