@extends('templates.master') @section('pagetitle','Edit Ques') @section('css')
<style>
    .mr-top {
        margin-top: 40px;
    }
</style> @stop @section('content') @if(Session::get('id')==1)
<div id="msg"><span class="alert alert-success">Successfully Updated</span></div> @if(Session::get('id')==0)
<div id="msg"><span class="alert alert-danger">Some Error Occured try again!</span></div> @endif @endif
<div class="row mr-top">
    <div class="col-lg-8 col-lg-offset-2">
        <div id="er" class="alert alert-success" style="display:none;"></div>
        <div class="panel panel-primary">
            <div class="panel-heading"> Question </div>
            <div class="panel-body" id="reloadup">
                <form action="{{url('/user/question')}}" method="post" class="form-horizontal" id="getdata"> {{method_field('patch')}} {{ csrf_field() }}
                    <div class="input-group-lg">
                        <label for="title">Question Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{$ques->ques_heading}}"> </div>
                    <br>
                    <div class="input-group">
                        <div style="display:none;">{{ $result = \App\Subject::all()}}</div>
                        <label for="opt">Choose Subject</label>
                        <select name="opt" id="options" class="form-control" onchange="getsub()">
                            <option value="{{$ques->subject_id}}">{{$ques->subj_name}}</option> @foreach($result as $results)
                            <option value="{{$results->subject_id}}">{{$results->subj_name}}</option> @endforeach </select>
                    </div>
                    <br>
                    <div class="input-group">
                        <label for="subopt">Choose Sub Category</label>
                        <select name="subopt" id="suboption" class="form-control">
                            <option value="{{$ques->sub_cat}}">{{$ques->category}}</option>
                        </select>
                    </div>
                    <br>
                    <div class="input-group-sm">
                        <label for="content">Question Content</label>
                        <div id="toolbar"></div>
                        <div id="editor"></div>
                        <textarea id="cont" name="cont" id="" cols="40" rows="5" style="display:none;"></textarea>
                    </div>
                    <div class="input-group-lg">
                        <label for="tag">Tags(max 5)</label>
                        <input type="text" name="tag" id="tag" class="form-control" onblur="myfun()" required value="{{$ques->tags}}"> </div>
                    <br>
                    <input type="hidden" name="quesid" value="{{$ques->ques_id}}">
                    <div class="input-group-btn">
                        <input class="btn btn-primary" type="submit" value="Update" name="submit" id="ask"> </div>
                </form>
            </div>
        </div>
    </div>
</div> @section('script')
<script>
    $(document).ready(function () {
        var usedNames = {};
        $("select > option").each(function () {
            if (usedNames[this.text]) {
                $(this).remove();
            }
            else {
                usedNames[this.text] = this.value;
            }
        });
        document.querySelector(".ql-editor").innerHTML = '{!!$ques->ques_content!!}';
    });
    
    @if(Session::get('id') == 1)
    setTimeout(function () {
        window.location.href = '{{route("templates.profile",Auth::user()->username)}}'
    }, 3000);
    @endif
    
    $("#getdata").submit(function (e) {
        var str = document.querySelector(".ql-editor").innerHTML;
        document.getElementById("cont").value = str;
    });

    function getsub() {
        var sub = $("#options").val();
        $.ajax({
            type: 'post'
            , url: '/getsubcat'
            , data: {
                subj: sub
            }
            , dataType: 'json'
            , success: function (data) {
                console.log(data);
                $("#suboption").empty();
                $.each(data, function (key, value) {
                    var va = JSON.stringify(value.category);
                    var vale = JSON.stringify(value.sub_cat);
                    $("#suboption").append('<option value=' + vale.replace(/\"/g, "") + '>' + va.replace(/\"/g, "") + '</option>');
                });
            }
        , });
    }
        
    $("#getdata").validate({
            rules: {
               title: {
                    required: true
                    , minlength: 5
                }
                , opt: {
                    required: true
                }
                , subopt: {
                    required: true
                }
            }
            , messages: {
                title: {
                    required: "Please enter a Title"
                    , minlength: "Your Title must consist of at least 5 characters"
                }
                , opt: {
                    required: "Please provide a Subject"
                }
                , subopt: "Please provide a Subject Category"
            }
        });
</script> @stop @endsection