<?php 
    session_start(); 
    if (isset($_SESSION['login_success']) == false) {
        header('Location: http://midcoastbaptistchurch.com/admin/admin_login.php');
    }

    // Database connection
    require("database.php");
?>
<html> 
    <head>
        <title>MBC Administration Delete News</title>
        <link type="text/css" href="/css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
        <link type="text/css" href="/css/admin.css" rel="stylesheet" />
        <script type="text/javascript" src="/javascripts/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/javascripts/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>
        <script type="text/javascript" src="/javascripts/admin.js"></script>
        <script type="text/javascript" src="/javascripts/sorttable.js"></script>
        
        <style>
            table {
                empty-cells: show;
            }

            /* Sortable tables */
            table.sortable thead {
                background-color:#eee;
                color:#666666;
                font-weight: bold;
                cursor: default;
            }
        </style>
    </head>
    <body>
        <!-- Menu and Header -->
        <?php require("menu.php"); ?>

        <!-- Content Area -->
        <div id="content">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                <?php

                    // check if the "delete" button was pushed
		    foreach(array_keys($_POST) as $k) {
		        if (strstr($k,"delete"))
			{
			    $news_id = str_replace("delete","",$k);
			    $queryDeleteResult = mysql_query("DELETE FROM news WHERE id = " . $news_id); 
		
		            if ($queryDeleteResult) {
                                echo "<span class='success'>NEWS EVENT DELETED SUCCESSFULLY</span>";
                            }
                            else {
                                echo "<span class='error'>FAILED TO DELETE NEWS EVENT - PLEASE CONTACT ADMINISTRATOR</span>";
                            }		
			}
                    } 
      
                ?>
                <h3>Delete news event</h3>
                <table class="sortable" border="1">
                    <tr>
                        <th></th>
                        <th>Event Date</th>
                        <th>Event Description</th>
                    </tr>
                <?php
                    $queryGetNews = mysql_query("select id, date_format(event_date, '%m/%d/%Y') as event_date, event_desc " . 
                                                "from news where event_date >= now() order by event_date");

                    while ($rowGetNews = mysql_fetch_array($queryGetNews)) {
                        $event_date = htmlspecialchars($rowGetNews['event_date']);                        
                        $event_desc = htmlspecialchars($rowGetNews['event_desc']);
                        $id         = htmlspecialchars($rowGetNews['id']);
                ?>   
                    <tr>
                        <td><input type="submit" name="delete<?php echo $id; ?>" value="Delete" /></td>
                        <td><?php echo $event_date; ?></td>
                        <td><?php echo $event_desc; ?></td>
                    </tr>
                <?php
                    }
                ?>
                </table>
            </form>
        </div>
    </body>
</html>
