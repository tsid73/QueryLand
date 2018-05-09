@extends('templates.master') @section('pagetitle','User profile') @section('css')
<style>
    .main {
        margin-top: 45px;
    }
    
    .mr-left {
        margin-left: 30px;
    }
    
    .mr-bottom {
        margin-bottom: 15px;
    }
    
    .mr-top {
        margin-top: 25px;
        /*        padding-top: 15px;*/
    }
    
    #editdata {
        padding: 5px;
    }
    
    @media (max-width:600px) {
        .text-nowrap {
            font-size: 12px;
        }
        .badge {
            min-width: 6px;
            padding: 3px 3px;
        }
        .mr-left {
            margin-left: 10px;
        }
        .main {
            margin-top: 25px;
        }
        .nav>li>a{
            padding: 7px 10px;
        }
    }
</style> @stop @section('content')
<!---->
<div id="ansedit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">EDIT ANSWER</h4> </div>
            <div class="modal-body">
                <form action="/user/ans/update" method="post" class="form-horizontal" id="editdata"> {{ csrf_field() }}
                    <div class="input-group-sm">
                        <div class="h4 text-center">Answer Content</div>
                        <div id="toolbar"></div>
                        <div id="editor"></div>
                        <textarea id="cont" name="cont" cols="40" rows="5" style="display:none;"></textarea>
                    </div>
                    <input type="hidden" name="aid" id="aid" value="">
                    <br>
                    <div class="input-group-btn">
                        <input class="btn btn-primary form-control-static pull-right" type="submit" value="Update Answer" name="submit" id="updateans"> </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!---->
<!---->
<div id="commedit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Edit Comment</h4> </div>
            <div class="modal-body">
                <form action="/user/comm/update" method="post" class="form-horizontal" id="editcomm"> {{ csrf_field() }}
                    <div class="input-group-sm">
                        <div class="h4 text-center">Comment Content</div>
                        <input type="text" name="comm" id="comm" value="">
                        <textarea id="cont" name="cont" cols="40" rows="5" style="display:none;"></textarea>
                    </div>
                    <input type="hidden" name="cid" id="cid" value="">
                    <br>
                    <div class="input-group-btn">
                        <input class="btn btn-primary form-control-static pull-right" type="submit" value="Update Comment" name="submit" id="updateans"> </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!---->

<div class="row main">
    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-4">
        <div class="row">

            <div class="col-lg-8 col-sm-10 col-xs-12 col-lg-offset-1"> <img src="{{$result->user_pic}}" alt="" height="150px" width="150px" class="img-circle img-thumbnail mr-left mr-bottom">
                <br>
                <p class="h4"> {{$result->name}} </p>
                <br> @auth @if(strpos(url()->full(), Auth::user()->username) !== false) <a href="{{route('user_edit',Auth::user()->username)}}" class="btn btn-warning">Edit</a> @endif @endauth
                <hr>
                <p class="text-nowrap">Username : {{$result->username}} </p>
                <p class="text-nowrap">User Field : {{$result->user_field}} </p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-8 text-nowrap">
       @if(Auth::guard('admin')->user()) 
