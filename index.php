<?php 
    // Database connection
    require("database.php");

    $queryResult = mysql_query("select id, title, category, author, image_id, content, date_format(create_date,'%W, %b %d, %Y') AS article_date from articles where put_on_home_page = 'Y'");
    $image_id    = "";
    $content     = "";
   
    $row        = mysql_fetch_array($queryResult);
    $image_id   = $row['image_id'];
    $title      = $row['title'];
    $category   = $row['category'];
    $author     = $row['author'];
    $content    = $row['content'];
    $article_date = $row['article_date'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

 <head>
  <title>Midcoast Baptist Church Home Page</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/layout.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="/javascripts/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="/javascripts/jquery.vticker.js"></script>
  <script type="text/javascript" src="/javascripts/main.js"></script>
  <style type="text/css">
    .news { 
        text-align:left;
        margin-left:60px;
     }
  </style>
 </head>

 <body id="page1" onLoad="displayFirstPartOfArticle('article');">
  <div id="site_center">
   <div id="main">

    <!-- header -->
    <script language="JavaScript" type="text/javascript" src="javascripts/header.js"></script>

    <!-- content -->
    <div id="content" style="width:900px;">
     <div class="indent">
      <div class="wrapper">
       <div class="wrapper_bottom">
        <div class="wrapper_top">
         <div class="col_1">
          <div class="indent">
            <img class="title" alt="" src="images/churchnews.png" />
            <div class="news">
            <ul>
            <?php
                $queryNewsResult = mysql_query("select date_format(event_date, '%m/%d/%Y') as event_date, event_desc " . 
                                               "from news where event_date between now() and date_add(now(),interval 3 month) order by event_date");
                
                while ($newsRow = mysql_fetch_array($queryNewsResult)) {
            ?>
                <li style="font-size:14px;">
                    <?php echo $newsRow['event_date']; ?><br /><b><?php echo $newsRow['event_desc']; ?></b><br /><br />
                </li>
            <?php } ?>
            </ul>
           </div>
          </div>
         </div>
         <div class="col_2 maxheight">
          <div class="indent">
           <img class="title" alt="" src="images/wordsoftruth.png" /><br />
           <?php if ($image_id != "") { 
                $queryImage     = mysql_query("select name from images where id = " . $image_id);
                $rowImageResult = mysql_fetch_array($queryImage);
           ?>
                <div style="position:relative"><img id="article_image" alt="" src="/data/photos/<?php echo $rowImageResult['name']; ?>" /></div>
           <?php } ?>
           <div id="article" class="article" <?php if ($image_id == "") { ?> style="margin-left:0" <?php } ?> >
                <h5><?php echo $article_date; ?></h5><br />
                <h3><?php echo $title; ?></h3><br />
                <h4><?php echo $author; ?></h4><br />
                <?php echo $content; ?>
           </div>
           <div style="float:right; text-align:right;">
                <span>Category: <?php echo $category; ?></span><br />
                <a href="reading.php">Other Articles</a>
           </div>
          </div>
         </div>
         <div class="clear"></div>
        </div>
       </div>
      </div>
     </div>
    </div>

    <!-- footer -->
    <script language="JavaScript" type="text/javascript" src="javascripts/footer.js"></script>
   </div>
  </div>	
 </body>
</html>
