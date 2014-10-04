<?php
    session_start(); 
    $_SESSION['article_created_successfully'] = true;
    header('Location: http://localhost/admin/create_article');
    exit();
?>
