// JavaScript Document
$(document).ready(function(){
	$('#header > #menu').prepend('<a id="logo" href="http://www.opencart.com/index.php?route=extension/extension&filter_username=Dreamvention" target="_blank"></a>');
	//$('body').prepend('<div class="content-background"></div>');
	$('#header > #menu').wrapInner('<div class="layout"><div class="wrap"></div></div>');
	$('#content > .breadcrumb').wrapInner('<div class="layout"><div class="wrap"></div></div>');
	$('#content .box .heading').wrapInner('<div class="layout"><div class="wrap"></div></div>');
	$('#content .content').wrapInner('<div class="layout"><div class="wrap"></div></div>');
	$('#content .content > .layout > .wrap').prepend('<div id="background_wrap"></div>');
	$('#container #content .box .content .layout ').append('<div class="footer-push"></div>');
	$('#footer').html('© 2013 All rights reserved. Developed by <a href="http://www.opencart.com/index.php?route=extension/extension&filter_username=Dreamvention" target="_blank">Dreamvention</a>');
	
	$('#footer').appendTo('#container #content .box  .content ')
	  
	

})
$(document).ready(function(){
	$('#content').fadeIn(1000)})


var lsTooltip = {

	init : function() {

		jQuery(document).on('mouseover', '[data-help]', function() {

			lsTooltip.open(this);
		});

		jQuery(document).on('mouseout', '[data-help]', function() {
			lsTooltip.close();
		});
	},

	open : function(el) {

		// Create tooltip
		jQuery('body').prepend( jQuery('<div>', { 'class' : 'ls-tooltip' })
			.append( jQuery('<div>', { 'class' : 'inner' }))
			.append( jQuery('<span>') )
		);
        
		// Get tooltip
		var tooltip = jQuery('.ls-tooltip');

		// Set tooltip text
		tooltip.find('.inner').text( jQuery(el).attr('data-help'));

		// Get viewport dimensions
		var v_w = jQuery(window).width();

		// Get element dimensions
		var e_w = jQuery(el).width();

		// Get element position
		var e_l = jQuery(el).offset().left;
		var e_t = jQuery(el).offset().top;

		// Get toolip dimensions
		var t_w = tooltip.outerWidth();
		var t_h = tooltip.outerHeight();

		// Position tooltip
		tooltip.css({ top : e_t - t_h - 10, left : e_l - (t_w - e_w) / 2  });
		// Fix right position
		if(tooltip.offset().left + t_w > v_w) {
			tooltip.css({ 'left' : 'auto', 'right' : 10 });
			tooltip.find('span').css({ left : 'auto', right : v_w - jQuery(el).offset().left - jQuery(el).outerWidth() / 2 - 17, marginLeft : 'auto' });
		}

	},

	close : function() {
		jQuery('.ls-tooltip').remove();
	}
};
lsTooltip.init();