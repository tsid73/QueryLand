<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!--    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/cms/style.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
    <!--    <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> @yield('css')
    <title>@yield('pagetitle')</title>
</head>
<div id="sec" style="display:none;">
   <form action="/admin/user/up" method="post"> {{csrf_field()}}
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
                <input type="hidden" name="id" value="{{Auth::guard('admin')->user()->admin_id}}">
                <div class="form-group">
                    <label for="sans" class="control-label">Answer</label>
                    <input type="text" name="sans" id="sans" class="form-control" required>
                </div>
                <div class="form-group">
                        <button class="btn btn-success" value="submit" type="submit">Update</button>
                    </div>
                </form>
                <button class="btn btn-info" onclick="repb()">Back to profile</button>
                
</div>

<!--        Profile modal-->
<div id="profilemodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Profile</h4> </div>
            <div class="modal-body" id="prof">
                <form action="/admin/user/update" method="post" id="adminedit"> {{method_field('PATCH')}} {{csrf_field()}}
                    <div class="form-group">
                        <label for="user" class="control-label">Admin Username</label>
                        <input type="text" class="form-control" name="user" id="user" value="{{Auth::guard('admin')->user()->username}}">
                        <input type="hidden" name="id" value="{{Auth::guard('admin')->user()->admin_id}}"> </div>
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
                <button class="btn btn-info" onclick="rep()">Change Security info</button>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  End-->
<!---->
<div id="notes" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Notifications</h4> </div>
            <div class="modal-body">
                <div id="viewunread">
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <th>Notification</th>
                            <th>Type</th>
                            <th>Approve</th>
                            <th>View</th>
                            <th>Mark as Read</th>
                        </thead>
                        <tbody> @foreach(Auth::guard('admin')->user()->unreadNotifications as $notification)
                            <tr>
                                <td>{{$notification->data['ques']}}</td>
                                <td>{{$notification->type}}</td>
                                <div style="display:none;"> {{$re = \App\Http\Controllers\AdminController::checkapp($notification->data['ques_id'],$notification->id) }} </div> @if($re)
                                <td> <a href="#" id="app_{{$notification->data['ques_id']}}" class="btn app disabled">Approve</a> </td> @else
                                <td> <a href="#" id="app_{{$notification->data['ques_id']}}" class="btn app">Approve</a> </td> @endif
                                <td> <a href="{{route('questions',$notification->data['slug'])}}" target="_blank" class="btn">View</a> </td>
                                <td><a href="#" id="read_{{$notification->data['ques_id']}}" onclick="markread('{{$notification->id}}')" class="btn">Mark as Read</a></td>
                            </tr> @endforeach </tbody>
                    </table> <span class="divider"></span>
                    <button class="btn" type="button" onclick="view()">View All</button> <a href="{{url('/notifications/markall')}}" class="btn">Mark All as Read</a> </div>
                <div id="viewall" style="display:none;">
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <th>Notification</th>
                            <th>Type</th>
                        </thead>
                        <tbody> @foreach(Auth::guard('admin')->user()->notifications as $notification)
                            <tr>
                                <td>{{$notification->data['ques']}}</td>
                                <td>{{$notification->type}}</td>
                            </tr> @endforeach </tbody>
                    </table> <span class="divider"></span>
                    <button type="button" class="btn" onclick="un()">Go Back to Unread</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!---->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> <a class="navbar-brand" href="{{route('admin.index')}}">QueryLand@Admin</a> </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="#" data-toggle="modal" data-target="#notes"><i class="fa fa-bell-o"></i><b class="caret"></b></a></li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::guard('admin')->user()->username}} <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li> <a href="#" class="list-group-item" type="button" data-toggle="modal" data-target="#profilemodal"><i class="fa fa-fw fa-user"></i> Profile</a> </li>
                <li> <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i> Logout</a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;"> {{csrf_field() }} </form>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
