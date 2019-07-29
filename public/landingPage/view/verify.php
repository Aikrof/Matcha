<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
             <main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- <div class="card"> -->
 

                <!-- <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif -->

                    <h2>Before proceeding, please check your email for a verification link.</h2>
                    <h3>If you did not receive the email</h3>
                    <p id="resend">click here to request another</p>.
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
  </main>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script type="text/javascript" src="/js/sender.js"></script>
    <script type="text/javascript" src="/landingPage/js/verify.js"></script>
</body>
</html>

