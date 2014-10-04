<?php 
    session_start(); 
    if (isset($_SESSION['login_success']) == false) {
        header('Location: http://midcoastbaptistchurch.com/admin/admin_login.php');
    }

    // Database connection
    require("database.php");
    
    // Disable magic quotes
    require("disable_magic_quotes.php")
?>
<html> 
    <head>
        <title>MBC Administration Delete Media</title>
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
            <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                <?php
                
                // check if the "delete" button was pushed
		foreach(array_keys($_POST) as $k) {
    		    if (strstr($k,"delete"))
		    {
		    	$delete_success = true;
		    	
		        $media_id = str_replace("delete","",$k);
		        
		    	// get the media entry this id corresponds to
		    	$query = mysql_query("select * from media where id=" . $media_id);
		    	$row = mysql_fetch_array($query);
                 	$curpath = $row['path'];		    	
		    	
		    	// if ".mp3" is in the filename, this is an audio file
		    	if (strstr($curpath,".mp3")) {
                            
                            $audio_dir = "../data/audio/";		    	
                            $filename  = $audio_dir.$curpath;
		    	
		    	    // unlink function return bool so you can use it as conditon
                            if ( ! (unlink($filename))) {
                                $delete_success = false;
                            }
                        }
		    	
		        $queryDeleteResult = mysql_query("DELETE FROM media WHERE id=" . $media_id); 
		        
		        if ( ! ($queryDeleteResult)) {
		    	    $delete_success = false;
		    	}
		        
		        if ($delete_success) {
                            echo "<span class='ui-state-highlight'>MEDIA DELETED SUCCESSFULLY</span>";
                        }
                        else {
                            echo "<span class='ui-state-error'>FAILED TO DELETE MEDIA - PLEASE CONTACT ADMINISTRATOR</span>";
                        }	
		    }
                }     
                ?>
                <h3>Delete media</h3>
                <table class="sortable" border="1">
                    <tr>
                        <th></th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Path</th>
                    </tr>
                <?php
                    $queryGetMedia = mysql_query("select * from media order by id");

                    while ($rowGetMedia = mysql_fetch_array($queryGetMedia)) {
                        $category = htmlspecialchars($rowGetMedia['category']);                        
                        $title    = htmlspecialchars($rowGetMedia['title']);
                        $path     = htmlspecialchars($rowGetMedia['path']);                                                        
                        $id       = htmlspecialchars($rowGetMedia['id']);
                ?>   
                    <tr>
                        <td><input type="submit" name="delete<?php echo $id; ?>" value="Delete" /></td>
                        <td><?php echo $category; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $path; ?></td>
                    </tr>
                <?php
                    }
                ?>
                </table>
            </form>
        </div>
    </body>
</html>

