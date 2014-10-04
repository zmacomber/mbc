<?php 

    // Database connection
    require("database.php");
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

 <head>
  <title>Media</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/layout.css" rel="stylesheet" type="text/css" />
  <link href="/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="/jquery-ui-1.8.18.custom/js/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js"></script>
  <script type="text/javascript" src="/javascripts/main.js"></script> 
 </head>

 <body id="page3">
  <div id="site_center">
   <div id="main">

    <!-- header -->
    <script language="JavaScript" type="text/javascript" src="javascripts/header.js"></script>

    <!-- content -->
    <div id="content" style="width:780px;">
     <div class="indent">
      <div class="wrapper">
       <div class="wrapper_bottom">
        <div class="wrapper_top">
            <div class="col_1">
                <label for="category">Category:</label>
            	<select name="category" onchange="displayCategory(this.value);">
            	    <option value="all">All</option>
            	    <?php
            	        $query = mysql_query("select distinct category from media where path not like '%.mp3' order by category"); 
            	        while ($results = mysql_fetch_array($query)) {
            	            $category = $results['category'];
            	    ?>
            	    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
            	    <?php } ?>
            	</select>
        </div>
        <div class="col_2 maxheight">
            <h3 style="float:left;border:1px solid #777;background-color:#345;padding:5px;color:#def">Video</h3>       
            <div class="all" style="margin-top:40px;">
            <?php
    	        $queryMedia = mysql_query("select category, title, path from media where path not like '%.mp3' order by title"); 
    	        $prev_category = "";
    	        echo "<div>";
    	        while ($resultsMedia = mysql_fetch_array($queryMedia)) {
    	            $category = $resultsMedia['category'];
    	            $title    = $resultsMedia['title'];
    	            $path     = $resultsMedia['path'];
    	            
    	            if ($prev_category != $category) {
    	                echo "</div>\n";

    	                echo "<div class='{$category}' style='clear:both;float:left;'>\n";
    	            }
    	            
    	            echo "<span style='white-space:nowrap;clear:both;float:left;'><a href='{$path}'>{$title}</a></span><br />\n";                     
    	            
    	            $prev_category = $category;
    	        }
    	        echo "</div>\n";
    	    ?>
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
  <script type="text/javascript" src="http://mediaplayer.yahoo.com/js"></script>
 </body>
</html>