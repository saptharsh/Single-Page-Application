$(document).tooltip();

$(document).ajaxStart(function () {
    $('#loading-ajax').show();
});

$(document).ajaxStop(function () {
    $('#loading-ajax').hide();
});

$(document).ajaxError(function (event, jqxhr, settings, thrownError) {
    $('#loading-ajax').hide();
    alertify.error("<li>Error requesting page " + settings.url + "</li>");
});

$(document).ready(function () {
    var menuLeft = document.getElementById('cbp-spmenu-s1'), 
        showLeftPush = document.getElementById('showLeftPush'), 
        body = document.body;
        
    showLeftPush.onclick = function () {
        classie.toggle(this, 'active');
        /* Body is being pushed to left, check component.css */
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
    };

    /* On Click, the Above JS function is performed */
    $('#cbp-spmenu-s1 > a').click(function () {
        showLeftPush.click();
    });

    /* On Page Reload, the loader image is shown. Which is hidden after 1 second */
    $('#loading-ajax').show();
    setTimeout("$('#loading-ajax').hide();", 1000);
    
    /*
     * Chef's View
     */
    $('#get-chefs-view').click(function (event) {

        $('#container-slider').hide();

        $('#showLeftPush').html('&nbsp;<i class="fa fa-bars"></i>&nbsp; Home Made Food - Chef\'s');
        $('#showLeftPush').prop('title', 'Chef\'s');

        $.ajax({
            type: "POST",
            cache: false,
            url: "./GetChefView.php",
            data: {
                chef_id: -1,
                page_start: 20
            },
            beforeSend: function () {
                $("#main-container").html('');
            },
            complete: function () {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertify.error("Error (" + event.target.id + "): " + errorThrown);
            },
            success: function (data)
            {
                $("#main-container").html(data);
            }
        });
    });

    $('#get-food-items-view').click(function (event) {

        $('#container-slider').hide();

        $('#showLeftPush').html('&nbsp;<i class="fa fa-bars"></i>&nbsp; Food item\'s');
        $(document).prop('title', 'Home Made Food - Food item\'s');

        $.ajax({
            type: "POST",
            cache: false,
            url: "./GetFoodItemsView.php",
            data: {},
            beforeSend: function () {
                $("#main-container").html('');
            },
            complete: function () {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertify.error("Error (" + event.target.id + "): " + errorThrown);
            },
            success: function (data)
            {
                $("#main-container").html(data);
            }
        });
    });

    $('#get-kitchens-view').click(function (event) {

        $('#container-slider').hide();

        $('#showLeftPush').html('&nbsp;<i class="fa fa-bars"></i>&nbsp; Kitchen\'s');
        $(document).prop('title', 'Home Made Food - Kitchen\'s');

        $.ajax({
            type: "POST",
            cache: false,
            url: "./GetKitchensView.php",
            data: {},
            beforeSend: function () {
                $("#main-container").html('');
            },
            complete: function () {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertify.error("Error (" + event.target.id + "): " + errorThrown);
            },
            success: function (data)
            {
                $("#main-container").html(data);
            }
        });
    });

    $('#get-menu-view').click(function (event) {

        $('#container-slider').hide();

        $('#showLeftPush').html('&nbsp;<i class="fa fa-bars"></i>&nbsp; Today\'s Menu');
        $(document).prop('title', 'Home Made Food - Today\'s Menu');

        $.ajax({
            type: "POST",
            cache: false,
            url: "./GetMenuView.php",
            data: {},
            beforeSend: function () {
                $("#main-container").html('');
            },
            complete: function () {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertify.error("Error (" + event.target.id + "): " + errorThrown);
            },
            success: function (data)
            {
                $("#main-container").html(data);
            }
        });
    });

    $('#get-orders-view').click(function (event) {

        $('#container-slider').hide();

        $('#showLeftPush').html('&nbsp;<i class="fa fa-bars"></i>&nbsp; Customer Orders');
        $(document).prop('title', 'Home Made Food - Customer Orders');

        $.ajax({
            type: "POST",
            cache: false,
            url: "./GetOrdersView.php",
            data: {},
            beforeSend: function () {
                $("#main-container").html('');
            },
            complete: function () {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertify.error("Error (" + event.target.id + "): " + errorThrown);
            },
            success: function (data)
            {
                $("#main-container").html(data);
            }
        });
    });


    $('#get-send-notification-view').click(function (event) {

        $('#container-slider').hide();

        $('#showLeftPush').html('&nbsp;<i class="fa fa-bars"></i>&nbsp; Customer Orders');
        $(document).prop('title', 'Home Made Food - Send notification');

        $.ajax({
            type: "POST",
            cache: false,
            url: "./SendNotificationView.php",
            data: {},
            beforeSend: function () {
                $("#main-container").html('');
            },
            complete: function () {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertify.error("Error (" + event.target.id + "): " + errorThrown);
            },
            success: function (data)
            {
                $("#main-container").html(data);
            }
        });
    });

});





