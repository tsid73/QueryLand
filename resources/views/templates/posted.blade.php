@extends('templates.master')
@section('pagetitle','Posted')
@section('content')

<div class="row main">
    <span class="alert alert-success">Your Question was posted Succesfully</span><br><br>
    <p>It has been sent to the admin and will be posted after the approval.</p>
    Your Question Id is <b>{{$id}}</b> , use it for any future reference. You can also view your questions in your profile section.
</div>

@stop