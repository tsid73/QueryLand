@extends('templates.master') @section('pagetitle','QueryLand') @section('css')
<style>
    .container-fluid {
        margin-left: 0px;
        margin-right: 0px;
    }
</style> @stop @section('content')
<div class="row main">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="top-contri">
            <h4>Top Contributors</h4> 
        @if(empty($con)) <br>
            <p>Nothing to show</p> 
        @else 
           @foreach($con as $contri)
            <div class="flexbox">
                <div class="big">
                    <br> <img src="{!!$contri->user_pic !!}" alt="" height="25px" width="25px"> &nbsp;&nbsp; {{$contri->username}} </div>
                <div>
                    <br> {{$contri->user_xp}}&nbsp;xp &nbsp; Level:&nbsp;{{$contri->user_level}}</div>
                <br> </div>
                @endforeach @endif 
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu">Latest</a></li>
            <li><a data-toggle="tab" href="#menu1">Most Viewed</a></li>
            <li><a data-toggle="tab" href="#menu2">All</a></li>
        </ul>
        <div class="tab-content">
            <div id="menu" class="tab-pane fade in active"> @if(!empty($res)) @foreach($res as $results)
                <div class="flexbox">
                    <div class="big">
                        <hr>
                        <div class="flexbox">
                            <div class="col-lg-9 disp"> <a href="{{route('questions',$results->slug)}}" class="h4">{{$results->ques_heading}}</a>
                                <br>
                                
                                <br>
                                <div class="label label-primary">{{$results->category}}</div> 
                                @php $exp = explode(' ',$results->tags); @endphp @foreach($exp as $ex)
                                <div class="badge">{{$ex}}</div> @endforeach </div>
                            <div class=" col-lg-3 disp"> Asked By : <b>{{$results->username}}</b>
                                <br>
                                <br> {{ Carbon\Carbon::parse($results->created_at,'Asia/Kolkata')->diffForHumans() }} </div>
                        </div>
                    </div>
                    <div>
                        <hr>
                        <div class="disp flexbox">
                            <div class="h5 text-center"> <b>Views</b>
                                <br> {{$results->ques_views}} </div> &nbsp;&nbsp;
                            <div class="h5 text-center"> <b>No. of Ans</b>
                                <br> {{ DB::table('ans_table')->where('ques_id','=',$results->ques_id)->count() }} </div>
                        </div>
                    </div>
                </div> @endforeach
                <div style="margin-top:20px;"> {{$result->links()}} </div> @endif </div>
            <div id="menu1" class="tab-pane fade in"> @if(!empty($resu)) @foreach($resu as $results)
                <div class="flexbox">
                    <div class="big">
                        <hr>
                        <div class="flexbox">
                            <div class="col-lg-9 disp"> <a href="{{route('questions',$results->slug)}}" class="h4">{{$results->ques_heading}}</a>
                                <br>
                                <br>
                                <div class="label label-primary">{{$results->category}}</div> @php $exp = explode(' ',$results->tags); @endphp @foreach($exp as $ex)
                                <div class="badge">{{$ex}}</div> @endforeach </div>
                            <div class=" col-lg-3 disp"> Asked By : <b>{{$results->username}}</b>
                                <br>
                                <br> {{ Carbon\Carbon::parse($results->created_at,'Asia/Kolkata')->diffForHumans() }} </div>
                        </div>
                    </div>
                    <div>
                        <hr>
                        <div class="disp flexbox">
                            <div class="h5 text-center"> <b>Views</b>
                                <br> {{$results->ques_views}} </div> &nbsp;&nbsp;
                            <div class="h5 text-center"> <b>No. of Ans</b>
                                <br> {{ DB::table('ans_table')->where('ques_id','=',$results->ques_id)->count() }} </div>
                        </div>
                    </div>
                </div> @endforeach
                <div style="margin-top:20px;"> {{$result->links()}} </div> @endif </div>
            <div id="menu2" class="tab-pane fade in"> @if(!empty($result)) @foreach($result as $results)
                <div class="flexbox">
                    <div class="big">
                        <hr>
                        <div class="flexbox">
                            <div class="col-lg-9 disp"> <a href="{{route('questions',$results->slug)}}" class="h4">{{$results->ques_heading}}</a>
                                <br>
                                <br>
                                <div class="label label-primary">{{$results->category}}</div> @php $exp = explode(' ',$results->tags); @endphp @foreach($exp as $ex)
                                <div class="badge">{{$ex}}</div> @endforeach </div>
                            <div class=" col-lg-3 disp"> Asked By : <b>{{$results->username}}</b>
                                <br>
                                <br> {{ Carbon\Carbon::parse($results->created_at,'Asia/Kolkata')->diffForHumans() }} </div>
                        </div>
                    </div>
                    <div>
                        <hr>
                        <div class="disp flexbox">
                            <div class="h5 text-center"> <b>Views</b>
                                <br> {{$results->ques_views}} </div> &nbsp;&nbsp;
                            <div class="h5 text-center"> <b>No. of Ans</b>
                                <br> {{ DB::table('ans_table')->where('ques_id','=',$results->ques_id)->count() }} </div>
                        </div>
                    </div>
                </div> @endforeach
                <div style="margin-top:20px;"> {{$result->links()}} </div> @endif </div>
        </div>
    </div>
</div> @stop