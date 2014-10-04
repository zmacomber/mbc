<?php
    // Database connection
    require("database.php");
    
    // Default the return message that the article wasn't found; will change later if it is found...
    $result = "<h3>Sorry! Article Not Found</h3>";
    
    if (isset($_GET['id'])) {
        $queryArticleResult = mysql_query("select title, category, author, image_id, content, date_format(create_date,'%W, %b %d, %Y') AS article_date from articles where id = " . $_GET['id']);
        $rowArticleResult = mysql_fetch_array($queryArticleResult);
        $image_id = $rowArticleResult['image_id'];
        $title    = $rowArticleResult['title'];
        $category = $rowArticleResult['category'];
        $author   = $rowArticleResult['author'];
        $content  = $rowArticleResult['content'];
        $article_date = $rowArticleResult['article_date'];                          
        
        if ($content != "") {
            $result = "";
            if ($image_id != "") {
                $queryImage     = mysql_query("select name from images where id = " . $image_id);
                $rowImageResult = mysql_fetch_array($queryImage);
                $result = "<div style='position:relative'><img id='article_image' alt='' src='/data/photos/" . $rowImageResult['name'] . "' /></div>";
            }   
            $result = $result . "<div id='article' class='article' ";  
            
            if ($image_id == "") { 
                $result = $result . " style='margin-left:0'"; 
            } 
            
            $result = $result . ">";
            $result = $result . "<h5>" . $article_date . "</h5><br />";
            $result = $result . "<h3>" . $title . "</h3><br />";
            $result = $result . "<h4>" . $author . "</h4><br />";
            $result = $result . $content;
            $result = $result . "</div>";    
        }
    }
    
    echo $result;
?>
