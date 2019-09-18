@extends('layouts.default')

@section('chat')
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

<input id='f' type="text" name="test">
<p class="btn s">Send</p>



<style type="text/css">
	.chat-container {
    height: 25rem;
    min-height: 20rem;
}
@media (max-width: 575px) {
    html {
        font-size: 12px!important;
    }
    .d-xs-none {
        display: none;
    }
}

@media (min-width: 576px) and (max-width: 767px) {
    html {
        font-size: 16px!important;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    html {
        font-size: 18px!important;
    }
}

@media (min-width: 992px) and (max-width: 1199px) {
    html {
        font-size: 20px!important;
    }
}

@media (min-width: 1200px) {
    html {
        font-size: 22px!important;
    }
}
* {
    border-radius: 0px!important;
    border-collapse: collapse;
    box-shadow:none!important;
}

.message-card {
    max-width: 60%;
}
.bg-lightblue{
    background-color:#7CC0FF;
}
.bg-darkblue{
    background-color:#0E5EA9;
}
.bg-lightgrey {
    background-color:#f1f1f1;
}
.search-input-h {
    height: 10%!important;
}

.hover-color-darkblue:hover {
    color:#0E5EA9!important;
}
.hover-color-lightgray:hover {
    color:#dcdcdc!important;
}
.hover-bg-lightgray:hover {
    background-color: #dcdcdc!important;
    cursor:pointer;
}
.active.hover-bg-lightgray:hover {
    background-color: #0E5EA9!important;
    cursor:pointer;
}
.border-chat-lightgray{
    border-style: solid;
    border-width: 1px 0 1px 1px;
    border-color: #dfdfdf!important;
}
.text-white{
    color: white;
}
.message-scroll {
    overflow-y: auto;
}
.sidebar-scroll {
   overflow-y: auto;
}
#sidebar-content {
    display: flex;
    flex-direction: column;
}
#list-group {
    flex: 1 1;
}
::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
  background-color: #F5F5F5;
}

::-webkit-scrollbar {
  width: 12px;
  background-color: #F5F5F5; 
}

