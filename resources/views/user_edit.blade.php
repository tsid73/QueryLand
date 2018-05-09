@extends('templates.master') @section('pagetitle','Edit user') @section('content')
<div class="row main"> @if(session()->has('status'))
    <div class="{{session()->get('status')}} text-center">Updation was Successful</div> @endif
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 br-l col-lg-offset-1 col-md-offset-1 col-sm-offset-1"> <a href="#" class="btn btn-info" onclick="dispprofile()">Manage Profile</a>
        <br>
        <br> <a href="#" class="btn btn-info" onclick="disptopics()">Topics</a>
        <br>
        <br> </div>
    <div class="col-lg-6 col-md-6 col-sm-11 col-xs-11">
        <div id="contents">
            <div id="profile">
                <div class="panel panel-default">
                    <div class="panel-heading"> Manage Profile </div>
                    <div class="panel-body">
                        <form action="" method="post" class="form-horizontal" id="editform"> {{ csrf_field() }}
                            <label for="name">Name</label> @if(!empty($result->name))
                            <input type="text" name="name" id="name" class="form-control" data-toggle="popover" data-content="Provide your good name" data-trigger="focus" data-placement="auto" value="{{$result->name}}"> @else
                            <input type="text" name="name" id="name" class="form-control" data-toggle="popover" data-content="Provide your good name" data-trigger="focus" data-placement="auto" value=""> @endif
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" data-toggle="popover" data-content="Username must be unique and without Spaces" data-trigger="focus" data-placement="auto" value="{{$result->username}}">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{$result->email}}" data-toggle="popover" data-content="Example: someone@example.com" data-trigger="focus" data-placement="auto">
                            <br>
                            <label for="img">Choose Your Profile picture</label>
                            <input type="file" name="img" id="img" value="">
                            <br> <img src="{{$result->user_pic}}" alt="" height="150px" width="150px" class="img-circle img-thumbnail" id="pro">
                            <input type="hidden" name="up" id="b64" value="">
                            <br>
                            <br> @if($result->user_field == "teacher")
                            <label for="institute">Enter your associated Institute</label>
                            <input type="text" name="institute" id="institute" class="form-control" data-toggle="popover" data-content="Example: National P.G College" data-trigger="focus" data-placement="auto" value="{{$result->institute}}">
                            <label for="specs">Enter your Specialised field</label>
                            <input type="text" name="specs" id="specs" class="form-control" data-toggle="popover" data-content="Example: Web Development" data-trigger="focus" data-placement="auto" value="{{$result->specialisation}}"> @endif @if($result->user_field == "student")
                            <label for="institute">Enter your School/College</label>
                            <input type="text" name="institute" id="institute" class="form-control" data-toggle="popover" data-content="Example: National P.G College" data-trigger="focus" data-placement="auto" value="{{$result->institute}}">@endif
                            <br>
                            <div class="input-group">
                                <button class="btn btn-primary" value="update" type="update">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="topics" style="display:none;">
                <div class="panel panel-default">
                    <div class="panel-heading"> Manage Topics </div>
                    <div class="panel-body"> @if(session()->has('msg'))
                        <div class="alert alert-success">Successfully added</div> @endif @if(session()->has('del'))
                        <div class="alert alert-success">Successfully Deleted</div> @endif
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#menu">Your Topics</a></li>
                            <li><a data-toggle="tab" href="#menu1">All topics</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="menu" class="tab-pane fade in active">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Topic</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                       @if($r[0] == null)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @else
                                        @foreach($r as $topics)
                                        <tr>
                                            <td>{{$topics->id}}</td>
                                            <td>{{$topics->topics}}</td>
                                            <td><a href="#" onclick="deletefun('{{$topics->id}}')" class="btn">delete</a> </td>
                                        </tr>
                                         @endforeach
                                        @endif
                                          </tbody>
                                </table>
                            </div>
                            <div id="menu1" class="tab-pane fade in">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Topic</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @if(!empty($top))
                                         @foreach($top as $topics)
                                        <tr>
                                            <td>{{$topics->id}}</td>
                                            <td>{{$topics->topics}}</td>
                                            <td>
                                                <input type="checkbox" class="theClass" value="{{$topics->id}}"> </td>
                                        </tr> @endforeach 
                                         @else
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        </tbody>
                                </table>
                                <button class="btn btn-primary" type="button" onclick="addtopic()">Add Topic</button>
                            </div>
                        </div>
                        <form action="/deletetopic" method="post" class="form-horizontal" id="deleteid" style="display:none;"> {{method_field('delete')}} {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" name="tid" id="tid">
                                <button class="btn btn-primary" value="update" type="submit"></button>
                            </div>
                        </form>
                        <form action="/addtopic" method="post" id="addtopic" style="display:none;"> {{ csrf_field() }}
                            <input type="text" name="add" id="add" value="">
                            <button class="btn btn-primary" value="" type="submit"></button>
                        </form>
                        <br> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-0 col-xs-0"></div>
</div> @stop @section('script')
<script src="{{asset('js/user.js')}}"></script> @stop