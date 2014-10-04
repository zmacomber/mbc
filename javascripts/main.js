var articleSplit = 1000;
var revealed     = articleSplit;
var fullArticle  = "";
var splitText    = "....<a style='cursor:pointer;tabindex:0' onClick=\"readMore('article')\">Read More</a><span style='display:none'>";

$(document).ready(function() {
    if (document.title.indexOf("Home") == -1) {
        
        // Display a random background image at each page
        var maxVal = 14; //represents number of images to choose from
        var randVal = Math.random() * maxVal;
        $("#header .row_2").css("background-image","url(/images/img" + Math.round(randVal) + ".png)");
    }
    
    highlightCurrentMenuChoice();    
    
    setMenuFade();
    
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

function displaySubMenu(elem, e) {
    var charCode;
    
    if(e && e.which){
        charCode = e.which;
    }else if(window.event){
        e = window.event;
        charCode = e.keyCode;
    }

    if(charCode == 13) {
        if ($(elem).next().css('display') == 'none') {
            $(elem).next().css('display','block');
        } else {
            $(elem).next().css('display','none');
        }
    }
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

function setMenuFade() {
    
    $('.menu').children('li').hover(
        function () {
            $(this).children('ul').fadeIn(250);
        },
        function () {
            $(this).children('ul').fadeOut(250);
        }
    );
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