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
        <title>MBC Administration Upload Image</title>
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
                                        
                    if (isset($_POST['upload_image'])) {
                        
                        $img_name = basename($_FILES['image_file']['name']);
                        $uploadfile = $img_dir.$img_name;
                        
                        $query = mysql_query("SELECT COUNT(*) FROM images where name = '" . $img_name . "'");
			$result = mysql_result($query, 0, 0);
			
			if ($result > 0) {
			    echo "<span class='error'>Image $img_name already exists - please upload with a different name</span>";	
			} else if ((substr(strtolower($img_name), -4) != '.jpg') & ((substr(strtolower($img_name), -5) != '.jpeg'))) {
			    echo "<span class='error'>Only upload '.jpg' or '.jpeg' files</span>";
			} else {
                            include('SimpleImage.php');
      		   	    $image = new SimpleImage();
   			    $image->load($_FILES['image_file']['tmp_name']);
	 	            $image->resize(110,154);
   			    $image->save($uploadfile);
                            
                            $queryInsertImage = "insert into images (name) values ('" . $img_name . "')";
                            $result = mysql_query($queryInsertImage);
                            echo "<span class='success'>IMAGE $img_name UPLOADED</span>";                           
                        }
                        
                        unset($_POST['upload_image']);
                    }
                    
                ?>

                <h3>Upload image</h3>        
                <!-- MAX_FILE_SIZE must precede the file input field -->
                <input type="hidden" name="MAX_FILE_SIZE" value="0" />
                <!-- Name of input element determines name in $_FILES array -->
                <div id="image_upload">
                    <input name="image_file" type="file" /><br /><br />
                    <input name="upload_image" type="submit" value="Upload Image" />
                </div>
            </form>
        </div>
    </body>
</html>