::-webkit-scrollbar-thumb {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
  background-image: -webkit-gradient(linear, left bottom, left top, from(#30cfd0), to(#330867));
  background-image: -webkit-linear-gradient(bottom, #30cfd0 0%, #330867 100%);
  background-image: linear-gradient(to top, #30cfd0 0%, #330867 100%); 
}
</style>
<div class="container-fluid chat-container">
    <div class="row h-100">
        <div class="col-3 border-chat-lightgray px-0" id="sidebar">
            <div id="sidebar-content" class="w-100 h-100">
                <div class="input-group p-0 d-xs-none" id="search-group">
                    <input type="text" class="form-control border-0" placeholder="Search..." id="search">
                    <span class="input-group-addon">
                        <button class="btn border-0 bg-white text-primary hover-color-darkblue" type="button">
                            <i class="fa fa-search fa-fw"></i>
                        </button>
                    </span>
                </div>
                <div class="sidebar-scroll" id="list-group">
                    <ul class="list-group w-100" id="friend-list">
                    <li class="list-group-item p-1 active hover-bg-lightgray">
                        <img src="//placehold.it/50x50" class="rounded-circle">
                        <span class="d-xs-none username">StanIsLove</span>
                    </li>
                    <li class="list-group-item p-1 hover-bg-lightgray">
                        <img src="//placehold.it/50x50" class="rounded-circle">
                        <span class="d-xs-none username">Joe</span>
                    </li>
                    <li class="list-group-item p-1 hover-bg-lightgray">
                        <img src="//placehold.it/50x50" class="rounded-circle">
                        <span class="d-xs-none username">Deadpool</span>
                    </li>
                    <li class="list-group-item p-1 hover-bg-lightgray">
                        <img src="//placehold.it/50x50" class="rounded-circle">
                        <span class="d-xs-none username">Wolverine</span>
                    </li>
                    <li class="list-group-item p-1 hover-bg-lightgray">
                        <img src="//placehold.it/50x50" class="rounded-circle">
                        <span class="d-xs-none username">Dave</span>
                    </li>
                    <li class="list-group-item p-1 hover-bg-lightgray">
                        <img src="//placehold.it/50x50" class="rounded-circle">
                        <span class="d-xs-none username">Harley</span>
                    </li>
                    <li class="list-group-item p-1 hover-bg-lightgray">
                        <img src="//placehold.it/50x50" class="rounded-circle">
                        <span class="d-xs-none username">John</span>
                    </li>
                    <li class="list-group-item p-1 hover-bg-lightgray">
                        <img src="//placehold.it/50x50" class="rounded-circle">
                        <span class="d-xs-none username">Ben</span>
                        <span class="badge badge-primary">new</span>
                    </li>
                </ul>
                </div>
            </div>
        </div>
        <div class="col d-flex p-0">
            <div class="card">
                <div class="card-header bg-darkblue text-white py-1 px-2" style="flex: 1 1">
                    <div class="d-flex flex-row justify-content-start">
                        <div class="col-1 p-1">
                            <button class="btn text-white bg-darkblue p-0 hover-color-lightgray">
                                <i class="fas fa-bars fa-2x"></i>
                            </button>
                        </div>
                        <div class="col">
                            <div class="my-0">
                                <b>StanIslove</b>
                            </div>
                            <div class="my-0">
                                <small>last seen Feb 18 2017</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-lightgrey d-flex flex-column p-0" style="flex: 9 1">
                    <div class="container-fluid message-scroll" style="flex: 1 1">
                        <div class="row">
                            <div class="card message-card m-1">
                                <div class="card-body p-2">
                                    <span class="mx-2">Hi, Dave</span>
                                    <span class="float-right mx-1"><small>14:13<i class="fas fa-eye fa-fw" style="color:#e64980"></i></small></span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="card message-card bg-lightblue m-1">
                                <div class="card-body p-2">
                                    <span class="mx-2">Hello, Stan</span>
                                    <span class="float-right mx-1"><small>14:14<i class="fas fa-eye fa-fw" style="color:#e64980"></i></small></span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="card message-card bg-lightblue m-1">
                                <div class="card-body p-2">
                                    <span class="mx-2">What's up?</span>
                                    <span class="float-right mx-1"><small>14:14<i class="fas fa-check fa-fw" style="color:#66a80f"></i></small></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card message-card m-1">
                                <div class="card-body p-2">
                                    <span>So far so good, but my plumbus doesn't work as well as Meeseeks can't fix it, please, help me or they... They gonna kill Morty...</span>
                                    <span class="float-right"><small>14:16<i class="fas fa-eye fa-fw" style="color:#e64980"></i></small></span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="card message-card bg-lightblue m-1">
                                <div class="card-body p-2">
                                    <span>I've called Rick, I'm on the way to your house,
                            but probably I lost my portal gun at the party yesterday.
                            Anyway, don't call the other Meeseeks solve this shit.</span>
                                    <span class="float-right mx-1"><small>14:21<i class="fas fa-check fa-fw" style="color:#66a80f"></i></small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control border-0" placeholder="Input message...">
                        <span class="input-group-addon">
                            <button class="btn border-0 bg-white text-primary hover-color-darkblue" type="button">
                                <i class="fab fa-telegram-plane fa-2x"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->
</div>
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
    $('.card-header').on('click', '[data-fa-i2svg]', function () {
        $("#sidebar-content")
                .removeClass("w-100")
                .width($("#sidebar").width());
        $("#sidebar").css({"flex" : "none"});
        $("#sidebar").animate({
            width: "toggle"
            }, 600, function() {
                    $("#sidebar").css({"flex" : '', "width" : ''});
                    $("#sidebar-content")
                                .css("width", "")
                                .addClass("w-100");
            });
    });
    
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#friend-list li .username").filter(function() {
             $(this).parent().toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
});
</script>
@endsection
<!-- /CONTENT -->