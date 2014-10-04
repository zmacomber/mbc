<?php 
    session_start(); 
    if (isset($_SESSION['login_success']) == false) {
        header('Location: http://localhost/admin/admin_login.php');
    }

    // Database connection
    require("database.php");
?>
<html> 
    <head>
        <title>MBC Administration Edit Article</title>
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
                border-collapse:collapse;
            }
            
            td a { color: rgb(0%,0%,50%); }
            td a:hover { color: rgb(50%,50%,50%); }

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
                <?
                    if (isset($_POST['edit_article_submit'])) {

                        $article_id = mysql_real_escape_string($_POST['article_id'], $db);
                        $image_id   = mysql_real_escape_string($_POST['image_id'], $db);
                        $title      = mysql_real_escape_string($_POST['title'], $db);
                        $category   = mysql_real_escape_string($_POST['category'], $db);
                        $content    = mysql_real_escape_string(stripslashes($_POST['article_text']), $db);
                        $author     = mysql_real_escape_string($_POST['author'], $db);
                        $home_page  = isset($_POST['home_page']) ? 'Y' : 'N';
                        
                        // Replace all occurences of "<p>&nbsp;</p>" with "<br />" in the content                       
                        $content = str_replace("<p>&nbsp;</p>", "<br />", $content);
                        
                        // Replace all occurences of "<p>" with "" in the content                       
                        $content = str_replace("<p>", "", $content);
                        
                        // Replace all occurences of "</p>" with "<br />" in the content                       
                        $content = str_replace("</p>", "<br />", $content);
                        
                        // Set image_id to "null" if nothing is in it
                        if ($image_id == null) {
                            $image_id = "null";
                        }
                        
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
                                echo "<span class='error'>Category can contain only letters (no spaces, commas, numbers, etc...)</span>";
                                $formIsValid = false;   
                            }
                        }
                        
                        // If form is still valid, it's OK now to update the database
                        if ($formIsValid) {
                        
                            $queryResult = mysql_query(
                            "Update articles set " .
                            "image_id = $image_id, " . 
                            "title = '$title', " . 
                            "category = '$category', " . 
                            "content = '$content', " . 
                            "modify_date = NOW(), " . 
                            "author = '$author', " . 
                            "put_on_home_page = '$home_page' " . 
                            "where id = " . $article_id);
                            
                            if (mysql_affected_rows() > 0) {
                                // If "put_on_home_page" is 'Y', set all the other articles to have 'N'
                                if ($home_page == 'Y') {
                                    $queryResult = mysql_query("Update articles set put_on_home_page = 'N' where id != " . $article_id);
                                }                            
                            
                                // Set the id to redisplay the article
                                $_GET['id'] = $article_id;   
                                echo "<span class='success'>ARTICLE UPDATED SUCCESSFULLY</span>";                            
                            }
                            else {                    
                                echo "<span class='error'>FAILED TO UPDATE ARTICLE - PLEASE CONTACT ADMINISTRATOR</span>";                        
                            }
                        }
                        
                        // Set the id to show the article again...
                        $_GET['id'] = $article_id;
                    }  
                ?>
                <?
                    if (isset($_GET['id'])) {
                        $id                 = $_GET['id'];
                        $queryGetArticle    = mysql_query("select * from articles where id = " . $id);
                        $rowGetArticle      = mysql_fetch_array($queryGetArticle);
                        $title              = isset($_POST['title']) ? $_POST['title'] : htmlspecialchars($rowGetArticle['title']);
                        $category           = isset($_POST['category']) ? $_POST['category'] : htmlspecialchars($rowGetArticle['category']);
                        $content            = isset($_POST['article_text']) ? $_POST['article_text'] : htmlspecialchars($rowGetArticle['content']);
                        $create_date        = htmlspecialchars($rowGetArticle['create_date']);
                        $modify_date        = htmlspecialchars($rowGetArticle['modify_date']);                            
                        $author             = isset($_POST['author']) ? $_POST['author'] : htmlspecialchars($rowGetArticle['author']);                            
                        $put_on_home_page   = $rowGetArticle['put_on_home_page']; 
                        $image_id           = $rowGetArticle['image_id'];
                ?>   
                    <input type="hidden" id="article_id" name="article_id" value="<?php echo $id; ?>" />              
                    <h3>Edit article</h3>
                    <div style="width:100%; overflow:auto"><div style="float:left;">
                    <fieldset class="create_article_fields">
                        <div>
                            <label for="title">Title:</label>
                            <input id="title" name="title" type="text" size="40" maxlength="80"
                                    value="<?php echo $title; ?>" />
                        </div>
                        <div>
                            <label for="category">Category: *</label>
                            <input id="category" name="category" type="text" size="40" maxlength="80"
                                    value="<?php echo $category; ?>" />                            
                        </div>
                        <div>
                            <label for="author">Author:</label>
                            <input id="author" name="author" type="text" size="40" maxlength="80"
                                    value="<?php echo $author; ?>" />                                                        
                        </div>
                        <div>
                            <label for="home_page">Upload to home page?</label>
                            <input id="home_page" name="home_page" type="checkbox" 
                                <?php if ($put_on_home_page == 'Y') { ?> checked="checked" <?php } ?>
                            />
                        </div>
                        <br />
                        <div>
                            <i>&nbsp;&nbsp;* Letters only (no spaces, commas, numbers, etc...)</i>
                        </div>
                        <br />
                    </fieldset>
                    </div></div>
                    <br />
                    <textarea name="article_text" cols="50" rows="15" ><?php echo $content; ?></textarea><br />
                    <h4>Choose an image for this article (<i>optional</i>):</h4>
                    <div id="image_wrap">
                        <?php
                            $fullImageSrc = "/images/blank.gif";
                            
                            $queryImagesResult  = mysql_query("select id, name from images");

                            while($rowImages = mysql_fetch_array($queryImagesResult))
                            {
                                $imgId   = $rowImages['id'];
                                $imgName = $rowImages['name'];
                                echo "<img id='$imgId' src='/data/photos/$imgName' />";
                                
                                if ($imgId == $image_id) {
                                    $fullImageSrc = "/data/photos/" . $imgName;
                                }
                            }
                        ?>
                    </div>
                    <img class="img_indent" id="full_image" src=<?php echo $fullImageSrc; ?> />
                    <input id="edit_article_clear_image" type="button" value="Clear Image" onClick="clearImage()" />
                    <input name="edit_article_submit" id="edit_article_submit" type="submit" value="Submit" />
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
                <?php } else { ?>          
                    <h3>Edit article</h3>
                    <table class="sortable" border="1">
                        <tr>
                            <th></th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Date Created</th>
                            <th>Date Last Modified</th>                    
                        </tr>
                    <?php
                        $queryGetArticle = mysql_query("select id, category, title, author, " . 
                                                   "date_format(create_date, '%m/%d/%Y') as create_date, " .
                                                   "date_format(modify_date, '%m/%d/%Y') as modify_date " . 
                                                   "from articles order by id");

                        while ($rowGetArticle = mysql_fetch_array($queryGetArticle)) {
                            $category    = htmlspecialchars($rowGetArticle['category']);                        
                            $title       = htmlspecialchars($rowGetArticle['title']);
                            $author      = htmlspecialchars($rowGetArticle['author']);                            
                            $create_date = htmlspecialchars($rowGetArticle['create_date']);
                            $modify_date = htmlspecialchars($rowGetArticle['modify_date']);                            
                            $id          = htmlspecialchars($rowGetArticle['id']);
                    ?>   
                        <tr>
                            <td><a href="edit_article.php?id=<?php echo $id; ?>" >Edit</a></td>
                            <td><?php echo $category; ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $author; ?></td>
                            <td><?php echo $create_date; ?></td>                            
                            <td><?php echo $modify_date; ?></td>                          
                        </tr>
                    <?php
                        }
                    ?>
                    </table>
                <?php } ?>   
            </form>
        </div>
    </body>
</html>