@php echo "<a href='http://localhost:8000/admin/index/users' class='btn btn-info' id='back' style='float:right;'>Go Back</a>"; @endphp @endif
        <p class="h3">Stats</p> Total Questions Asked : <span class="badge"> {{$ques}} </span>
        <br> Total Questions Answered : <span class="badge"> {{$ans}} </span>
        <br> Total Comments : <span class="badge"> {{$comment}} </span>
        <br> Last visit : {{Carbon\Carbon::parse($result->last_login,'Asia/Kolkata')->diffForHumans() }}
        <br>
        <hr> Your Experience: {{$result->user_xp}} xp
        <br> Your Level: {{$result->user_level}}
        <br> </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 br-r br-l">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu">Questions</a></li>
            <li><a data-toggle="tab" href="#menu1">Answers</a></li>
            <li><a data-toggle="tab" href="#menu2">Comments</a></li>
        </ul>
        <div class="tab-content">
            <div id="menu" class="tab-pane fade in active"> @foreach($ques_cont as $cont)
                <hr>
                <div class="disp"> <a href="{{route('questions',$cont->slug)}}">{{$cont->ques_heading}}</a>
                    <br>{{\Carbon\Carbon::parse($cont->created_at,'Asia/Kolkata')->diffForHumans()}}
                    <div style="display:inline;"> @auth
                        <div class="text-right"> <a href="{{route('editques',$cont->ques_id)}}" class="btn">Edit</a> <a href="#" class="btn" onclick="mydel('{{$cont->ques_id}}')">Delete</a> </div> @endauth
                        <br>
                        @php $exp = explode(' ',$cont->tags); @endphp @foreach($exp as $ex)
                                <div class="badge">{{$ex}}</div> @endforeach
                    </div>
                </div>
                <hr> @endforeach 
                {{$ques_cont->links()}}
                </div>
            <div id="menu1" class="tab-pane fade"> @foreach($ans_cont as $cont)
                <hr>
                <div class="disp"> <a href="{{route('questions',$cont->slug)}}">{{$cont->ques_heading}}</a> @if(strlen($cont->ans_content)>100)
                    <p>Click View</p> @else
                    <p>{!!$cont->ans_content!!}</p> @endif
                    <br>{{\Carbon\Carbon::parse($cont->created_at,'Asia/Kolkata')->diffForHumans()}}
                    <div style="display:inline;"> @auth
                        <div class="text-right"> <a href="#" class="btn" data-toggle="modal" data-target="#ansedit" data-cnt='{{$cont->ans_content}}' data-id='{{$cont->ans_id}}'>Edit</a>
                        <a href="#" class="btn" onclick="ansdel('{{$cont->ans_id}}')">Delete</a> </div> @endauth
                        <br> </div>
                </div>
                <hr> @endforeach 
                {{$ans_cont->links()}}
                </div>
            <div id="menu2" class="tab-pane fade"> @foreach($comment_cont as $cont)
                <hr>
                <div class="disp"> <a href="{{route('questions',$cont->slug)}}">{{$cont->ques_heading}}</a>
                    <p>{{$cont->comment_body}}</p>
                    <br>{{\Carbon\Carbon::parse($cont->created_at,'Asia/Kolkata')->diffForHumans()}}
                    <div style="display:inline;"> @auth
                        <div class="text-right"> <a href="#" class="btn" data-toggle="modal" data-target="#commedit" data-cnt='{{$cont->comment_body}}' data-id='{{$cont->comment_id}}'>Edit</a>
                        <a href="#"  onclick="commentdel('{{$cont->comment_id}}')" class="btn">Delete</a> </div> @endauth
                        <br> </div>
                </div>
                <hr> @endforeach 
                {{$comment_cont->links()}}
                </div>
        </div>
    </div>
</div>
<hr>
<div class="row box mr-top">
    <div class="col-lg-8 col-lg-offset-2">
        <p class="h2">Suggested</p>
    </div>
</div> @stop @section('script') @php echo "
<script>
    function mydel(id) {
        var x = confirm('Do you really want to delete this question?');
        if (x == true) {
            document.getElementById('qid').value = id;
            document.getElementById('submit').click();
        }
        else {
            return;
        }
    }

    function ansdel(id) {
        var x = confirm('Do you really want to delete this question?');
        if (x == true) {
            $('#formsubmit').attr('action', '/user/ansdelete');
            document.getElementById('qid').value = id;
            document.getElementById('submit').click();
        }
        else {
            return;
        }
    } 
    function commentdel(id) {
        var x = confirm('Do you really want to delete this question?');
        if (x == true) {
            $('#formsubmit').attr('action', '/user/commentdelete');
            document.getElementById('qid').value = id;
            document.getElementById('submit').click();
        }
        else {
            return;
        }
    }
    
    $(document).ready(function () {
        $('#ansedit').on('show.bs.modal', function (e) {
            var cont = $(e.relatedTarget).data('cnt');
            var aid = $(e.relatedTarget).data('id');
            document.querySelector('.ql-editor').innerHTML = cont;
            document.getElementById('aid').value = aid;
        });
        $('#commedit').on('show.bs.modal', function (e) {
            var cont = $(e.relatedTarget).data('cnt');
            var aid = $(e.relatedTarget).data('id');
            document.getElementById('comm').value = cont;
            document.getElementById('cid').value = aid;
        });
    });
    $('#editdata').submit(function (e) {
        var str = document.querySelector('.ql-editor').innerHTML;
        var arr = new Array();
        var c = 0;
        $('.ql-editor img').each(function () {
            arr[c++] = this.src;
        });
        for (i = 0; i < arr.length; i++) {
            var s = arr[i].toString();
            let base64Length = s.length - (s.indexOf(',') + 1);
            let padding = (s.charAt(s.length - 2) === '=') ? 2 : ((s.charAt(s.length - 1) === '=') ? 1 : 0);
            let fileSize = base64Length * 0.75 - padding;
            if (fileSize > 1000000) {
                alert('File Size exceeded Max 1mb');
                return false;
            }
        }
        document.getElementById('cont').value = str;
    });
    
</script>"; echo "
<form action='/user/quesdelete' method='post' id='formsubmit'>
    <input type='hidden' name='id' id='qid' value=''>
    <button type='submit' name='submit' id='submit' style='display:none;'></button>
</form>"; @endphp @stop