var offer = { multiple : 1 };

$(document).ready(function() {
    height = $('.mainPanel').height();
    $('.sidebar').height(height);
    $('.details').hide();
    $('.productName').bind('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().parent().next().toggle(150);
    });
    $('.advancedSearchButton').bind('click', function() {
        $('.advancedSearchNavigation').toggle('fast');
    });
    /* $('.selectFilter').selectbox();
    $('.productSelect').selectbox(); */
    $('.sidebar a').hover(function() {
        if ($(this).hasClass('collapseLnk')) {
            $(this).parent().parent().css({'background-color': '#323232'});
        } else {
            $(this).children('.sidebutton').css({'background-color': '#323232'});
        }
    });
    $('.sidebar a').mouseleave(function() {
        if ($(this).hasClass('collapseLnk')) {
            $(this).parent().parent().css({'background-color': '#161616'});
        } else {
            $(this).children('.sidebutton').css({'background-color': '#161616'});
        }
    });
    $('.arrow').hide();

    var str = location.href.toLowerCase();
    $(".sidebar a").each(function() {
        if (str.indexOf(this.href.toLowerCase()) > -1) {
            $("div.panel-collapse").removeClass("in");
            $(this).parent().parent().addClass("in");
        }
    });
    $('.delete-row').bind('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this row?')) {
            var _this = $(this);
            $.ajax({
                url: _this.attr('href'),
                dataType: 'JSON'
            }).done(function(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                    var parent = _this.parent().parent();
                    parent.next().remove();
                    parent.remove();
                }
            });
        }
    });
    var options = {
        source: function(request, response) {
            $.ajax({
                url: "/backend/menus/ajax_get_for_menus",
                dataType: "json",
                data: {
                    featureClass: "P",
                    style: "full",
                    maxRows: 12,
                    q: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.title,
                            url: item.url
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $(this).parent().next().find('input.url').val(ui.item.url);
        },
        open: function() {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function() {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    };
    $(".typeahead").on('keydown.autocomplete', function() {
        $(this).autocomplete(options);
    });
    $(".sortable").sortable();
    
    $('.add_element').bind('click', function(e) {
        var _new = $('.mainPanel').find('.to_replicate').clone();
        _new.removeClass('to_replicate').addClass('replica').appendTo('.sortable').show();
        _new.find('.typeahead').on('keydown.autocomplete', function() {
            $(this).autocomplete(options);
        });
        $('.remove_item').bind('click', function(e) {
            e.stopImmediatePropagation();
            if (confirm('Are you sure you want to delete this item?'))
                $(this).parent().remove();
        });
    });
    $('.remove_item').bind('click', function(e) {
        e.stopImmediatePropagation();
        if (confirm('Are you sure you want to delete this item?'))
            $(this).parent().remove();
    });
	
	// languages
    $('.language span').click(function(e) {
        $('.language-field').hide();
        $('.'+$(this).parent().attr('id')).show();
        $('.language').removeClass('selected');
        $(this).parent().addClass('selected');
    });
	$('.language_add').click(function(e){
		$('.language_add_hidden').show();
	});
	$('.language_add_btn').bind('click',function(e){ 
		var _l = $('.langs-select').val();
		$('.languages #language-' + _l).removeClass('hide');
		$('input[name=langs]').val($('input[name=langs]').val() + ',' + _l );
	});
	$('.remove-lang').bind('click',function(e) {
		$(this).parent().addClass('hide');
		var _rel = $(this).attr('rel');
		var my_langs = $('input[name=langs]').val().split(',');
		var index = jQuery.inArray( _rel, my_langs);
		my_langs.splice(index, 1);
		var lang_string = my_langs.join(',');
		$('input[name=langs]').val(lang_string);
	});
	$('.tabs .tabs-item').bind('click',function(e){
		var _id = $(this).attr('id');
		$(this).parent().find('.tabs-item').removeClass('selected');
		$(this).addClass('selected');
		$('.tab').addClass('hide');
		$('.tab.'+_id).removeClass('hide');
	});
	$('.add_schedule').bind('click', function(e){
		$('.modal_day').text($(this).attr('id'));
		$('#schedule_modal').find('input[name=obj]').val('');
		$('#schedule_modal').modal('show');
	});
	$('.add_multiple_days').bind('click', function(e){
		$('#schedule_multiple_modal').find('input[name=obj]').val('');
		$('#schedule_multiple_modal').modal('show');
	});
	
	var multiple = offer.multiple;
	$('.save_schedule').bind('click',function(e) {
		var departure_time = $('#schedule_modal').find('input[name=departure_time]').val();
		var vehicle_id = $('#schedule_modal').find('input[name=vehicle_id]').val();
		var return_time = $('#schedule_modal').find('input[name=return_time]').val();
		if( $('#schedule_modal').find('input[name=obj]').val() !== '' ) {
			var id = $('#schedule_modal').find('input[name=obj]').val();
			var obj = $('#'+id);
			obj.find('.departure_time').find('input').val(departure_time); 
			obj.find('.vehicle').find('input').val(vehicle_id);
			obj.find('.return_time').find('input').val(return_time);
		} else {
			var html = "<li class='single' id='single-"+multiple+"'>";
			if( departure_time ) {
				html+="<span class='day_span departure_time'>Departure time: <input type='text' readonly='true' class='noinput' name='departure_time["+multiple+"]' value='"+departure_time+"' /></span></span>";
			}
			if( vehicle_id ) {
				html+="<span class='day_span vehicle'>Vehicle <input type='text' readonly='true' class='noinput' name='vehicle_id["+multiple+"]' value='"+vehicle_id+"' /></span>";
			}
			if( return_time ) {
				html+="<span class='day_span return_time'>Return time <input type='text' readonly='true' class='noinput' name='return_time["+multiple+"]' value='"+return_time+"' /></span>";
			}
			html+="<input type='hidden' name='departure_day["+multiple+"]' value='"+$('.modal_day').text()+"' />";
			html+="<input type='hidden' name='return_day["+multiple+"]' value='"+$('.modal_day').text()+"' />";
			html+= "</li>";
			
			$('td.'+$('.modal_day').text() + ' ul').append(html);
			$('.delete_schedule').bind('click', function(e){
				e.preventDefault();
				e.stopImmediatePropagation();
				var id = $('#schedule_modal').find('input[name=obj]').val();
			
				var obj = $('#'+id);
				obj.remove();
				$('#schedule_modal').modal('hide');
				$(this).addClass('hide');
			});
			$('ul.day_list li.single').bind('click', function(e) {
				e.stopImmediatePropagation();
				// single schedule
				var id = $(this).attr('id');
				$('#schedule_modal').find('input[name=obj]').val(id);
				$('#schedule_modal').find('.departure_time').val($(this).find('span.departure_time').find('input').val());
				$('#schedule_modal').find('.vehicle_id').val($(this).find('span.vehicle').find('input').val());
				$('#schedule_modal').find('.return_time').val($(this).find('span.return_time').find('input').val());
				$('#schedule_modal').modal('show');
				$('.delete_schedule').removeClass('hide');
			});
		}
		$('#schedule_modal').modal('hide');
		multiple++;
	});
	$('ul.day_list li.single').bind('click', function(e) {
		e.stopImmediatePropagation();
		// single schedule
		//console.log($(this).find('span.departure_time').find('input').val());
		var id = $(this).attr('id');
		$('#schedule_modal').find('input[name=obj]').val(id);
		$('#schedule_modal').find('.departure_time').val($(this).find('span.departure_time').find('input').val());
		$('#schedule_modal').find('.vehicle_id').val($(this).find('span.vehicle').find('input').val());
		$('#schedule_modal').find('.return_time').val($(this).find('span.return_time').find('input').val());
		$('#schedule_modal').modal('show');
		$('.delete_schedule').removeClass('hide');
	});
	$('.save_schedule_multiple').bind('click',function(e) {
		var departure_day = $('#schedule_multiple_modal').find('input[name=departure_day]:checked').val();
		var return_day = $('#schedule_multiple_modal').find('input[name=return_day]:checked').val();
		
		var departure_time = $('#schedule_multiple_modal').find('input[name=departure_time]').val();
		var vehicle_id = $('#schedule_multiple_modal').find('input[name=vehicle_id]').val();
		var return_time = $('#schedule_multiple_modal').find('input[name=return_time]').val();
		if( $('#schedule_multiple_modal').find('input[name=obj]').val() !== '' ) {
			var id = $('#schedule_multiple_modal').find('input[name=obj]').val();
			
			var idarr = id.split('-');
			var obj = $('#'+id);
			var other = $('#'+idarr[1]+'-'+idarr[0]+'-'+idarr[2]);

			obj.find('.departure_time').find('input').val(departure_time); 
			obj.find('.vehicle').find('input').val(vehicle_id);
			obj.find('.return_time').find('input').val(return_time);
			other.find('.departure_time').find('input').val(departure_time); 
			other.find('.vehicle').find('input').val(vehicle_id);
			other.find('.return_time').find('input').val(return_time);
			
		} else {
			var html_departure = "<li class='multiple departure' id='"+departure_day+"-"+return_day+"-"+multiple+"'>";
			var html_return = "<li class='multiple return' id='"+return_day+"-"+departure_day+"-"+multiple+"'>";
			if( departure_time ) {
				html_departure+="<span class='day_span departure_time'>Departure time: <input type='text' readonly='true' class='noinput' name='departure_time["+multiple+"]' value='"+departure_time+"' /></span>";
				html_return+="<span class='day_span departure_time hide'>Departure time: <input type='text' readonly='true' class='noinput' name='departure_time["+multiple+"]' value='"+departure_time+"' /></span>";
			}
			if( vehicle_id ) {
				html_departure+="<span class='day_span vehicle'>Vehicle <input type='text' readonly='true' class='noinput' name='vehicle_id["+multiple+"]' value='"+vehicle_id+"' /></span>";
				html_return+="<span class='day_span vehicle'>Vehicle <input type='text' readonly='true' class='noinput' name='vehicle_id["+multiple+"]' value='"+vehicle_id+"' /></span>";
			}
			if( return_time ) {
				html_return+="<span class='day_span return_time'>Return time <input type='text' readonly='true' class='noinput' name='return_time["+multiple+"]' value='"+return_time+"' /></span>";
				html_departure+="<span class='day_span return_time hide'>Return time <input type='text' readonly='true' class='noinput' name='return_time["+multiple+"]' value='"+return_time+"' /></span>";
			}
			html_departure+="<input type='hidden' name='departure_day["+multiple+"]' value='"+departure_day+"' />";
			html_departure+="<input type='hidden' name='return_day["+multiple+"]' value='"+return_day+"' />";
			html_return+="<input type='hidden' name='departure_day["+multiple+"]' value='"+departure_day+"' />";
			html_return+="<input type='hidden' name='return_day["+multiple+"]' value='"+return_day+"' />";
			
			html_departure+="</li>";
			html_return+="</li>";
		
			$('td.'+departure_day + " ul ").append(html_departure);
			$('td.'+return_day  + " ul ").append(html_return);
		}
		$('#schedule_multiple_modal').modal('hide');
		$('.delete_schedule_multiple').bind('click', function(e){
			e.preventDefault();
			e.stopImmediatePropagation();
			var id = $('#schedule_multiple_modal').find('input[name=obj]').val();
			
			var idarr = id.split('-');
			var obj = $('#'+id);
			var other = $('#'+idarr[1]+'-'+idarr[0]+'-'+idarr[2]);
			obj.remove();
			other.remove();
			$('#schedule_multiple_modal').modal('hide');
			$(this).addClass('hide');
		});
		$('ul.day_list li.multiple').bind('click', function(e) {
			e.stopImmediatePropagation();
			// multiple schedule
			if( $(this).hasClass('departure')) {
				var id = $(this).attr('id');
				var idarr = id.split('-');
				var return_obj = $('#'+idarr[1]+'-'+idarr[0]+'-'+idarr[2]);
				$('#schedule_multiple_modal').find('input[name=obj]').val(id);
				$('#schedule_multiple_modal').find(':radio[name=departure_day][value='+idarr[0]+']').prop('checked',true);
				$('#schedule_multiple_modal').find(':radio[name=return_day][value='+idarr[1]+']').prop('checked',true);
				$('#schedule_multiple_modal').find('.departure_time').val($(this).find('span.departure_time').find('input').val());
				$('#schedule_multiple_modal').find('.vehicle_id').val($(this).find('span.vehicle').find('input').val());
				$('#schedule_multiple_modal').find('.return_time').val(return_obj.find('span.return_time').find('input').val());
				$('#schedule_multiple_modal').modal('show');
			} else {
				var id = $(this).attr('id');
				var idarr = id.split('-');
				var return_obj = $('#'+idarr[1]+'-'+idarr[0]+'-'+idarr[2]);
				$('#schedule_multiple_modal').find('input[name=obj]').val(id);
				$('#schedule_multiple_modal').find(':radio[name=departure_day][value='+idarr[1]+']').prop('checked',true);
				$('#schedule_multiple_modal').find(':radio[name=return_day][value='+idarr[0]+']').prop('checked',true);
				$('#schedule_multiple_modal').find('.departure_time').val(return_obj.find('span.departure_time').find('input').val());
				$('#schedule_multiple_modal').find('.vehicle_id').val(return_obj.find('span.vehicle').find('input').val());
				$('#schedule_multiple_modal').find('.return_time').val($(this).find('span.return_time').find('input').val());
				$('#schedule_multiple_modal').modal('show');
			}
			$('.delete_schedule_multiple').removeClass('hide');
		});
		multiple++;
	});
	$('ul.day_list li.multiple').bind('click', function(e) {
		e.stopImmediatePropagation();
		// multiple schedule
		if( $(this).hasClass('departure')) {
			var id = $(this).attr('id');
			var idarr = id.split('-');
			var return_obj = $('#'+idarr[1]+'-'+idarr[0]+'-'+idarr[2]);
			$('#schedule_multiple_modal').find('input[name=obj]').val(id);
			$('#schedule_multiple_modal').find(':radio[name=departure_day][value='+idarr[0]+']').prop('checked',true);
			$('#schedule_multiple_modal').find(':radio[name=return_day][value='+idarr[1]+']').prop('checked',true);
			$('#schedule_multiple_modal').find('.departure_time').val($(this).find('span.departure_time').find('input').val());
			$('#schedule_multiple_modal').find('.vehicle_id').val($(this).find('span.vehicle').find('input').val());
			$('#schedule_multiple_modal').find('.return_time').val(return_obj.find('span.return_time').find('input').val());
			$('#schedule_multiple_modal').modal('show');
		} else {
			var id = $(this).attr('id');
			var idarr = id.split('-');
			var return_obj = $('#'+idarr[1]+'-'+idarr[0]+'-'+idarr[2]);
			//console.log(return_obj);
			$('#schedule_multiple_modal').find('input[name=obj]').val(id);
			$('#schedule_multiple_modal').find(':radio[name=departure_day][value='+idarr[1]+']').prop('checked',true);
			$('#schedule_multiple_modal').find(':radio[name=return_day][value='+idarr[0]+']').prop('checked',true);
			$('#schedule_multiple_modal').find('.departure_time').val(return_obj.find('span.departure_time').find('input').val());
			$('#schedule_multiple_modal').find('.vehicle_id').val(return_obj.find('span.vehicle').find('input').val());
			$('#schedule_multiple_modal').find('.return_time').val($(this).find('span.return_time').find('input').val());
			$('#schedule_multiple_modal').modal('show');
		}
		$('.delete_schedule_multiple').removeClass('hide');
	});
	$('#gallery.dropzone .image_preview').sortable({
		items: '.dz-preview'
	});
	
	var options = {
        source: function(request, response) {
            $.ajax({
                url: "/backend/offers/ajax_get_for_request",
                dataType: "json",
                data: {
                    featureClass: "P",
                    style: "full",
                    maxRows: 12,
                    q: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.title,
                            id: item.id,
							days: item.days
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $('.offer_id').val(ui.item.id);
			$('.isdate').datepicker('destroy');
			$('.isdate').datepicker({
				changeMonth: true,
				changeYear: true,
				minDate: 0,
				beforeShowDay: function(date){ 
					if( jQuery.inArray( date.getDay().toString(), ui.item.days ) < 0 )
						return [false,""];
					else
						return [true,""];
				}
			});
        },
        open: function() {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function() {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    };
    $(".offer_autocomplete").on('keydown.autocomplete', function() {
        $(this).autocomplete(options);
    });
	$('.order-direction').bind('click',function(e){
		if( $('.selectOrder').val() == '' ){
			return false;
		}
		$(this).toggleClass('glyphicon-arrow-down gluphicon-arrow-up');
		var inp = $(this).find('input');
		if( inp.val() == 'asc' ) {
			inp.val('desc');
		} else {
			inp.val('asc');
		}
		$(this).parent().parent().submit();
	});
	$(document).on('change', '.attr_select',function(e){
		var _this = $(this);
		var option = _this.parent().next('label').find('.options_select');
		$.ajax({
			url: "/index.php/backend/products/ajax_get_option",
			type: "POST",
			dataType: "json",
			data: {
				attr: _this.val()
			},
			success: function(data) {
				option.empty();
				option.append('<option value="" rel="">Selecteaza</option>');
				$.each(data, function(index, item) {
					option.append('<option value="'+item.id+'" rel="'+item.value+'">'+item.name+'</option>');
				});
				option.attr('id',_this.find('option:selected').html().toLowerCase())
			}
		});
	});
	$(document).on('change','.options_select',function(e){
		var rel = $(this).find('option:selected').attr('rel');
		var value_field = $(this).parent().next('label').find('.value_field');
		value_field.val(rel);
		value_field.css('background',rel);
	});
});
