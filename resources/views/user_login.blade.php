<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-signin-client_id" content="1062104642791-3i53jlukd22nhur24h7td4kfdij5lide.apps.googleusercontent.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!--    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--    Quill editor-->
    <script src="//cdn.quilljs.com/1.3.5/quill.js"></script>
    <!--    <script src="//cdn.quilljs.com/1.3.5/quill.min.js"></script>-->
    <!-- Theme included stylesheets -->
    <link href="//cdn.quilljs.com/1.3.5/quill.snow.css" rel="stylesheet">
    <!--    <link href="//cdn.quilljs.com/1.3.5/quill.bubble.css" rel="stylesheet">-->
    <!--   Font Awsm-->
    <link href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.2/normalize.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
    <!--    <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon"> -->@if(Auth::check())
    <style>
        .credit {
            display: none;
        }
    </style> @endif
    <style>
        .panel-heading {
            padding: 5px 10px;
            font-size: 30px;
        }
        
        @media (max-width: 767px) {
            .footer {
                position: fixed;
                left: 0;
                bottom: 0;
                font-size: 12px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/style-welcome.css')}}"> @yield('css')
    <title>User Login</title>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button><a class="navbar-brand" href="{{route('welcome')}}">QueryLand</a> </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <!--<li><a href="">Home</a></li>-->
                    <li><a href="{{route('who')}}">Who are we?</a></li>
                    <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#">Subjects
        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <div style="display:none;">{{$var = App\Subject::all()->pluck('subj_name')}} </div> @foreach($var as $subject)
                            <li><a href="{{route('templates.subject',$subject)}}">{{$subject}}</a></li> @endforeach </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" method="post" action="{{route('searching')}}"> {{csrf_field()}}
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchmain" placeholder="Search" id="mainsearch" autocomplete="off">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"> <i class="glyphicon glyphicon-search"></i> </button>
                        </div>
                    </div>
                    <ul id="listresult" class="list-group"> </ul>
                </form> @auth
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->username}}<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('templates.profile',Auth::user()->username)}}">Profile</a></li>
                            <li> <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{csrf_field() }} </form>
                            </li>
                        </ul>
                    </li>@else </ul>
                <ul class="nav navbar-nav navbar-right credit">
                    <li><a href="{{route('user_register')}}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                </ul> @endauth </div>
        </div>
    </nav>
    <div class="container-fluid">
        <center>
            <div class="loader"></div>
        </center>
        <div class="row" id="loginarea">
            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 top-m">
                <div class="panel panel-default">
                    <div class="panel-heading text-center text-capitalize">LOGIN</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('user_login') }}" id="loginformuser"> {{ csrf_field()}}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" onfocus="errorcheck()" class="form-control" name="email" value="{{ old('email') }}" autocomplete="new-email" required autofocus> </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" onfocus="errorcheck()" autocomplete="new-password" class="form-control" name="password" required> </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary"> Login </button></div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer text-center"> <span class="alert alert-danger" id="er" style="display:none; padding:0px 50px;"></span> </div>
                </div>
            </div>
        </div>
        <center> <span class="alert alert-danger" id="errormsg">You need to be logged in to access that page</span></center>
        <button type="button" class="fixed-button wobble" onclick='link()'>Have Query?</button>
    </div>
    <footer class="footer text-center">Copyright &copy 2018 Siddhant &amp; Akash</footer>
    <!--    <script src="{{ asset('js/app.js') }}"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script>
        function link() {
            window.location.href = "{{ route('ask') }}";
        }
        $(document).ready(function () {
            $('#loginformuser').submit(function (e) {
                e.preventDefault();
                $(".loader").show();
                $("#loginarea").hide();
                var form = $(this);
                var post_url = form.attr('action');
                var post_data = form.serialize();
                $.ajax({
                    type: 'POST'
                    , url: post_url
                    , data: post_data
                    , processData: false
                    , success: function (response) {
                        if (response == "er") {
                            $(".loader").hide();
                            $("#loginarea").show();
                            $("#er").show();
                            $("#errormsg").hide();
                            document.getElementById("er").innerHTML = "Invalid Email or Password! Try again.";
                        }
                        else {
                            $("#errormsg").hide();
                            $(".loader").show();
                            window.location = response;
                        }
                    }
                    , error: function (request, status, error) {
                        //                        alert(request.responseText);
                    }
                });
            });
        });

        function errorcheck() {
            var x = document.getElementById("er").innerHTML;
            if (x.length > 1) {
                $("#er").hide();
            }
        }
    </script>
</body>

</html>