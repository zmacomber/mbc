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
        <title>MBC Administration Delete Image</title>
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
        <div id="content">
            <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                <?
                    $img_dir  = "../data/photos/";
                                        
                    if (isset($_POST['create_article_delete_image'])) {
                        
                        $delete_success = true;
                        
                        $image_id = mysql_real_escape_string($_POST['image_id'], $db);

                        $queryImages = mysql_query("select name from images where id = " . $image_id);
                        $rowImages   = mysql_fetch_array($queryImages);
                        
                        $image_name = $rowImages['name']; // image_name from the database
                        
                        $filename = $img_dir.$image_name;
                        
                        // unlink function return bool so you can use it as conditon
                        if (unlink($filename)) {
                            
                            // delete from images and update articles for this image
                            $queryDeleteImage = "DELETE FROM images WHERE id = " . $image_id;
                            $result = mysql_query($queryDeleteImage);
                            
                            if (!$result) {
                                $delete_success = false;
                            }
                            
                            $queryUpdateArticle = "update articles set image_id = null where image_id = " . $image_id;
                            $result = mysql_query($queryUpdateArticle);
                            
                            if (!$result) {
                                $delete_success = false;
                            }
                            
                        } else {

                            $delete_success = false;

                        }
                        
                        if ($delete_success) {
                            echo "<span class='success'>IMAGE DELETED SUCCESSFULLY</span>";
                        }
                        else {
                            echo "<span class='error'>FAILED TO DELETE IMAGE - PLEASE CONTACT ADMINISTRATOR</span>";
                        }
                        
                        unset($_POST['create_article_delete_image']);
                        
                    }
                ?>
                
                <h3>Delete image</h3>
                <div id="image_wrap">
                    <?php
                        $queryResult = mysql_query("select id, name from images");
               
                        while($row = mysql_fetch_array($queryResult))
                        {
                            $id   = $row['id'];
                            $name = $row['name'];
                            echo "<img id='$id' src='/data/photos/$name' />";
                        }
                    ?>
                </div>
                <img class="img_indent" id="full_image" src="/images/blank.gif" />
                <input name="create_article_delete_image" id="create_article_delete_image" type="submit" value="Delete Image" />
                <input type="hidden" id="image_id" name="image_id" value="" />
                <script type="text/javascript">
	
                    // Image click processer
                    $("img").click(function () {
                        if (this.id != "full_image") {
                            document.getElementById("full_image").src = this.src;
                            document.getElementById("image_id").value = this.id;
                        }
                    });
                    
                </script>
            </form>
        </div>
    </body>
</html>

