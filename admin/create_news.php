<?php 
    session_start(); 
    if (isset($_SESSION['login_success']) == false) {
        header('Location: http://midcoastbaptistchurch.com/admin/admin_login.php');
    }

    // Database connection
    require("database.php");
    
    // Disable magic quotes
    require("disable_magic_quotes.php");
?>
<html> 
    <head>
        <title>MBC Administration Create News</title>
        <link type="text/css" href="../css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
        <link type="text/css" href="../css/admin.css" rel="stylesheet" />
        <script type="text/javascript" src="../javascripts/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../javascripts/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>
        <script type="text/javascript" src="../javascripts/admin.js"></script>
    </head>
    <body>
        <!-- Menu and Header -->
        <?php require("menu.php"); ?>

        <!-- Content Area -->
        <div id="content">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                <?  
                    if (isset($_POST['create_news_submit'])) {

                        $event_date = mysql_real_escape_string($_POST['event_date'], $db);
                        $event_desc = mysql_real_escape_string($_POST['event_desc'], $db);

                        $queryResult = mysql_query(
                            "INSERT INTO news (event_date, event_desc) " . 
                            "VALUE (STR_TO_DATE('{$event_date}','%m/%d/%Y'),'{$event_desc}')");
                       
                        if ($queryResult) {
                            echo "<span class='success'>NEWS ENTRY CREATED SUCCESSFULLY</span>";
                        }
                        else {
                            echo "<span class='error'>FAILED TO CREATE NEWS ENTRY - PLEASE CONTACT ADMINISTRATOR</span>";
                        }
                        
                        unset($_POST['create_news_submit']);
                    }
                    
                ?>
                <h3>Create news entry</h3>
                <div style="float:left;">
                <fieldset>
	        <div>
	            <label for="event_date">Event date:</label>
		    <input type="text" id="event_date" name="event_date" />
	        </div>
	        <div>
	            <label for="event_desc">Event description:</label>
	            <input id="event_desc" name="event_desc" type="text" size="200" maxlength="200" />
	        </div><br />
                <input name="create_news_submit" id="create_news_submit" type="submit" value="Submit" />
                </fieldset>
                </div>
            </form>
        </div>
        <script>
	    $(function() {
	        $("#event_date").datepicker();
	    });
	</script>
    </body>
</html>