<!--            <li> <a href="{{ route('admin.index') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> </li>-->
            <li> <a href="{{ route('admin.user') }}"><i class="fa fa-user"></i>  Users</a> </li>
            <li> <a href="{{ route('admin.ques') }}"><i class="fa fa-question"></i> Questions</a> </li>
            <div style="display:none;"> {{$an = \App\Http\Controllers\AdminController::anscount() }} </div>
            <li> <a href="{{ route('admin.ans') }}"><i class="fa fa-check"></i> Answers <span title="unapproved" class="badge">{{$an}}</span> </a> </li>
            <li> <a href="{{ route('admin.comment') }}"><i class="fa fa-file-o"></i>  Comments</a> </li>
            <li> <a href="{{route('admin.subject')}}"><i class="glyphicon glyphicon-book"></i> Subjects</a> </li>
            <li> <a href="{{route('admin.sub_cat')}}"><i class="glyphicon glyphicon-book"></i> Subjects Category</a> </li>
            <li> <a href="{{route('admin.topic')}}"><i class="glyphicon glyphicon-file"></i> Topics</a> </li>
            <div style="display:none;"> {{$rep = \App\Http\Controllers\AdminController::reportcount() }} </div>
            <li> <a href="{{route('admin.report')}}"><i class="glyphicon glyphicon-file"></i> Reports <span title="Unread" class="badge">{{$rep}}</span> </a> </li>
            <li> <a href="{{route('admin.site')}}"><i class="glyphicon glyphicon-globe"></i> Site</a> </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> <a class="navbar-brand" href="{{route('admin.index')}}">QueryLand@Admin</a> </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li><a href="#" data-toggle="modal" data-target="#notes"><span class="badge">{{Auth::guard('admin')->user()->unreadNotifications->count()}}</span><i class="fa fa-bell"></i><b class="caret"></b></a></li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::guard('admin')->user()->username}}<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li> <a href="#" class="list-group-item" type="button" data-toggle="modal" data-target="#profilemodal"><i class="fa fa-fw fa-user"></i> Profile</a> </li>
                    <li> <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i> Logout</a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;"> {{csrf_field() }} </form>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
<!--                <li> <a href="{{ route('admin.index') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> </li>-->
                <li> <a href="{{ route('admin.user') }}"><i class="fa fa-user"></i>  Users</a> </li>
                <li> <a href="{{ route('admin.ques') }}"><i class="fa fa-question"></i> Questions</a> </li>
                <div style="display:none;"> {{$an = \App\Http\Controllers\AdminController::anscount() }} </div>
            <li> <a href="{{ route('admin.ans') }}"><i class="fa fa-check"></i> Answers <span title="unapproved" class="badge">{{$an}}</span> </a> </li>
                <li> <a href="{{ route('admin.comment') }}"><i class="fa fa-file-o"></i>  Comments</a> </li>
                <li> <a href="{{route('admin.subject')}}"><i class="glyphicon glyphicon-book"></i> Subjects</a> </li>
                <li> <a href="{{route('admin.topic')}}"><i class="glyphicon glyphicon-file"></i> Topics</a> </li>
                <div style="display:none;"> {{$rep = \App\Http\Controllers\AdminController::reportcount() }} </div>
            <li> <a href="{{route('admin.report')}}"><i class="glyphicon glyphicon-file"></i> Reports <span title="Unread" class="badge">{{$rep}}</span> </a> </li>
                <li> <a href="{{route('admin.sub_cat')}}"><i class="glyphicon glyphicon-book"></i> Subjects Category</a> </li>
                <li> <a href="{{route('admin.site')}}"><i class="glyphicon glyphicon-globe"></i> Site</a> </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
              @yield('content') 
              <button type="button" class="fixed-buttons wobble" id="myBtn" style="display:none;" onclick="topFunction()"><span><i class="fa fa-arrow-up"></i></span> </button>
              </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/cms.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    @yield('script')
    <script>
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
        var a = document.getElementById("prof").innerHTML;
        var b = document.getElementById("sec").innerHTML;
    function rep(){
        document.getElementById("prof").innerHTML = b;
    }
    function repb(){
        document.getElementById("prof").innerHTML = a;
    }
        
    </script> </body>

</html>