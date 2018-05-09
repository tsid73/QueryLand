@extends('templates.master')
@section('pagetitle','Search')
@section('content')
<div class="row main">
   <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
    @if(empty($res))
    <div class="h3">Your search didnt match our records</div> <br>
    <div class="h5">You can Search using Keywords like "Tags" "Subject Chapter Name"</div>
    @else
    <div class="h3">Your Search returned {{$res->count()}} results </div> <br>
    @foreach($res as $result)
    <hr>
    <div class="disp"><a href="{{route('questions',$result->slug)}}">{{$result->ques_heading}}</a></div>
    <br>
    @php $exp = explode(' ',$result->tags); @endphp @foreach($exp as $ex)
                                <div class="badge">{{$ex}}</div> @endforeach
    <hr>
    @endforeach
    @endif
    </div>
</div>
@stop