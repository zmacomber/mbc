var articleSplit = 1000;
var revealed     = articleSplit;
var fullArticle  = "";
var splitText    = "....<a style='cursor:pointer;tabindex:0' onClick=\"readMore('article')\">Read More</a><span style='display:none'>";
var headerBackgroundClassPrefix = "header_background_image_sprite_";
var numBackgroundImages = 14;

$(document).ready(function() {
       
    $("#home").click(function() {

        // Display a random background image
        // Removes last class from background image div which represents the background-position of the header background image sprite
        // Then adds the new background-position class based on a random number from 0 to the number of background images specified above
        var randVal = Math.floor(Math.random() * (numBackgroundImages + 1)) + 0;
        var headerBackgroundElem = $('#header .row_2 .col_2');
        var lastClass = headerBackgroundElem.attr('class').split(' ').pop();
        headerBackgroundElem.removeClass(lastClass).addClass(headerBackgroundClassPrefix + randVal);

    });

    highlightCurrentMenuChoice();    
    
});

function displayCategory(category) {
    
    $('.all').children('div').each(function(index) {
        $(this).css('display','none');
    });
    
    if (category == 'all') {
    	$('.all').children('div').each(function(index) {
    	    $(this).css('display','inline-block');
    	});
    } else {
        $('.' + category).css('display','inline');
    }
    
}

function displayFirstPartOfArticle (articleId) {

    var article = document.getElementById(articleId);    
    fullArticle = article.innerHTML;
    
    article.innerHTML = splitArticle();
}

function getReadingArticle(articleId) {
    $.get('/get_reading_article.php?id=' + articleId,
        function (msg){
            $('#article_content').html(msg);
        }
    );  
}

function highlightCurrentMenuChoice() {

    // Get the current page
    var currentPage = location.pathname.substring(5);
    
    // Remove the "currentMenuItem" class from any li tags that currently have it
    $('.menu').find('li').removeClass('currentMenuItem');
    
    // Add the "currentMenuItem" class to the menu item that the user is currently on
    var menuItem;
    
    switch(currentPage) {
        case "pastors.php" :
        case "doctrine.php" :
            menuItem = "aboutus.php";
            break;
        case "audio.php" :
        case "reading.php" :
            menuItem = "media.php";
            break;
        case "philosophy.php" :
        case "missionaries.php" :
            menuItem = "missions.php";
            break;
        default :
            menuItem = currentPage; // Default the menuItem to the currentPage
    }
    
    $('.menu').find('a[href="' + menuItem + '"]').parent().addClass('currentMenuItem');
    $('.menu').find('a[href="' + menuItem + '"]').css("color","white");
}

function readMore (articleId) {
    
    var article = document.getElementById(articleId);
    
    article.innerHTML = fullArticle;
            
    return false; 
}

function splitArticle() {

    if (revealed >= fullArticle.length) {
        return (fullArticle);
    } else {
        var firstPart = fullArticle.substr(0, revealed);
        var nextPart  = fullArticle.substr(revealed + 1);
        revealed += articleSplit;
        return (firstPart + splitText + nextPart + "</span>");    
    }     
}
