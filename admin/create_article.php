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
        <title>MBC Administration Create Article</title>
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
            <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                <?
                    $img_dir  = "../data/photos/";
                    
                    if (isset($_POST['create_article_submit'])) {

                        $image_id   = mysql_real_escape_string($_POST['image_id'], $db);
                        $title      = mysql_real_escape_string($_POST['title'], $db);
                        $category   = mysql_real_escape_string($_POST['category'], $db);
                        $content    = mysql_real_escape_string(stripslashes($_POST['article_text']), $db);
                        $author     = mysql_real_escape_string($_POST['author'], $db);
                        $home_page  = isset($_POST['home_page']) ? 'Y' : 'N';
                        
                        // If "put_on_home_page" is 'Y', set all articles to have 'N'
                        if ($home_page == 'Y') {
	                    $queryResult = mysql_query("Update articles set put_on_home_page = 'N'");
	                }                            

                        if (($image_id == '') || ($image_id == NULL)) {
                            $image_id = 'NULL';
                        }
                        
                        // Replace all occurences of "<p>&nbsp;</p>" with "<br />" in the content                       
                        $content = str_replace("<p>&nbsp;</p>", "<br />", $content);
                        
                        // Replace all occurences of "<p>" with "" in the content                       
                        $content = str_replace("<p>", "", $content);
                        
                        // Replace all occurences of "</p>" with "<br />" in the content                       
                        $content = str_replace("</p>", "<br />", $content);
                        
                        // *** FORM VALIDATION ***
                        $formIsValid = true;
                        
                        // Check if all required fields are filled in
                        if (($title == '') || ($title == NULL) ||
                            ($category == '') || ($category == NULL) ||
                            ($author == '') || ($author == NULL) ||
                            ($content == '') || ($content == NULL)) {
                            echo "<span class='error'>Title, Category, Author and Content must all be filled in</span>";
                            $formIsValid = false;
                        }
                        
                        // Check if the category only contains alphabetic (a-z & A-Z) characters
                        if ($formIsValid) {
                            if ( ! (ctype_alpha($category)) ) {
                                echo "<span class='error'>Category can contain only alphabetic characters (a-z & A-Z)</span>";
                                $formIsValid = false;   
                            }
                        }
                        
                        // If form is still valid, it's OK now to insert into the database
                        if ($formIsValid) {
                            $queryResult = mysql_query(
                                "INSERT INTO articles (image_id, title, category, content, create_date, author, put_on_home_page) " . 
                                "VALUE ({$image_id},'{$title}','{$category}','{$content}',NOW(),'{$author}','{$home_page}')");
                       
                            if ($queryResult) {
                                echo "<span class='success'>ARTICLE CREATED SUCCESSFULLY</span>";
                            }
                            else {
                                echo "<span class='error'>FAILED TO CREATE ARTICLE - PLEASE CONTACT ADMINISTRATOR</span>";
                            }
                        }
                        
                        unset($_POST['create_article_submit']);
                    }
                    
                ?>
                <h3>Create article</h3>
                <div style="width:100%; overflow:auto">
                    <div style="float:left;">
                        <fieldset>
                        <div>
                            <label for="title">Title:</label>
                            <input id="title" name="title" type="text" size="40" maxlength="80" <?php if (isset($_POST['title'])) echo 'value="' . $_POST['title'] . '"' ?> />
                        </div>
                        <div>
                            <label for="category">Category: *</label>
                            <input id="category" name="category" type="text" size="40" maxlength="80" <?php if (isset($_POST['category'])) echo 'value="' . $_POST['category'] . '"' ?> />
                        </div>
                        <div>
                            <label for="author">Author:</label>
                            <input id="author" name="author" type="text" size="40" maxlength="80" <?php if (isset($_POST['author'])) echo 'value="' . $_POST['author'] . '"' ?> />
                        </div>  
                        <div>
                            <label for="home_page">Upload to home page?</label>
                            <input id="home_page" name="home_page" type="checkbox" />
                        </div>
                        <br />
                        <div>
                            <i>&nbsp;&nbsp;* Letters only (no spaces, commas, numbers, etc...)</i>
                        </div>
                        <br />
                        </fieldset>
                    </div>
                </div>
                <br />
                <textarea name="article_text" cols="50" rows="15"><?php if (isset($_POST['article_text'])) echo $_POST['article_text'] ?></textarea><br />
                <h4>Choose an image for this article (<i>optional</i>):</h4>
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
                <input id="create_article_clear_image" type="button" value="Clear Image" onClick="clearImage()" /><br />
                <input name="create_article_submit" id="create_article_submit" type="submit" value="Submit" />
                <input type="hidden" id="image_id" name="image_id" value="" />
                <script type="text/javascript">
	
                    // Image click processer
                    $("img").click(function () {
                        if (this.id != "full_image") {
                            document.getElementById("full_image").src = this.src;
                            document.getElementById("image_id").value = this.id;
                        }
                    });
                    
                    function clearImage() {
                        document.getElementById("full_image").src = "/images/blank.gif";
                        document.getElementById("image_id").value = "";
                    }
                    
                </script>
            </form>
        </div>
    </body>
</html>