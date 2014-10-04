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
        <title>MBC Administration Delete Article</title>
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
                <?php

                    // check if the "delete" button was pushed
					foreach(array_keys($_POST) as $k) {
						if (strstr($k,"delete"))
						{
						    $article_id = str_replace("delete","",$k);
						    $queryDeleteResult = mysql_query("DELETE FROM articles WHERE id = " . $article_id); 
		
		                    if ($queryDeleteResult) {
                                echo "<span class='ui-state-highlight'>ARTICLE DELETED SUCCESSFULLY</span>";
                            }
                            else {
                                echo "<span class='ui-state-error'>FAILED TO DELETE ARTICLE - PLEASE CONTACT ADMINISTRATOR</span>";
                            }		
						}
                    } 
                     
                ?>
                <h3>Delete article</h3>
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
                        $category           = htmlspecialchars($rowGetArticle['category']);                        
                        $title              = htmlspecialchars($rowGetArticle['title']);
                        $author             = htmlspecialchars($rowGetArticle['author']);                            
                        $create_date        = htmlspecialchars($rowGetArticle['create_date']);
                        $modify_date        = htmlspecialchars($rowGetArticle['modify_date']);                            
                        $id                 = htmlspecialchars($rowGetArticle['id']);
                ?>   
                    <tr>
                        <td><input type="submit" name="delete<?php echo $id; ?>" value="Delete" /></td>
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
            </form>
        </div>
    </body>
</html>

