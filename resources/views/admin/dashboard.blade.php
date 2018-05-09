<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/cms/style.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
<link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Admin Login</title>
    <style>
        .modal-header,
        h4 {
            background-color: cadetblue;
            color: white;
            text-align: center;
            letter-spacing: 0.2em;
            font-size: 30px;
        }
        
        .modal-footer {
            background-color: cadetblue;
        }
        
        .white-fg,
        a:link {
            color: white;
        }
        
        .white-fg,
        a:visited {
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
      <div id="passwrd" style="display:none;">
      <div class="panel panel-primary">
      <div class="panel-heading">Reset Password</div>
      <div class="panel-body">
       <div class="col-md-10 col-md-offset-1">
            <form class="form-horizontal" method="POST" action="{{ route('sendpassword') }}"> {{ csrf_field() }}
                <div class="form-group">
                    <label for="email" class="control-label">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required> @if ($errors->has('email')) <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span> @endif
                </div>
                <div class="form-group">
                    <label for="sques" class="control-label">Security question</label>
                    <select class="form-control" name="sques" id="sques">
                        <option value="" hidden>Select your question</option>
                        <option value="1">Favourite sportsperson</option>
                        <option value="2">Favourite Dish</option>
                        <option value="3">Dog or Cat person</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sans" class="control-label">Answer</label>
                    <input type="text" name="sans" id="sans" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Retreive Password</button>
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-info" onclick="replaceback()" style="float:right;"> Back to login </button>
        </div>
        </div>
        </div>
        </div>
        <!-- Modal -->
        <div class="modal-dialog" role="dialog">
            <!-- Modal content-->
            <div id="maindash" class="modal-content">
                <div class="modal-header" style="padding:15px 40px;">
                    <h4><span class="glyphicon glyphicon-lock"></span> LOGIN</h4> </div>
                <div class="modal-body" style="padding:30px 40px;">
                    <form method="post" action="/admin/dashboard" role="form" id="login-form"> {{ csrf_field() }}
                        <div class="form-group {{((Session::get('error')==1) ? 'has-error' : '')}}">
                            <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
                            <input type="text" name="username" class="form-control" id="usrname" placeholder="Enter Username" required> </div>
                        <div class="form-group {{((Session::get('error')==1) ? 'has-error' : '' )}}">
                            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                            <input type="password" name="password" class="form-control" id="psw" placeholder="Enter password" required> </div>
                        <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me </label>
                                </div>
                        </div>
                        <button name="submit" id="submit" type="submit" class="btn modal-footer white-fg btn-block">
                            <center><span class="glyphicon glyphicon-off"></span> Login</center>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <p class="white-fg"><a href="#" onclick="replacecont()">Forgot Password?</a></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"> @if(Session::get('error')==1)
                <div id="erromsg"><span class="alert alert-danger">Invalid Username or Password </span></div> @endif
                @if(Session::has('er'))
                 <div id="erromsg"><span class="alert alert-danger">Invalid Username or Password </span></div> @endif
                  </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script>
        var a = document.getElementById("maindash").innerHTML;
        var b = document.getElementById("passwrd").innerHTML;
    function replacecont(){
        document.getElementById("maindash").innerHTML = b;
    }
    function replaceback(){
        document.getElementById("maindash").innerHTML = a;
    }
    </script>
    
</body>

</html>