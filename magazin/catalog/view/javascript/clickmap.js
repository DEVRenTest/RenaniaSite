/*
   ClickMap jQuery Plugin
   http://www.jaysalvat.com/
*/

(function($) { 

$.fn.saveClicks = function() { 
    $(this).bind('mousedown.clickmap', function(evt) { 
        $.post(click_url, {  
            x:evt.pageX,  
            y:evt.pageY,
            //width:$(window).width(),
            //height:$(window).height(),
            width:screen.width,
            height:screen.height,
            l:escape(document.location.pathname) 
        });
    }); 
}; 
 
$.fn.stopSaveClicks = function() { 
     $(this).unbind('mousedown.clickmap'); 
}; 

$.displayClicks = function(settings) { 
    $('<div id="clickmap-overlay"></div>').appendTo('body'); 
    $('<div id="clickmap-loading"></div>').appendTo('body'); 
    $.get(display_click_url, { l:escape( document.location.pathname),width:screen.width,height:screen.height },  
        function(html) { 
            $(html).appendTo('body');     
            $('#clickmap-loading').remove(); 
        } 
    ); 
}; 
 
$.removeClicks = function() {
    $('#clickmap-overlay').remove(); 
    $('#clickmap-container').remove(); 
}; 
         
})(jQuery); 