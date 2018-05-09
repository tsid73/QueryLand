<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!--    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <!--    Quill editor-->
    <script src="//cdn.quilljs.com/1.3.5/quill.js"></script>
    <link href="//cdn.quilljs.com/1.3.5/quill.snow.css" rel="stylesheet">
    <!--   Font Awsm-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.2/normalize.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon"> @auth
    <style>
        .credit {
            display: none;
        }
    </style> @endauth
    <style>
        .modal-title {
            font-size: 20px;
            letter-spacing: 0.1em;
        }
        
        .modal-header,
        .modal-footer {
            background-color: cadetblue;
            color: ghostwhite;
        }
        
        .modal-footer {
            margin-top: 15px;
            text-align: center;
        }
        
        .modal-body {
            padding: 15px 0px 0 0px;
        }
        
        #loginarea {
            margin: 0 10px 0 10px;
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/style-welcome.css')}}"> @yield('css')
    <title>@yield('pagetitle')</title>
</head>

<body>
    <!--        Profile modal-->
    <div id="loginmodal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="color:red;">&times;</button>
                    <div class="modal-title text-center"><i class="fa fa-sign-in"></i> SIGN IN</div>
                </div>
                <div class="modal-body">
                    <center>
                        <div class="loader"></div>
                    </center>
                    <div class="row" id="loginarea">
                        <div class="col-lg-6 col-lg-offset-2">
                            <form class="form-horizontal" method="POST" action="{{ route('user_login') }}" id="loginform"> {{ csrf_field() }}
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
                                        <button type="submit" class="btn btn-primary"> Login </button> <a class="btn btn-link" href="#" style="text-decoration:none;" onclick="replacecont()">
                                    Forgot Your Password?
                                </a> </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer"> <span class="alert alert-danger" id="er" style="display:none; padding:10px 50px;"></span>
                        <button type="button" class="btn btn-danger  form-control-static pull-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  End-->
    <!--    Password Reset-->
    <div id="reset" style="display:none;">
        <div class="col-md-8 col-md-offset-2"> @if (session('status'))
            <div class="alert alert-success"> {{ session('status') }} </div> @endif
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}"> {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required> @if ($errors->has('email')) <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span> @endif </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary"> Send Password Reset Link </button>
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-info" onclick="replaceback()" style="float:right;"> Back to login </button>
        </div>
    </div>
    <!--    end-->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button><a class="navbar-brand" href="{{route('welcome')}}">{{$site = \App\Site::where('site_id', 1)->first()->site_name}}</a> </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
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
                        <input type="text" class="form-control" name="searchmain" placeholder="Search using tags,category" id="mainsearch" autocomplete="off">
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
                    <li><a href="#" data-toggle="modal" data-target="#loginmodal" id="model"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul> @endauth </div>
        </div>
    </nav>
    <div class="container-fluid"> @yield('content')
        <button type="button" class="fixed-buttons wobble" id="myBtn" style="display:none;" onclick="topFunction()"><span><i class="fa fa-arrow-up"></i></span></button> @if(strpos(url()->full(),'ask') !== false) @else
        <button type="button" class="fixed-button wobble" onclick='link()'>Have Query?</button> @endif </div>
    <footer class="footer text-center">{!!$site = \App\Site::where('site_id', 1)->first()->footer!!}</footer>
    <!--    <script src="{{ asset('js/app.js') }}"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> @yield('script')
    <script>
        document.getElementById('mainsearch').onkeyup = function () {
    searching();
};

        
        function link() {
            window.location.href = "{{ route('ask') }}";
        }
        window.onscroll = function () {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
                document.getElementById("myBtn").style.display = "block";
            }
            else {
                document.getElementById("myBtn").style.display = "none";
            }
        }

        function topFunction() {
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        }

        
        function searching() {
            var words = $("#mainsearch").val();
            $("#mainsearch").autocomplete({
                source: function (query, response) {
                    $.ajax({
                        type: 'post'
                        , url: '/search'
                        , dataType: 'json'
                        , data: {
                            search: words
                        }
                        , success: function (data) {
                            //                    console.log(data);
                            response(data);
                        }
                    , });
                }
            , }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li>").data("ui-autocomplete-item", item).append("<a href='" + addfunc(item.slug) + "'>" + item.ques_heading + "</a>").appendTo(ul);
            };
        }

        function addfunc(item) {
            var url = '{{route("questions",":slug")}}';
            url = url.replace(':slug', item);
            return url;
        }
    </script>
</body>

</html>