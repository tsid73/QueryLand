@extends('templates.master')
@section('pagetitle',$subj->subj_name)
@section('content')
<div class="row main">
    <div class="col-lg-3 col-md-3 col-xs-12">
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu">Latest</a></li>
            <li><a data-toggle="tab" href="#menu1">Most Viewed</a></li>
            <li><a data-toggle="tab" href="#menu2">All</a></li>
        </ul>
        <div class="tab-content">
            <div id="menu" class="tab-pane fade in active">
               @if(!empty($res))
                 @foreach($res as $results)
                <div class="flexbox">
                    <div class="big">
                        <hr>
                        <div class="flexbox">
                            <div class="col-lg-9 disp"> <a href="{{route('questions',$results->slug)}}" class="h4">{{$results->ques_heading}}</a>
                                <br>
                                <br>
                                <div class="label label-primary">{{$results->category}}</div>
                                <div class="badge">{{$results->tags}}</div>
                            </div>
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
                <div style="margin-top:20px;"> {{$result->links()}} </div>
                @endif
            </div> 
               
            <div id="menu1" class="tab-pane fade in"> 
              @if(!empty($resu))
               @foreach($resu as $results)
                <div class="flexbox">
                    <div class="big">
                        <hr>
                        <div class="flexbox">
                            <div class="col-lg-9 disp"> <a href="{{route('questions',$results->slug)}}" class="h4">{{$results->ques_heading}}</a>
                                <br>
                                <br>
                                <div class="label label-primary">{{$results->category}}</div>
                                <div class="badge">{{$results->tags}}</div>
                            </div>
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
                <div style="margin-top:20px;"> {{$result->links()}} </div>
                @endif
            </div>    
            
         <div id="menu2" class="tab-pane fade in"> 
              @if(!empty($result))
               @foreach($result as $results)
                <div class="flexbox">
                    <div class="big">
                        <hr>
                        <div class="flexbox">
                            <div class="col-lg-9 disp"> <a href="{{route('questions',$results->slug)}}" class="h4">{{$results->ques_heading}}</a>
                                <br>
                                <br>
                                <div class="label label-primary">{{$results->category}}</div>
                                <div class="badge">{{$results->tags}}</div>
                            </div>
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
                <div style="margin-top:20px;"> {{$result->links()}} </div>
                @endif
            </div>
        </div>
    </div>
</div> @stop