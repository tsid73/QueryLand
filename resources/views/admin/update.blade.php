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
        <!-- Modal -->
        <div class="modal-dialog" role="dialog">
            <!-- Modal content-->
            <div id="maindash" class="modal-content">
                <div class="modal-header" style="padding:15px 40px;">
                    <h4><span class="glyphicon glyphicon-lock"></span> LOGIN</h4> </div>
                <div class="modal-body" style="padding:30px 40px;">
                  <form action="/admin/user/updates" method="post" id="adminedit"> {{method_field('PATCH')}} {{csrf_field()}}
                    <div class="form-group">
                        <label for="user" class="control-label">Admin Username</label>
                        <input type="text" class="form-control" name="user" id="user" value="{{$user}}">
                        <input type="hidden" name="id" value="{{$user_id}}"> </div>
                    <div class="form-group">
                        <label for="psw">Change Password</label>
                        <input type="password" name="psw" id="psw" class="form-control"> </div>
                    <div class="form-group">
                        <label for="pswc">Confirm Password</label>
                        <input type="password" name="pswc" id="pswc" class="form-control"> </div>
                    <div class="form-group">
                        <button class="btn btn-success" value="submit" type="submit">Update</button>
                    </div>
                </form>
                  
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"> @if(Session::has('er'))
                <div id="erromsg"><span class="alert alert-danger"></span></div> @endif </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>

</html>