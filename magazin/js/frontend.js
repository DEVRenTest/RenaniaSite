$(document).ready(function() {

    $('.list-cum li a').click(function(e) {
        e.preventDefault();

        $('.list-cum li').removeClass('selected');
        $(this).parent().addClass('selected');

        $('.tab_content').hide();
        var selected_tab = $(this).attr('href');

        $(selected_tab).show();

        return false;
    });


    $(".comuni-tabs li a").click(function(e) {
        e.preventDefault();

        $(".tab_content").hide();
        var selected_tab = $(this).attr("href");

        $('.content').removeAttr('id');
        $('.content').attr('id', selected_tab.replace('#', '') + 'bg');

        $(selected_tab).show();

        return false;
    });


    function initialize() {
        var mapOptions = {
            zoom: 18
        };
        map = new google.maps.Map(document.getElementById("map-canvas"),
                mapOptions);
        var marker = new google.maps.Marker({
            map: map,
            title: "Renania"
        });
        $('.info-text strong:first').click();
    }
    if(typeof google !== 'undefined'){
        google.maps.event.addDomListener(window, 'load', initialize);
    }

    $('.info-text strong').click(function() {
        $('.harta .address').hide();
        $('.harta .address.'+$(this).attr('id')).show();
        
        switch ($(this).attr('id')) {
            case 'targu-mures':
                coords_x = 46.524224;
                coords_y = 24.548065;
                title = 'Renania Bucuresti';
                break;
            case 'bucuresti':
                coords_x = 44.5156945;
                coords_y = 26.0810515;
                title = 'Renania Targu Mures';
                break;
            case 'timisoara':
                coords_x = 45.8078317;
                coords_y = 21.2573428;
                title = 'Renania Timisoara';
                break;
            case 'iasi':
                coords_x = 47.1974979;
                coords_y = 27.4042798;
                title = 'Renania Iasi';
                break;
            case 'craiova':
                coords_x = 44.313055;
                coords_y = 23.7896222;
                title = 'Renania Craiova';
                break;
        }


        var location = new google.maps.LatLng(coords_x, coords_y);
        map.setCenter(location);
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: title
        });
    });

    $('map area').mouseover(function (){
        $('.menu-button.'+$(this).attr('id')).toggleClass('hover');
    }).mouseout(function (){
        $('.menu-button').removeClass('hover');
    });

});
