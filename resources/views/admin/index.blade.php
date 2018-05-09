@extends('admin.master')
@section('pagetitle','Admin Dashboard')
@section('css')
<style>
    .panel-default>.panel-heading{
        background-color: cornflowerblue;
        color: black;
    }
    .panel-default>a .panel-footer{
        background-color:seagreen;
        color: ghostwhite;
    }
</style>
@stop            
@section('content')
                <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3"> <i class="fa fa-question fa-5x"></i> </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'>
                                            {{$ques}}
                                            </div>
                                            <div>Questions</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('admin.ques')}}">
                                    <div class="panel-footer"><span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3"> <i class="fa fa-files-o fa-5x"></i> </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'>
                                            {{$ans}}
                                            </div>
                                            <div>Answers</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('admin.ans')}}">
                                    <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-4"> <i class="fa fa-comments fa-5x"></i> </div>
                                        <div class="col-xs-8 text-right">
                                            <div class='huge'>
                                            {{$comm}}
                                            </div>
                                            <div>Comments</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('admin.comment')}}">
                                    <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3"> <i class="fa fa-users fa-5x"></i> </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'>
                                            {{$user}}
                                            </div>
                                            <div>Users</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('admin.user')}}">
                                    <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                </div>
                @endsection