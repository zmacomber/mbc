<?php 
    $db = mysql_connect('localhost', 'midcoast_admin', 'admin_pwd');
    
    if (!$db)
    {
        die('Could not connect: ' . mysql_error());
    }
    
    mysql_select_db('midcoast_db', $db);
?>
