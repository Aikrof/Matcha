<!DOCTYPE HTML>

<html lang="en">
   
   
    <head>

        <!-- META -->
        <meta charset="utf-8">
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <!-- PAGE TITLE -->
        <title>{{isset($title) ? $title : env('APP_NAME')}}</title>

        <!-- FAVICON -->
        <!-- <link rel="shortcut icon" href="assets/img/favicon.png"> -->

        <!-- FONTS -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Bellefair&amp;subset=latin-ext" rel="stylesheet"> -->

        <!-- STYLESHEETS -->
        <link rel="stylesheet" type="text/css" href="/css/default_plugin.css">
        <link rel="stylesheet" type="text/css" href="/css/default.css">


    </head>


    <body>

    <header>

        <!-- PRELOADER -->
        <div class="preloader">
           
            <div class="bounce"></div>
            
        </div>
        <!-- /PRELOADER -->
        
        <!-- NAVIGATION BUTTON -->
        <div class="navigation-button">

             <a href="/{{ucfirst(strtolower(Auth::user()->login))}}"><p class="i"><i class="fa fa-info" aria-hidden="true"></i></p></a>
        </div>
        @yield('i')
        <!-- /NAVIGATION BUTTON -->


        <!-- HERO -->
        <div class="hero">


            <!-- FRONT CONTENT -->
            <div class="front-content">
                   
                <a href="/"><img src="img/logo.png" class="img-responsive logo" alt="logo"></a>
                <h1>We make your love</h1>

            </div>
            <!-- /FRONT CONTENT -->


        </div>
        <!-- /HERO -->
    </header>

        <!-- CONTENT -->
        <div class="container">
            @yield('content')
        </div>
        <!-- /CONTENT -->
        
        <!-- FOOTER -->
        <div class="footer">
            
            
            <!-- FOOTER INNER -->
            <div class="footer-inner">
      
                <p>© 2017 Your Brand | Design by <a href="https://templatefoundation.com">Template Foundation</a></p>
                
                <!-- SOCIAL ICONS -->
                <ul class="social-icons scroll-animated-from-right">

                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>

                </ul>
                <!-- /SOCIAL ICONS -->

            
            </div>
            <!-- /FOOTER INNER -->
            

        </div>
        <!-- /FOOTER -->


        <!-- JAVASCRIPTS -->
        <script type="text/javascript" src="js/default_plugin.js"></script>
        <script type="text/javascript" src="js/default.js"></script>


    </body> 
    
</html>