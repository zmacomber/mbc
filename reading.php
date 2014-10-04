<?php 

    // Database connection
    require("database.php");
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

 <head>
  <title>Reading</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/layout.css" rel="stylesheet" type="text/css" />
  <link href="/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="/jquery-ui-1.8.18.custom/js/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js"></script>
  <script type="text/javascript" src="/javascripts/main.js"></script> 
   <script>
	$(function() {
		$( "#accordion" ).accordion({
			collapsible: true,
			navigation: true,
			active: false,
			autoHeight: false
		});
	});
	</script>
	<style>
	    #accordion {
	        text-align: left;
	        float: left;
	    }
	</style>
 </head>

 <body id="page1">
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
            <div>
            	<?php
            	   $category = "All";
            	   $query = "select id, title from articles ";  	   
            	   if (isset($_GET["category"])) {
            	      $category = $_GET["category"];
            	      $query = $query . " where category = '" . $_GET["category"] . "'";
            	   }
            	   $queryArticleLinks = mysql_query($query . " order by title");
            	?>
            	<b><?php echo $category; ?> articles list:</b>
                <ul>
                    <?php
                        while($rowArticleLinks = mysql_fetch_array($queryArticleLinks))
                        {
                    ?>
                            <li style="padding-top:5px;text-align:left">
                                <div tabindex="0" style="cursor:pointer" onclick="getReadingArticle(<?php echo $rowArticleLinks['id']; ?>)" onkeypress="getReadingArticle(<?php echo $rowArticleLinks['id']; ?>)"> 
                                   <u><?php echo $rowArticleLinks['title']; ?></u>
                                </div>
                            </li>
                    <?php } ?>
                </ul>
            </div>
       </div>  
       </div>
        <div class="col_2 maxheight">
         <!-- <span style="float:left; padding:0 0 0 15px;"><img src="images/reading.png" alt="" /></span> -->
         <span style="float:right"><b>Categories:</b></span><br />
         <?php
         	$queryResult = mysql_query("select distinct category from articles order by category desc");
               
                while($row = mysql_fetch_array($queryResult))
                {
            ?>
                <a href="reading.php?category=<?php echo $row['category']; ?>" style="float:right; margin-left:5px"><?php echo $row['category']; ?></a>
            <?php } ?>
            <a href="reading.php" style="float:right; margin-left:5px">All</a>
            <br /><br />
         <div id="article_content" class="indent">          
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