<?php
    // Database connection
    require("database.php");
?>

<div id="header">
    <h1><a href="index.php">Midcoast Baptist Church Administration Page</a></h1>
</div>


<!-- Menu -->
<div id="sidebar">
    <div>
        <h3>Articles</h3>
        <ul>
            <li><a href="create_article.php">Create article</a></li>
            <li><a href="edit_article.php">Edit article</a></li>
            <li><a href="delete_article.php">Delete article</a></li>
        </ul>
    </div>
    <div>
        <h3>Images</h3>
        <ul>
            <li><a href="upload_image.php">Upload image</a></li>
            <li><a href="delete_image.php">Delete image</a></li>
        </ul>
    </div>
    <div>
        <h3>News</h3>
        <ul>
            <li><a href="create_news.php">Create news entry</a></li>
            <li><a href="delete_news.php">Delete news entry</a></li>
        </ul>
    </div>
    <div>
        <h3>Media</h3>
        <ul>
            <li><a href="upload_media.php">Upload media</a></li>
            <li><a href="delete_media.php">Delete media</a></li>
        </ul>
    </div>
</div>
