tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,|,search,replace,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "hr,|,sub,sup,|,charmap,iespell,|,print,|,spellchecker,|,pagebreak",
        
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	width : "640px",
	content_css : "/css/style.css",
        theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
        font_size_style_values : "10px,12px,13px,14px,16px,18px,20px"
});

$(function(){
    
    // Tabs
    $('#tabs').tabs();


    // Dialog			
    $('#dialog').dialog({
	autoOpen: false,
	width: 600,
	buttons: {
	    "Ok": function() { 
	        $(this).dialog("close"); 
	    }, 
	    "Cancel": function() { 
	        $(this).dialog("close"); 
	    } 
	}
    });

    // Dialog Link
    $('#dialog_link').click(function(){
	$('#dialog').dialog('open');
	return false;
    });

    // Datepicker
    $('#datepicker').datepicker({
	inline: true
    });

    // Slider
    $('#slider').slider({
	range: true,
	values: [17, 67]
    });

    // Progressbar
    $("#progressbar").progressbar({
	value: 20 
    });

    //hover states on the static widgets
    $('#dialog_link, ul#icons li').hover(
	function() { $(this).addClass('ui-state-hover'); }, 
	function() { $(this).removeClass('ui-state-hover'); }
    );

});