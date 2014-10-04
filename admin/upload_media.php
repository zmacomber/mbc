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
        <title>MBC Administration Upload Media</title>
        <link type="text/css" href="/css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
        <link type="text/css" href="/css/admin.css" rel="stylesheet" />
        <link href="/css/fileuploader.css" rel="stylesheet" type="text/css">
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
                    $audio_dir  = "../data/audio/";
                   
                    if (isset($_POST['upload_audio'])) {

                    	$title      = mysql_real_escape_string($_POST['audio_title']);
                    	$category   = mysql_real_escape_string($_POST['audio_category']);
                        $audio_name = basename($_FILES['audio_file']['name']);
                        $uploadfile = $audio_dir.$audio_name;
                        
                        $query = mysql_query("SELECT COUNT(*) FROM media where path = '" . $audio_name . "'");
			$result = mysql_result($query, 0, 0);
			
			if (($title == '') || ($title == NULL) ||
                            ($category == '') || ($category == NULL) ||
                            ($audio_name == '') || ($audio_name == NULL)) {
                            echo "<span class='error'>Title, Category and Audio file are required fields</span>";                            
                        } else if ($result > 0) {
			    echo "<span class='error'>Media $audio_name already exists - please upload with a different name</span>";	                            
			} else if (ctype_alpha($category) === false) {
                            echo "<span class='error'>Category can only have letters (no spaces, commas, numbers, etc...)</span>";			    
			} else if (substr(strtolower($audio_name), -4) != '.mp3') {
			    echo "<span class='error'>Only upload '.mp3' files</span>";
			} else {
                            if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $uploadfile)) {
                                $queryInsertAudio = "insert into media (title, path, category ) values ('{$title}','{$audio_name}','{$category}')";
                                $result = mysql_query($queryInsertAudio);
                                if ($result) {
                                    echo "<span class='success'>AUDIO $audio_name UPLOADED SUCCESSFULLY</span>";
                                } else {
                                    echo "<span class='error'>FAILED TO INSERT RECORD FOR $audio_name - PLEASE CONTACT ADMINISTRATOR</span>";
                                }
                            } else {
                                echo "<span class='error'>FAILED TO UPLOAD AUDIO $audio_name - PLEASE CONTACT ADMINISTRATOR</span>";
                            }
                        }
                    }                    
                    if (isset($_POST['upload_video'])) {
                    
                        $title    = mysql_real_escape_string($_POST['video_title']);
                    	$category = mysql_real_escape_string($_POST['video_category']);
                        $path     = mysql_real_escape_string($_POST['video_path']);

                        $queryInsertVideo = "insert into media (title, path, category ) values ('{$title}','{$path}','{$category}')";
                        $result = mysql_query($queryInsertVideo);

                        if ($result) {
                            echo "<span class='ui-state-highlight'>VIDEO $title UPLOADED SUCCESSFULLY</span>";
                        } else {
                            echo "<span class='ui-state-error'>FAILED TO UPLOAD VIDEO $title - PLEASE CONTACT ADMINISTRATOR</span>";
                        }
                        
                        unset($_POST['upload_video']);
                    }
                ?>
                
                <div style="float:left;margin-bottom:20px;">
                    <h3>Upload media</h3>
		    <label for="media_type">Media type:</label>
		    <select id="section" onchange="displaySection(this.value);">
		        <option value=""></option>
			<option value="audio">Audio</option>
		    </select>
		</div>
		<div id="upload_audio" name="upload_audio" style="display:none;clear:both;float:left;">
	            <fieldset>  
	            <!-- MAX_FILE_SIZE must precede the file input field -->
	            <input type="hidden" name="MAX_FILE_SIZE" value="0" />
	            <!-- Name of input element determines name in $_FILES array -->
	            
	            <div>
	                <label for="audio_title">Title:</label>
	                <input id="audio_title" name="audio_title" 
	                type="text" size="50" maxlength="80" <?php if(isset($_POST['audio_title'])) { echo "value='" . $_POST['audio_title'] . "'"; } ?> />
	            </div>
	            <div>
	                <label for="audio_category">Category: *</label>
	                <input id="audio_category" name="audio_category" 
	                type="text" size="50" maxlength="80" <?php if(isset($_POST['audio_category'])) { echo "value='" . $_POST['audio_category'] . "'"; } ?> />
	            </div>
	            <div>
	            	<label for="audio_file">Audio file: **</label>
                	<input name="audio_file" type="file" />
	            </div>
	            <br />
       	            <div>
	            	<i>&nbsp;&nbsp;* Letters only (no spaces, commas, numbers, etc...)</i>
	            </div>
	            <div>
	            	<i>&nbsp;&nbsp;** MP3 only; larger files will take longer to upload</i>
	            </div>
	            <br />
	            <div>
	                <input name="upload_audio" type="submit" value="Upload Audio" />
                        <img id="progress" style="display:none" src="/images/ajax-loader.gif" alt="Uploading..." />
	            </div>
	            </fieldset>
	       </div>
	       <div id="upload_video" name="upload_video" style="display:none; float:left; clear:both;">
	       	    <fieldset>   
	            <div>
	                <label for="video_title">Title:</label>
	                <input id="video_title" name="video_title" type="text" size="50" maxlength="80"/>
	            </div>
	            <div>
	                <label for="video_category">Category:</label>
	                <input id="video_category" name="video_category" type="text" size="50" maxlength="80" />
	            </div>
	            <div>
	                <label for="video_path">Path (YouTube URL):</label>
	                <input id="video_path" name="video_path" type="text" size="50" maxlength="80" />
	            </div>
	            <br />
	            <div>
	                <input name="upload_video" type="submit" value="Upload Video" />
	            </div>
	            </fieldset>
	       </div>
            </form>
        </div>
        <script type="text/javascript">
            function displaySection(section) {

                document.getElementById('upload_audio').style.display = 'none';
                document.getElementById('upload_video').style.display = 'none';

            	if (section == 'audio') {
            	    document.getElementById('upload_audio').style.display = 'inline';
            	}
            	
           	if (section == 'video') {
            	    document.getElementById('upload_video').style.display = 'inline';
            	}
            }      
        </script>
     	<?php if (isset($_POST['upload_audio'])) { ?>
            <script type='text/javascript'>
                document.getElementById('section').selectedIndex = 1;
                displaySection('audio');
            </script>
            <?php unset($_POST['upload_audio']); ?>
        <?php } ?>
    </body>
</html>