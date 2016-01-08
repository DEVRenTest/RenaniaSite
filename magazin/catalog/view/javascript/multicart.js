$(document).ready(function() {
    var cart_id = 0;
    $('#get_cart_save_form').on('click', function(){
        console.log('get_cart_save_form');
        var default_cart_data_error = false;
        $('.default_cart > tr').each(function() {

            if ($(this).attr('ax_code').length < 1){
                default_cart_data_error = true;
                alert($(this).find(".name").find("a").html()+" nu are ax code");
            }
        });

        if (!default_cart_data_error) {
            console.log('shhow it');
            $('#save_new_cart_popup').show();
        }

    });

    $('.close_popup').on('click', function(){
        //$('#save_new_cart_popup').closest('div').hide();
        $(this).closest('.popup_background').hide();
    });

    /*$('.popup_background').on('click', function(){
        $(this).hide();
    });*/

    $('.ask_activate_cart').on('click', function(){
        console.log('activate cart '+$(this).attr('cart_id'));
        var cart_id = $(this).attr('cart_id');
        $("html, body").animate({ scrollTop: 0 });
        $.ajax({
            url: 'index.php?route=checkout/cart/check_if_default_cart_not_empty',
            type: 'POST',
            async: false,
            success: function (response) {
                console.log('default cart status ' + response);
                if(jQuery.parseJSON(response) === 'not_empty'){
                    $('#popup_activate_saved_cart').show();

                    $('#dont_save_default_cart').on('click', function(){
                        clear_default_cart();
                        activate_saved_cart(cart_id);
                    });

                    $('#get_save_default_cart').on('click', function(){
                        console.log('show save form');
                        $(this).parent('div').next('#save_new_cart_form').show();
                        $(this).closest('.popup_container').css('height','160px');

                        $('#save_new_cart_before_clear_btn').on('click', function() {
                            console.log('save before clear cart name: '+$(this).prev('input').attr('value'));
                            var cart_name = $(this).prev('input').attr('value');
                            $.ajax({
                                url: 'index.php?route=checkout/cart/save_cart',
                                type: 'POST',
                                async: false,
                                data: {cart_name:cart_name, dont_redirect:'true'},
                                success: function (response) {
                                    console.log('cart saved success');
                                    clear_default_cart();     //--------------------------------------------------------------------------
                                    //var obj = jQuery.parseJSON(response);
                                    activate_saved_cart(cart_id);

                                },
                                error: function (response) {
                                }
                            });
                        });
                    });
                } else {
                    activate_saved_cart(cart_id);
                }
                //var obj = jQuery.parseJSON(response);

            },
            error: function (response) {
                console.log('function error ' + response);
            }
        });
    });

    function activate_saved_cart(cart_id) {
        $.ajax({
            url: 'index.php?route=checkout/cart/get_axcodes_and_quantitys',
            type: 'post',
            async: false,
            data: {cart_id: cart_id},
            dataType: 'json',
            success: function(axcodes_and_quantitys) {
                $.each(axcodes_and_quantitys, function(i, item){
                    add_to_default_cart(axcodes_and_quantitys[i].ax_code, axcodes_and_quantitys[i].quantity, cart_id);
                });
                console.log('saved cartDDDD added to default');
                //location.reload();
                delete_saved_cart(cart_id)

            },
            error: function(json){

            }
        });
    }

    function delete_saved_cart(cart_id) {
        console.log('will be deleted');
        $.ajax({
            url: 'index.php?route=checkout/cart/delete_cart&cart_id='+cart_id,
            type: 'get',
            async: false,
            success: function() {

                console.log('activated cart deleted');
                location.reload(); //href="http://b2b.renania.ro/index.php?route=checkout/cart/delete_cart&cart_id=66
            },
            error: function(){

            }
        });
    }

    function clear_default_cart() {
        $.ajax({
            url: 'index.php?route=checkout/cart/clear_cart',
            type: 'POST',
            async: true,
            success: function (response) {
                console.log('empty cart success');
            },
            error: function (response) {
                console.log('empty cart failed');
            }
        });
    }

    $("#default_cart tr:not(.disabled), .saved_cart tr:not(.disabled)").draggable({
        helper: 'clone',
        revert: 'invalid',
        start: function (event, ui) {
            //$(this).css('opacity', '.5');
            //var ax_code = $(this).attr('ax_code');
        },
        stop: function (event, ui) {
            //$(this).css('opacity', '1');
        }
    });

    $("#default_cart, .saved_cart").droppable({
        drop: function (event, ui) {

            var redirect = false;
            var target_cart = $(this);
            var ax_code = ui.draggable.attr("ax_code");
            var attr = ui.draggable.attr('cart'); // cart_id if come from saved cart
            var target_saved_cart = false;

            console.log('ccart id '+attr);

            if($(this).hasClass("saved_cart")) {
                var target_cart_id = $(this).find('tbody').attr('id');
                target_saved_cart = true

                console.log('target saved cart ' + target_cart_id);
            } else {
                console.log('target default '+attr);
                if (typeof attr === typeof undefined) {
                    return;
                }
            }

            if (target_saved_cart && target_cart_id == attr) { // if both cart is the same saved cart do nothing
                return;
            }

            if (typeof attr !== typeof undefined && attr !== false) { // product come from saved cart

                var from_default_cart = false;
                delete_from_saved_cart(attr, ax_code);
                console.log('from saved cart '+from_default_cart+' '+attr);

            } else { // product come from default cart

                //console.log('dddd '+target_cart.find('tbody').attr('class'));

                if ($(this).hasClass("default_cart")) { // if both cart is the same default cart do nothing
                    return;
                }

                var from_default_cart = true;
                console.log('from default cart '+from_default_cart);

            }
            var new_quantity = parseInt(ui.draggable.find(".quantity").find("input").val());

            if (target_cart.find("[ax_code="+ax_code+"]").length){ // increase quantity if product exist in target cart

                var exist_quantity = parseInt(target_cart.find("[ax_code=" + ax_code + "]").find(".quantity").find("input").val());

                var final_quantity = exist_quantity + new_quantity;
                target_cart.find("[ax_code=" + ax_code + "]").find(".quantity").find("input").attr('value', final_quantity);

                console.log("product exist "+target_cart.find("[ax_code="+ax_code+"]")+' new quantity: '+new_quantity+' exist quantity: '+exist_quantity);
                $(ui.draggable).remove();

                if(from_default_cart) {
                    var remove_link = ui.draggable.find(".quantity").find("a").attr('href');
                    console.log('delete from cart '+remove_link);
                    delete_from_default_cart(remove_link);
                }

                update_saved_cart(target_cart_id, ax_code, final_quantity, 'update');

                redirect = true;

            } else { // add new product to cart

                if(target_saved_cart) {
                    console.log('target saved cart ' + $(this).find('tbody').attr('id') + ' new product data: '+ax_code);
                    update_saved_cart(target_cart_id, ax_code, new_quantity, 'insert');
                } else {
                    add_to_default_cart(ax_code, new_quantity);
                }

                if(from_default_cart) {
                    var remove_link = ui.draggable.find(".quantity").find("a").attr('href');
                    //console.log('delete from Default cart '+remove_link);
                    delete_from_default_cart(remove_link);
                } else {
                    console.log('delete from saved cart: cart_id '+attr+' ax_code '+ax_code);
                    delete_from_saved_cart(attr, ax_code);
                }

                $(ui.draggable).appendTo(this);

                $(this).find("[ax_code="+ax_code+"]").attr('cart', target_cart_id);
                console.log("new product");

                redirect = true;
            }

            //console.log('class '+$(this).attr('class'));

            console.log('coming '+ax_code);

            if (redirect == true) {
                location.reload();
            }
        }

    });

    function delete_from_saved_cart(cart_id, ax_code) {
        //console.log('in func delete_from_saved_cart: cart_id '+cart_id+' ax_code '+ax_code);
        $.ajax({
            url: 'index.php?route=checkout/cart/delete_from_saved_cart',
            type: 'POST',
            async: false,
            data: {ax_code: ax_code, cart_id: cart_id},
            dataType: 'json',
            success: function (response) {
                //console.log('success delete_from_saved_cart ' + response + " id");
                //var obj = jQuery.parseJSON(response);
                location.reload();
            },
            error: function (response) {
                //console.log("error delete_from_saved_cart " + response);
            }
        });
    }

    function add_to_default_cart(ax_code, quantity, cart_id) {
        console.log('new product to default cart '+cart_id);

        var product_to_add = "";

        $.ajax({
            url: 'index.php?route=checkout/cart/get_option_data',
            type: 'post',
            async: false,
            data: {ax_code: ax_code},
            dataType: 'json',
            success: function(json) {

                console.log(json.product_id);

                $.ajax({
                    url: 'index.php?route=checkout/cart/add',
                    type: 'post',
                    async: false,
                    data: {product_id:json.product_id, option:json.option, quantity:quantity, cart_id:cart_id},
                    dataType: 'json',
                    success: function(json) {
                        $('.success, .warning, .attention, information, .error').remove();

                        if (json['error']) {
                            if (json['error']['option']) {

                                if(!jQuery.isEmptyObject(json['error']))
                                {
                                    $('.option-combo-warning').html('<span class="error">Selectati cel putin 1 optiune!</span>');
                                }

                                for (i in json['error']['option']) {
                                    $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
                                }
                            }

                            if (json['error']['profile']) {
                                $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                            }
                        }

                        if (json['success']) {
                            $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                            $('.success').fadeIn('slow');

                            $('#cart-total').html(json['total']);

                            $('html, body').animate({ scrollTop: 0 }, 'slow');
                        }
                    }
                });
            }
        });
    }

    function delete_from_default_cart(remove_link) {
        $.ajax({
            url: 'index.php?route=checkout/cart/delete_from_default_cart',
            type: 'POST',
            async: false,
            data: { remove_link: remove_link} ,
            dataType: 'json',
            success: function (response) {
                console.log('deleted from default cart '+response+ " id");
                //var obj = jQuery.parseJSON(response);
                if (response) {
                    //alert('Success '+response);
                }
            },
            error: function (response) {
                console.log("error delete from default cart "+response);
            }
        });
    }

    $('.saved_update_btn').on('click', function() {
        var ax_code = $(this).closest('tr').attr('ax_code');
        var cart_id = $(this).closest('tr').attr('cart');
        var quantity = $(this).prev().attr('value');

        if(typeof(ax_code) != "undefined" && ax_code !== null && typeof(cart_id) != "undefined" && cart_id !== null && typeof(quantity) != "undefined" && quantity !== null) {
            $.ajax({
                url: 'index.php?route=checkout/cart/update_saved_cart_product_quantity',
                type: 'POST',
                async: false,
                data: {ax_code: ax_code, cart_id: cart_id, quantity:quantity},
                dataType: 'json',
                success: function (response) {
                    console.log('Updated saved cart product quantity ' + response + " id");
                    //var obj = jQuery.parseJSON(response);
                    location.reload();

                },
                error: function (response) {
                    console.log("Quantity update failed " + response);
                }
            });
        }
    });

    $('.saved_delete_product_btn').on('click', function() {
        var ax_code = $(this).closest('tr').attr('ax_code');
        var cart_id = $(this).closest('tr').attr('cart');

        if(typeof(ax_code) != "undefined" && ax_code !== null && typeof(cart_id) != "undefined" && cart_id !== null) {
            delete_from_saved_cart(cart_id, ax_code);
        }
    });

    $('.ask_delete_saved_cart').on('click', function() {
        $(this).next('.confirm_delete_saved_cart').show();
        $(this).hide();
    });

    $('.dont_delete_saved_cart').on('click', function() {
        $(this).parent().prev('.ask_delete_saved_cart').show();
        $(this).parent('.confirm_delete_saved_cart').hide();
    });

    $('.update_saved_cart_name_btn').on('click', function() {
        var cart_new_name = $(this).prev('.saved_cart_name').attr('value');
        var cart_id = $(this).prev('.saved_cart_name').attr('cart');
        var btn_id = $(this).attr('id');
        console.log('asdvsdv '+btn_id);

        if(cart_new_name.length > 2){
            $.ajax({
                url: 'index.php?route=checkout/cart/update_saved_cart_name',
                type: 'POST',
                async: false,
                data: { cart_id: cart_id, cart_new_name : cart_new_name} ,
                dataType: 'json',
                success: function (response) {
                    //var obj = jQuery.parseJSON(response);
                    if (response) {
                        console.log('Success name updated '+response);
                        $('#'+btn_id).next('.error').remove();
                        $('#'+btn_id).next('.success').show();
                    } else {
                        console.log('Update2 '+response);
                    }

                },
                error: function (response) {
                    console.log("Cart name update error "+response);
                }
            });
        } else {
            $('#'+btn_id).next('.success').hide();
            $('#'+btn_id).after('<span class="error" style="margin-left: 10px;">Numele cosului trebuie sa contine cel putin 3 caractere!</span>');
        }

    });

    function update_saved_cart(cart_id, ax_code, quantity, action) {

        console.log('js update_saved_cart before ajax |cart_id| '+cart_id+' |ax_code| '+ax_code+' |quantity| '+quantity+' |action| '+action);

        if(cart_id.length > 1&& ax_code.length > 1 && action.length > 1) {
            console.log(cart_id + ' ' + ax_code + ' ' + quantity + ' ' + action);
            $.ajax({
                url: 'index.php?route=checkout/cart/update_saved_cart',
                type: 'POST',
                async: false,
                data: {cart_id: cart_id, ax_code: ax_code, quantity: quantity, action: action},
                dataType: 'json',
                success: function (response) {
                    //var obj = jQuery.parseJSON(response);
                    if (response) {
                        console.log('Success ' + response);
                        return 'product_added_to_saved_cart';
                    } else {
                        console.log('Update2 ' + response);
                    }

                },
                error: function (response) {
                    console.log("error " + response);
                }
            });
        } else {
            console.log('js update_saved_cart error |cart_id| '+cart_id+' |ax_code| '+ax_code+' |quantity| '+quantity+' |action| '+action);
        }
    }

    $('.support_direct').click(function(){

        console.log($(this).closest('.cart-total').next().attr('id'));
        //console.log($(this).closest('.cart-total').next().is(":visible"));

        if ($(this).closest('.cart-total').next().is(":visible")) {

            console.log('hide '+$(this).closest('.cart-total').next().attr('id'));

            $(this).closest('.cart-total').next().hide();
            $(this).closest('.cart-total').next().next('form').hide();

        } else {

            console.log('show '+$(this).closest('.cart-total').next().attr('id'));

            $(this).closest('.cart-total').next().show();
            $(this).closest('.cart-total').next().next('form').show();
        }

    });

    $('input[name=\'filter_model\']').on('change', function(){
        cart_id = $(this).closest('.support_search_form').attr('id');
    });

    $('input[name=\'filter_name\']').on('change', function(){
        cart_id = $(this).closest('.support_search_form').attr('id');
    });

    var option = [];
    /*$('input[name=\'filter_model\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=account/account/autocomplete&filter_model=' +  encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item.model,
                            product_id: item.product_id,
                            product_name: item.name,
                            model: item.model,
                            option: item.option
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('#'+cart_id+'support_name').attr('value',ui.item.product_name);
            $('#'+cart_id+'support_quantity').attr('disabled', true);
            $('#'+cart_id+'support_product_id').attr('value',ui.item.product_id);
            console.log('from mmodel insert product id '+ui.item.product_id);

            handle_options(cart_id, ui.item.product_name, ui.item.product_id, ui.item.model, ui.item.option);
        },
        focus: function(event, ui) {
            return false;
        }
    });*/

    /*$('input[name=\'filter_name\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=account/account/autocomplete&filter_name=' +  encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item.name,
                            product_id: item.product_id,
                            product_name: item.name,
                            model: item.model,
                            option: item.option
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('.support_model > input').attr('value',ui.item.model);
            $('.support_quantity > input').attr('disabled', true);
            $('#support_product_id').attr('value',ui.item.product_id);
            console.log('from name insert product id '+ui.item.product_id);

            handle_options(ui.item.product_name, ui.item.product_id, ui.item.model, ui.item.option);
        },
        focus: function(event, ui) {
            return false;
        }
    });*/

    $('.support_color > select').change(function() {
        //console.log($(this).attr('name'));
        //var product_option_value_id = $('.support_color > select > option:selected').val();
        var product_option_value_id = $(this).val();
        if(product_option_value_id > 0) {
            if (cart_id < 1) {
                cart_id = $(this).closest('.support_search_form').attr('id');
            }
            $('.support_quantity > input').attr('value','');
            $('.support_total_price > div').html('');
            var color_product_option_id = $('#color_product_option_id').val();
            console.log('option array '+ product_option_value_id);
            $(this).css('background','#FFF');
            call_live_price_update(cart_id);
        } else {
            $('.support_color > select').css('background','#F0EE4E');
        }
    });

    $('.support_size > select').on('change' ,function() {
        //console.log($(this).attr('name'));
        var product_option_value_id = $(this).val();
        if(product_option_value_id > 0) {
            if (cart_id < 1) {
                cart_id = $(this).closest('.support_search_form').attr('id');
            }
            $('.support_quantity > input').attr('value','');
            $('.support_total_price > div').html('');
            var size_product_option_id = $('#size_product_option_id').val();
            console.log('option array '+ product_option_value_id);
            $(this).css('background','#FFF');
            call_live_price_update(cart_id);
        } else {
            $('.support_size > select').css('background','#F0EE4E');
        }
    });

    $('input[name=quantity]').keyup('change' ,function(event) {
        var product_option_value_id = $('#'+cart_id+'support_quantity').val();
        if(product_option_value_id > 0) {
            console.log('quantity OK');
            call_live_price_update(cart_id);
        } else {
            console.log('quantity WRONG');
            $('.support_total_price > div').html('');
            $('#add_to_fast_order_list_btn').hide();
        }
    });

    function handle_options(cart_id, product_name, product_id, model, option_data){
        $('.support_color > #'+cart_id+'color_product_option_value_id').prop('disabled', true);
        $('.support_color > #'+cart_id+'color_product_option_value_id').css('background','#CCC');
        $('.support_color > #'+cart_id+'color_product_option_value_id').find('option').remove().end();
        $('.support_size > #'+cart_id+'size_product_option_value_id').prop('disabled', true);
        $('.support_size > #'+cart_id+'size_product_option_value_id').css('background','#CCC');
        $('.support_size > #'+cart_id+'size_product_option_value_id').find('option').remove().end();

        $('#add_to_fast_order_list_btn').hide();

        console.log('delete options');
        $('#'+cart_id+'color_product_option_id').removeAttr('value');
        $('#'+cart_id+'color_product_option_value_id').attr('name','support_color');
        $('#'+cart_id+'size_product_option_id').removeAttr('value');
        $('#'+cart_id+'size_product_option_value_id').attr('name','support_size');
        $('#'+cart_id+'support_quantity').removeAttr('value');
        $('#'+cart_id+'support_total_price').html('');

        $('.support_price > div').html('');

        if(option_data.length > 0) {
            $.each(option_data, function(key, value) {
                if(value.option_id == '2'){ // If have color option
                    $('.support_color').show();
                    $('#color_product_option_id').attr('value',value.product_option_id);
                    $('.support_color > #'+cart_id+'color_product_option_value_id').prop('disabled', false);
                    $('.support_color > #'+cart_id+'color_product_option_value_id').attr('name','option['+value.product_option_id+']');
                    $('.support_color > #'+cart_id+'color_product_option_value_id').css('background','#F0EE4E');
                    $('.support_color > #'+cart_id+'color_product_option_value_id').append('<option>'+value.place_holder+'</option>');
                }
                if(value.option_id == '1'){ // If have size option
                    $('.support_size').show();
                    $('#size_product_option_id').attr('value',value.product_option_id);
                    $('.support_size > #'+cart_id+'size_product_option_value_id').prop('disabled', false);
                    $('.support_size > #'+cart_id+'size_product_option_value_id').attr('name','option['+value.product_option_id+']');
                    $('.support_size > #'+cart_id+'size_product_option_value_id').css('background','#F0EE4E');
                    $('.support_size > #'+cart_id+'size_product_option_value_id').append('<option>'+value.place_holder+'</option>');
                }
            });
            $.ajax({
                url: 'index.php?route=account/account/getProductOptions&product_id=' +  encodeURIComponent(product_id),
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(key, value) {
                        if(value.option_id == 1) {
                            $.each(value.option_value, function (key, option) {
                                $('.support_size > select').attr('data-product_option_id',value.product_option_id);
                                $('.support_size > select').append('<option value="' + option.product_option_value_id + '">' + option.name + '</option>');
                            });
                        }

                        if(value.option_id == 2) {

                            $.each(value.option_value, function (key, option) {
                                $('.support_color > select').attr('data-product_option_id',value.product_option_id);
                                $('.support_color > select').append('<option value="' + option.product_option_value_id + '">' + option.name + '</option>');
                            });
                        }
                    });
                }
            });
        } else {
            $('.support_quantity > input').attr('disabled', false);
            call_live_price_update(product_id, option_data);
        }

        return false;
    }

    function call_live_price_update(cart_id) {
        console.log('call_live 2 price_update '+$('#'+cart_id+' > div > .support_model > input[name^="product_id"]')+ ' Option_data: '+$('select[name^="option"]'));

        $.ajax({
            type: 'post',
            url: 'index.php?route=myoc/fast_order_live_price_update',
            dataType: 'json',
            data: $('input[id="'+cart_id+'support_product_id"], .'+cart_id+'options, input[id="'+cart_id+'support_quantity"]'),
            success: function (json) {
                console.log(json);
                if ( json.customer_group_id == 3 || json.customer_group_id == 4) // B2B client
                {
                    if (json.have_b2b_price != 0)  //&& myocData.b2b_product_stoc != 0
                    {
                        $('#'+cart_id+'support_price').text(json.price_and_text);
                    }
                    $('#'+cart_id+'support_stoc').find('div').text(json.b2b_product_stoc);
                    $('#'+cart_id+'support_quantity').find('input').attr('disabled', false);
                } else {
                    $('#'+cart_id+'support_price').find('div').text(json.price_and_text);
                    $('#'+cart_id+'support_price').find('#price_with_tax').text(json.price_with_tax);
                    $('#'+cart_id+'support_stoc').find('div').text(json.stoc);
                }
                $('#'+cart_id+'support_quantity').attr('disabled', false);
                if($('#'+cart_id+'support_quantity').val() > 0){
                    $('#'+cart_id+'support_total_price').text(json.total_price_and_text);
                    $('#'+cart_id+'support_total_price').find('input[name=total_price]').attr('value',json.total_price);
                    $('#'+cart_id+'support_total_price').find('input[name=currency]').attr('value',json.currency);

                    $('#fast_order_search_button_container > a').show();
                }
            }
        });
    }

    $('.new_support_direct_btn').on('click', function(){
        cart_id =$(this).attr('data-cart_id');
        //var cart_id = $(this).prev().prev().prev().prev().prev().attr('value');
        var subject = $('#'+cart_id+'support_subject').attr('value');
        var message = $('#'+cart_id+'support_message').attr('value');
        var subject_ok, message_ok = false;

        console.log('support cart '+cart_id);

        console.log('subject '+subject);
        console.log('message '+message);

        if (subject.length < 3 || subject.length > 250) {
            $(this).prev().prev().prev().show();
            subject_ok = false;
        } else {
            $(this).prev().prev().prev().hide();
            subject_ok = true;
        }

        if (message.length < 3 || message.length > 250) {
            $(this).prev().show();
            message_ok = false;
        } else {
            $(this).prev().hide();
            message_ok = true;
        }

        if (cart_id && subject_ok && message_ok) {

            console.log('idaig joooo');
            var data = $('#'+cart_id+'support_direct_body').serialize();
            
            $.ajax({
                url: 'index.php?route=checkout/cart/new_support_content',
                type: 'POST',
                async: false,
                data: data,
                dataType: 'json',
                success: function (response) {
                    //var obj = jQuery.parseJSON(response);
                    console.log('new_support_content response '+response);

                    console.log('Success1 '+response);

                    $('#'+cart_id+'support_sent').show();
                    $('#'+cart_id+'support_subject').val("");
                    $('#'+cart_id+'support_message').val("");

                    $('#'+cart_id+'support_model').val("");
                    $('#'+cart_id+'support_name').val("");
                    $('#'+cart_id+'color_product_option_value_id').prop('disabled', 'disabled');
                    $('#'+cart_id+'color_product_option_value_id').empty();
                    $('#'+cart_id+'size_product_option_value_id').prop('disabled', 'disabled');
                    $('#'+cart_id+'size_product_option_value_id').empty();
                    $('#'+cart_id+'support_price').empty();
                    $('#'+cart_id+'support_quantity').val("");
                    $('#'+cart_id+'support_total_price').empty();

                    var new_msg = '<div class="support_message">';
                        new_msg += '<div class="support_culomn_left"></div>';
                        new_msg += '<div class="support_culomn_right active_msg">';
                        new_msg +=      '<div class="support_head">';
                        new_msg +=          '<div class="customer_name">'+response.sender+'</div>';
                        new_msg +=          '<div class="date_added"> - '+response.date_time+' - </div>';
                        new_msg +=      '</div>';
                        new_msg +=      '<div class="support_content supp3">';
                        new_msg +=          '<p>'+response.support_subject+'</p>';
                        new_msg +=          '<p>'+response.support_message+'</p>';
                    if (response.product_name)
                    {
                         new_msg +=        '<form id="_cart_support_product" class="cart_support_product">';
                         new_msg +=              '<div class="cart_support_product_name">';
                         new_msg +=                  '<p>'+response.product_name+'</p>';
                         new_msg +=                  '<div class="cart_support_product_option">';

                         if (response.option.length > 0)
                         {
                             $.each(response.option, function(i, item){
                                 new_msg +=                      '<p><small> -  '+response.option[i].name+' </small>: <small>'+response.option[i].value+'</small></p>';
                             });
                         }

                         new_msg +=                  '</div>';
                         new_msg +=              '</div>';
                         new_msg +=              '<div class="cart_support_product_model">'+response.product_model+'</div>';
                         new_msg +=              '<div class="cart_support_product_quantity">';
                         new_msg +=                  '<input type="text" name="quantity" value="'+response.quantity+'">';
                         new_msg +=              '</div>';
                         new_msg +=              '<div class="cart_support_price"></div>';
                         new_msg +=              '<div class="asked_sup_pr_to_cart"></div>';
                         new_msg +=          '</form>';
                    }

                        new_msg +=      '</div>';
                        new_msg +=     '</div>';
                        new_msg += '</div>';
                    console.log('appednd support');
                    $('#'+cart_id+'_support_container').append(new_msg);

                },
                error: function (response) {
                    console.log("error "+response);
                    console.log('wrong return respons '+response);
                    $('#'+cart_id+'support_sent').show();
                }
            });
        } else {
            console.log('support send wrong');
        }
    });

    $('.add_customer_to_support_btn').on('click', function(){
        var cart_id = $(this).attr('data-cart_id');
        var customer_to_support = $('#'+cart_id+'_customer_to_support_select').val();

        if(!customer_to_support) {

            $('#'+cart_id+'_client_add_error').show();

        } else {

            $('#'+cart_id+'_client_add_error').hide();
            //alert('cart ID '+cart_id+' customert_to support id '+customer_to_support);

            $.ajax({
                url: 'index.php?route=checkout/cart/add_customer_to_support',
                type: 'POST',
                async: false,
                data: {cart_id:cart_id, customer_to_support:customer_to_support},
                success: function (response) {
                    //var obj = jQuery.parseJSON(response);
                    if (response == "customer_added") {
                        console.log('Success '+response);
                        $('#'+cart_id+'_client_added_success').show();
                    } else {
                        console.log('Update2 '+response);
                    }

                },
                error: function (response) {
                    console.log("error "+response);
                }
            });
        }
    });

    $('.sup_pr_to_cart_btn').on('click', function(){
        var cart_id = $(this).attr('id');
        var ax_code = $(this).attr('ax_code');
        var cart_support_id = $(this).attr('cart_support_id');
        var cart_support_msg_id = $(this).attr('cart_support_msg_id');
        var quantity = $('#'+cart_support_msg_id+'quantity').attr('value');

        console.log('cart_id '+cart_id+' ax_code '+ax_code+' cart_support_id '+cart_support_id+' cart_support_msg_id '+cart_support_msg_id);

        var response = "";

        if ($('tbody#'+cart_id).find("[ax_code="+ax_code+"]").length > 0) { // If product exist in saved cart
            response = update_saved_cart(cart_id, ax_code, quantity, "update");
            console.log('sup_pr_to_cart_btn update call update_saved_cart '+response);
        } else {
            response = update_saved_cart(cart_id, ax_code, quantity, "insert");
            console.log('sup_pr_to_cart_btn insert call update_saved_cart '+response);
        }

        //add_support_history(cart_support_id, cart_id, 'added_to_saved_cart', ax_code);

        if (response == "product_added_to_saved_cart") {
            console.log('sup_pr_to_cart_btn DD '+response);
        } else {
            console.log('sup_pr_to_cart_btn cc '+response);
        }

        location.reload();

    });

    /*
    function add_support_history(cart_support_id, cart_id, action, ax_code) {
        $.ajax({
            url: 'index.php?route=checkout/cart/add_support_history',
            type: 'post',
            async: false,
            data: {cart_support_id: cart_support_id, cart_id: cart_id, action: action, ax_code: ax_code},
            dataType: 'json',
            success: function(json) {
                //$('.success, .warning, .attention, .information, .error').remove();
            }
        });
    }
    */

    $('.activated_sup_pr_to_cart_btn').on('click', function(){
        var cart_id = $(this).attr('id');
        var ax_code = $(this).attr('ax_code');
        var quantity = $('#'+cart_id+'quantity').attr('value');

        var response = "";

        if ($('tbody#'+cart_id).find("[ax_code="+ax_code+"]").length > 0) { // If product exist in saved cart
            response = update_saved_cart(cart_id, ax_code, quantity, "update");
        } else {
            response = update_saved_cart(cart_id, ax_code, quantity, "insert");
        }

        add_to_default_cart(ax_code, quantity);

        location.reload();

        /*if (response == "product_added_to_saved_cart") {
            console.log('sup_pr_to_cart_btn DD '+response);
        } else {
            console.log('sup_pr_to_cart_btn cc '+response);
         }*/

    });

    $('#default_ask_sup_from_btn').on('click', function(){

        var default_cart_data_error = false;
        $('.default_cart > tr').each(function() {

            if ($(this).attr('ax_code').length < 1){
                default_cart_data_error = true;
                alert($(this).find(".name").find("a").html()+" nu are ax code");
            }
        });

        if (!default_cart_data_error) {
            if ($("#default_support_form").is(":visible")) {
                $('#default_support_form').hide();
            } else {
                $('#default_support_form').show();
            }
        }

    });

    $('#save_def_and_sup_btn_submit').on('click', function(){
        console.log('clickeeed');
        var default_support_form_error = false;

        if ($('#default_support_form #cart_name').attr('value').length < 3 || $('#default_support_form #cart_name').attr('value').length > 100) {
            default_support_form_error = true;
            $('#default_support_form #cart_name_length_error').show();
            console.log('show it');
        } else {
            $('#default_support_form #cart_name_length_error').hide();
            console.log('hide it');
        }

        if ($('#default_support_form #support_subject').attr('value').length < 3 || $('#default_support_form #support_subject').attr('value').length > 100) {
            default_support_form_error = true;
            $('#default_support_form #support_subject_length_error').show();
            console.log('show it support_subject_length_error');
        } else {
            $('#default_support_form #support_subject_length_error').hide();
            console.log('hide it support_subject_length_error');
        }

        if ($('#default_support_form #support_message').attr('value').length < 15 || $('#default_support_form #support_message').attr('value').length > 100) {
            default_support_form_error = true;
            $('#default_support_form #support_message_length_error').show();
            console.log('show it support_message_length_error '+$('#default_support_form #support_message').attr('value').length);
        } else {
            $('#default_support_form #support_message_length_error').hide();
            console.log('hide it support_message_length_error');
        }

        //default_support_form_error = true;

        if(!default_support_form_error) {
            var default_support_form_data = $('#default_support_form').serialize();
            console.log('SEND default_support_form_data');

            $.ajax({
                url: 'index.php?route=checkout/cart/save_cart',
                type: 'post',
                async: false,
                data: default_support_form_data,
                success: function(response) {
                    $('.success, .warning, .attention, .information, .error').remove();
                    location.reload();
                    //alert(response);
                }
            });
        }
    });

    function cart_page_addToCart(product_id, quantity) {

        quantity = typeof(quantity) != 'undefined' ? quantity : 1;

        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            async: false,
            data: 'product_id=' + product_id + '&quantity=' + quantity,
            dataType: 'json',
            success: function(json) {
                $('.success, .warning, .attention, .information, .error').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                }

                if (json['success']) {
                    $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                    $('.success').fadeIn('slow');

                    $('#cart-total').html(json['total']);

                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                }
            }
        });
    }
});