<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home Made Food</title>
        <link rel="stylesheet" type="text/css" href="font-awesome-4.3.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/slidebars.minimal.css"/>
        <link rel="stylesheet" type="text/css" href="css/slider.css"/>
        <link rel="stylesheet" type="text/css" href="css/component.css" />
        <link rel="stylesheet" type="text/css" href="css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
        <link rel="stylesheet" type="text/css" href="css/themes/alertify.core.css" />
        <link rel="stylesheet" type="text/css" href="css/themes/alertify.default.css" id="toggleCSS" />
        <link rel="stylesheet" type="text/css" href="css/homeStyle.css" id="toggleCSS" />
        
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/tablesort.js"></script>
        <script src="js/slider.js"></script>
        <script src="js/modernizr.custom.js"></script>
        <script src="js/classie.js"></script>
        <script src="js/alertify.min.js"></script>
        <script src="js/ajax.js"></script>

        <style type="text/css">
            .contents{
                margin: 20px;
                padding: 20px;
                list-style: none;
                background: #F9F9F9;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .contents li{
                margin-bottom: 10px;
            }

            .loading-div{
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                /*background: rgba(0, 0, 0, 0.56);*/
                z-index: 999;
                display:none;
            }
            /*
            .loading-div img {
                margin-top: 20%;
                margin-left: 50%;
            }
            */
            /* Pagination style */
            .pagination{  
                margin: 10px;
                /*padding-bottom: 10px;*/
                /*padding-top: 10px;*/
            }
            .pagination li{
                display: inline;
                padding: 6px 10px 6px 10px;
                border: 1px solid #ddd;
                /*margin-right: -1px;*/
                font: 15px/20px Arial, Helvetica, sans-serif;
                background: #FFFFFF;
                box-shadow: inset 1px 1px 5px #F4F4F4;
            }
            .pagination li a{
                text-decoration:none;
                color: rgb(89, 141, 235);
            }
            .pagination li.first {
                border-radius: 5px 0px 0px 5px;
            }
            .pagination li.last {
                border-radius: 0px 5px 5px 0px;
            }
            .pagination li:hover{
                background: #CFF;
            }
            .pagination li.active{
                background: #F0F0F0;color: #333;
            }

        </style>


    </head>
    <body>


        <!-- Top header-->
        <header  class="top-nav-bar">
            <!-- <i class="fa fa-bars"></i> => menu symbol -->
            <?php if (4 == 4) : ?> <!-- Replace this with authentication check -->
                <span title="Open/Close Menu" id="showLeftPush" class="menu-img">&nbsp;<i class="fa fa-bars"></i>&nbsp; Home Made Food</span>
            <?php else : ?>
                <span><i class="fa fa-bars"></i>&nbsp; Home Made Food</span>
            <?php endif; ?>

            <!-- Ajax Loader Symbol -->
            <i style="float:right; " id='loading-ajax' class="fa fa-spinner fa-pulse"></i>
        </header>

        <!-- Left navigation menu -->
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <a id='' href="http://localhost:7770/homemadefood/">Home</a>
            <a id='get-send-notification-view' href="#">Notify</a>
            <a id='get-orders-view' href="#">Orders</a>
            <a id='get-menu-view' href="#">Food Menu</a>
            <a id='get-chefs-view' href="#">Chef's</a>
            <a id='get-food-items-view' href="#">Food Items</a>
            <a id='get-kitchens-view' href="#">Kitchens</a>
        </nav>

        <!-- Main content -->
        <div class="box">

            <!-- The data from the Rest service is grabbed and displayed in this container -->
            <div id="main-container">

                <!-- jQuery Slider -->
                <div id="container-slider">

                    <nav class="navi-header" id="">
                        <a id='Home' href="http://localhost:7770/homemadefood/">Home</a>
                        <a id='choices-view' href="#">Choices</a>
                        <a id='contact-view' href="#">Contact</a>
                        <a id='location-view' href="#">Location</a>
                        <a id='help-view' href="#">Help</a>
                        <a id='about-view' href="#">About</a>
                        <a id='branches-view' href="#">Branches</a>
                    </nav>



                    <div id="slider">
                        <div class="slide"><!-- <div class="slide active"> will be inserted through jQuery.min.js -->

                            <div class="slide-copy">

                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
                            </div>
                            <img src="img/slide1.jpg">
                        </div>

                        <div class="slide">

                            <div class="slide-copy">

                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
                            </div>
                            <img src="img/slide2.jpg" alt="slide2">
                        </div>

                        <div class="slide">

                            <div class="slide-copy">

                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
                            </div>
                            <img src="img/slide3.jpg" alt="slide3">
                        </div>

                        <div class="slide">

                            <div class="slide-copy">

                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
                            </div>
                            <img src="img/slide4.jpg" alt="slide4">
                        </div>

                    </div><!-- end of individual slider DIV -->



                </div><!-- End of jQuery slider container -->

                <div class="title">
                    <b>Dish of the Day</b>
                </div>

                <div class="popular-items">

                    <div class="pop-sunday">
                        <img src="img/indian.jpg" alt="butter-chicken">
                    </div>
                    <div class="pop-sunday-desc">
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page 
                            when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal 
                            distribution of letters, as opposed to using 'Content here, content here', making it look like 
                            readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as 
                            their default model text, and a search for 'lorem ipsum' will uncover many web sites still in 
                            their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on 
                            purpose (injected humour and the like).
                        </p>
                    </div>
                </div>

            </div>


        </div><!-- End of box -->
    </body>
</html>
