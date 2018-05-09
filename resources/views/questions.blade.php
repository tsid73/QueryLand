@extends('templates.master') @section('pagetitle',$result->ques_heading) @section('css')
<style>
</style> @stop @section('content')
<!---->
<div id="quesreport" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Report Question</h4> </div>
            <div class="modal-body">
              <div id="quespart" style="padding:15px;">
               <form action="#" id="quesrpt" method="post">
                  <label for="">Report</label>
                  <div class="form-group">
                   <input type="checkbox" class="tclass" name="rpt" id="rpt" value="Spam"> Spam <br>
                   <input type="checkbox" class="tclass" name="rpt1" id="rpt1" value="Inappropriate"> Inappropriate <br>
                   <input type="checkbox" class="tclass" name="rpt2" id="rpt2" value="Abusive Content"> Abusive Content <br>
                   </div>
                   <input type="hidden" name="qid" id="qid" value="{{$result->ques_id}}"> <br>
                    <button>Submit</button>
               </form>
               </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!---->
<!--   -->
   <div id="ansreport" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Report Answer</h4> </div>
            <div class="modal-body">
              <div id="anspart" style="padding:15px;">
               <form action="#" id="ansrpt" method="post">
                  <label for="">Report</label>
                  <div class="form-group">
                   <input type="checkbox" class="theClass" name="rpt" id="rpt" value="Spam"> Spam <br>
                   <input type="checkbox" class="theClass" name="rpt1" id="rpt1" value="Inappropriate"> Inappropriate <br>
                   <input type="checkbox" class="theClass" name="rpt2" id="rpt2" value="Abusive Content"> Abusive Content <br>
                   </div>
                   <input type="hidden" name="aid" id="aid"> <br>
                    <button>Submit</button>
               </form>
               </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--   -->

<div class="row">
    <div class="clear"></div>
    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-11 col-md-push-9 col-lg-push-9 col-sm-push-9"> @if(Auth::guard('admin')->user()) @php echo "<a href='' class='btn btn-primary' id='back'>Go Back</a>"; echo"
        <script>
            var u = 'http://localhost:8000/admin/index/questions';
            document.getElementById('back').setAttribute('href', u);
        </script>"; @endphp @endif
        <br>
        <br>
        <div class="jumbotron"> <b>Asked By: </b> @if(empty($re->name)) {{$re->username}} @else {{$re->name}} @endif
            <br> Posted: {{ \Carbon\Carbon::parse($result->created_at,'Asia/Kolkata')->diffForHumans() }}
            <br> Views: {{ $view->ques_views }}
            <br> Tags : @php $exp = explode(' ',$result->tags); @endphp @foreach($exp as $ex)
            <div class="badge">{{$ex}}</div> @endforeach </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-9 col-xs-11 col-md-pull-2 col-lg-pull-2 col-sm-pull-2 br-r">
        <div id="ques_id" style="display:none;">{{$result->ques_id}}</div>
        <div class="flexbox">
        <div class="h3">{{$result->ques_heading}}</div>
        @auth
        @if(Auth::user()->username != $re->username)
        <div><button id="report" data-target="#quesreport" data-toggle="modal" title="Report Content"><i class="fa fa-ellipsis-v fa-2x"></i></button></div>
        @endif
        @endauth
        </div>
        <hr>
        <div class="row">
            <div class="showcont"> {!!$result->ques_content!!} </div>
        </div>
        <div class="clear"></div>
        <hr>
        <div class="h4"> {{\App\Ans::where('ques_id','=',$result->ques_id)->count()}} Answers </div>
        <br>
        <br> @foreach($answer as $ans)
        <div>
            <div class="flexbox">
                <div class="big"> <img src="{{$ans->user_pic}}" alt="" height="25px" width="25px" class="img-rounded"> @if(empty($ans->name)) {{$ans->username}} @else {{$ans->name}} @endif
                    <br> {{\Carbon\Carbon::parse($ans->created_at,'Asia/Kolkata')->diffForHumans()}} </div> 
                @auth 
                   @if(Auth::user()->username == $re->username)
                         @if(!empty($best))
                            @if($best->best == $ans->ans_id)
                <div>
                <button id="report" data-target="#ansreport" data-toggle="modal" data-id="{{$ans->ans_id}}" title="Report Content"><i class="fa fa-ellipsis-v fa-2x"></i></button>
                &nbsp;
                <button type="button" class="best-ans" id="best_{{$ans->ans_id}}"> <i class="fa fa-star fa-3x" id="bst_{{$ans->ans_id}}" style="color:yellow;"></i> </button>
                </div>
                            @else
                        <div>
                <button id="report" data-target="#ansreport" data-toggle="modal" data-id="{{$ans->ans_id}}" title="Report Content"><i class="fa fa-ellipsis-v fa-2x"></i></button>
                &nbsp;
                    <button type="button" class="best-ans" id="best_{{$ans->ans_id}}"> <i class="fa fa-star fa-3x" id="bst_{{$ans->ans_id}}"></i> </button>
                </div>
                            @endif
                        @else
                        <div>
                <button id="report" data-target="#ansreport" data-toggle="modal" data-id="{{$ans->ans_id}}" title="Report Content"><i class="fa fa-ellipsis-v fa-2x"></i></button>
                &nbsp;
                    <button type="button" class="best-ans" id="best_{{$ans->ans_id}}"> <i class="fa fa-star fa-3x" id="bst_{{$ans->ans_id}}"></i> </button>
                </div>
                        @endif
                @else
                    @if(!empty($best))
                        @if($best->best == $ans->ans_id)
                <div>
                <button id="report" data-target="#ansreport" data-toggle="modal" data-id="{{$ans->ans_id}}" title="Report Content"><i class="fa fa-ellipsis-v fa-2x"></i></button>
                &nbsp;
                <button type="button" disabled class="best-ans" id="best_{{$ans->ans_id}}"> <i class="fa fa-star fa-3x" id="bst_{{$ans->ans_id}}" style="color:yellow;"></i> </button>
                </div>
                       @else
                <button id="report" data-target="#ansreport" data-toggle="modal" data-id="{{$ans->ans_id}}" title="Report Content"><i class="fa fa-ellipsis-v fa-2x"></i></button>
                &nbsp;
                        @endif
                    @else
                <button id="report" data-target="#ansreport" data-toggle="modal" data-id="{{$ans->ans_id}}" title="Report Content"><i class="fa fa-ellipsis-v fa-2x"></i></button>
                &nbsp;
                    @endif
                @endif
                @else
                @if(!empty($best))
                    @if($best->best == $ans->ans_id)
                <div>
                <button type="button" disabled  class="best-ans" id="best_{{$ans->ans_id}}"> <i class="fa fa-star fa-3x" id="bst_{{$ans->ans_id}}" style="color:yellow;"></i> </button>
                </div>
                    @endif
                @endif
                @endauth </div>
            <br>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="showcont">{!!$ans->ans_content!!} </div>
            </div>
            @auth
            <div>
                <div style="display:none;"> {{ $vote = \App\Vote::where('user_id','=',Auth::user()->user_id)->where('ans_id','=',$ans->ans_id)->select('up','down')->first() }} </div> @if(!empty($vote)) @if($vote->up==1)
                <button type="button" id="like_{{$ans->ans_id}}" class="like btn btn-primary">Like&nbsp;<span class="badge" id="likebadge_{{$ans->ans_id}}"></span></button>
                <button type="button" id="unlike_{{$ans->ans_id}}" class="unlike btn">Dislike&nbsp;<span class="badge" id="dislikebadge_{{$ans->ans_id}}"></span></button> @endif @if($vote->down==1)
                <button type="button" id="like_{{$ans->ans_id}}" class="like btn">Like&nbsp;<span class="badge" id="likebadge_{{$ans->ans_id}}"></span></button>
                <button type="button" id="unlike_{{$ans->ans_id}}" class="unlike btn btn-danger">Dislike&nbsp;<span class="badge" id="dislikebadge_{{$ans->ans_id}}"></span></button> @endif @else
                <button type="button" id="like_{{$ans->ans_id}}" class="like btn">Like&nbsp;<span class="badge" id="likebadge_{{$ans->ans_id}}"></span></button>
                <button type="button" id="unlike_{{$ans->ans_id}}" class="unlike btn">Dislike&nbsp;<span class="badge" id="dislikebadge_{{$ans->ans_id}}"></span></button> @endif </div> @else
            <button type="button" disabled id="like_{{$ans->ans_id}}" class="like btn">Like&nbsp;<span class="badge" id="likebadge_{{$ans->ans_id}}"></span></button>
            <button type="button" disabled id="unlike_{{$ans->ans_id}}" class="unlike btn">Dislike&nbsp;<span class="badge" id="dislikebadge_{{$ans->ans_id}}"></span></button>
            @endauth
            <hr>
            <span class="h4">Comments</span>
            <div style="display:none;"> {{ $comment = \App\Http\Controllers\CommentController::show($ans->ans_id) }} </div> 
            <div id="commentarea">
            @foreach($comment as $com)
            <br>{{$com->comment_body}} :--- <img src="{{$com->user_pic}}" alt="" height="25px" width="25px" class="img-rounded"> {{$com->username}}
            <hr> @endforeach
            </div>
            <br>
            <br> @auth
            <div class="urcomment" style="width:60%; float:right;">
                <form action="{{route('comment')}}" method="post" class="form-horizontal"> {{csrf_field() }}
                    <input type="text" class="form-control" name="commentbody">
                    <input type="hidden" class="form-control" name="ansid" value="{{$ans->ans_id}}">
                    <input type="hidden" class="form-control" name="quesid" value="{{$result->ques_id}}">
                    <button type="submit" class="btn" name="comment">Add a Comment</button>
                </form>
            </div> @endauth
            <div class="clear"></div>
        </div> <hr> @endforeach
        {{$answer->links()}}
          @auth
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="anssite" style="margin-top:50px;">
                <hr>
                <h3>Your Answer</h3>
                <br>
                <div id="ansarea">
                    <div id="toolbar"></div>
                    <div id="editor"></div>
                    <br>
                    <button class="btn btn-primary" id="anspost" style="float:right;">Add answer</button>
                </div>
            </div>
        </div> @else
        <h3>You need to be logged in to answer</h3> @endauth </div>
    <div id="snackbar">Your Answer is sent to Admin and Will be Posted after Review. You can manage or delete it in the answer section of profile</div>
</div> @stop @section('script')
<script>
    $(document).ready(function () {
        $(".best-ans").on("click", function () {
            var id = $(this).attr('id');
            document.getElementById(id).disabled = true;
            var split_id = id.split("_");
            var type = 0;
            var ansid = split_id[1];
            var clr = $('#bst_' + ansid).css('color');
            if (clr === "rgb(255, 255, 0)") {
                type = 0;
                $("#bst_" + ansid).css('color', 'black');
            }
            else {
                type = 1;
                $("#bst_" + ansid).css('color', 'yellow');
            }
            $.ajax({
                type: 'post'
                , url: '/q/best'
                , data: {
                    type: type
                    , ansid: ansid
                }
                , success: function (response) {
                    document.getElementById(id).disabled = false;
                }
            , });
        });
    });
    
    $("#ansrpt").on("submit",function(e){
        e.preventDefault();
       var checkedVals = $('.theClass:checkbox:checked').map(function () {
         return this.value;
     }).get();
    var aid = document.getElementById('aid').value;
     var sendval = checkedVals.join(","); 
        $.ajax({
            type: 'post'
            ,url: '/user/ansrpt'
            ,data: {
                v : sendval,
                aid: aid                
            }
            ,success: function(response){
                if(response == "ok"){
                    document.getElementById('snackbar').innerHTML = "Your Report has been submitted !"
                    var x = document.getElementById("snackbar")
                    x.className = "show";
                    setTimeout(function () {
                        x.className = x.className.replace("show", "");
                    }, 6000);
                }
            },
        });
    }); 
    
    $("#quesrpt").on("submit",function(e){
        e.preventDefault();
       var checkedVals = $('.tclass:checkbox:checked').map(function () {
         return this.value;
     }).get();
    var qid = document.getElementById('qid').value;
     var sendval = checkedVals.join(","); 
        $.ajax({
            type: 'post'
            ,url: '/user/quesrpt'
            ,data: {
                v : sendval,
                qid: qid
            }
            ,success: function(response){
                console.log(response);
                if(response == "ok"){
                    document.getElementById('snackbar').innerHTML = "Your Report has been submitted !"
                    var x = document.getElementById("snackbar")
                    x.className = "show";
                    setTimeout(function () {
                        x.className = x.className.replace("show", "");
                    }, 6000);
                }
            },
        });
    });
    
    $(".best-ans").attr('title', 'Best answer');
        
    $(document).ready(function () {
        $(".like,.unlike").on("click", function () {
            var id = $(this).attr('id');
            document.getElementById(id).disabled = true;
            var clr = $('#' + id).css('background-color');
            var split_id = id.split("_");
            var text = split_id[0];
            var ansid = split_id[1];
            var type = 0;
            if (text == "like") {
                if (clr === "rgb(40, 96, 144)" || clr === "rgb(51, 122, 183)") {
                    type = 3;
                    $('#like_' + ansid).removeClass("blue");
                    $('#like_' + ansid).removeClass("btn-primary");
                    $('#like_' + ansid).css('color', 'black');
                    document.getElementById(id).disabled = false;
                }
                else {
                    type = 1;
                }
            }
            else {
                if (clr === "rgb(201, 48, 44)" || clr === "rgb(217, 83, 79)") {
                    type = 4;
                    $('#unlike_' + ansid).removeClass("red");
                    $('#unlike_' + ansid).removeClass("btn-danger");
                    $('#unlike_' + ansid).css('color', 'black');
                    document.getElementById(id).disabled = false;
                }
                else {
                    type = 0;
                }
            }
            $.ajax({
                type: 'post'
                , url: '/vote'
                , data: {
                    ansid: ansid
                    , type: type
                }
                , success: function (data) {
                    if (data == "user") {
                        alert('Not Logged in');
                    }
                    if (data == "like") {
                        document.getElementById(id).disabled = false;
                        $('#' + id).addClass("blue");
                        $('#' + id).css("color", "white");
                        $('#unlike_' + ansid).removeClass("red");
                        $('#unlike_' + ansid).removeClass("btn-danger");
                        $('#unlike_' + ansid).css('color', 'black');
                        $.ajax({
                            type: 'post'
                            , url: '/ques/totalcount'
                            , data: {
                                ansid: ansid
                            }
                            , dataType: 'json'
                            , success: function (data) {
                                document.getElementById('likebadge_' + ansid).innerHTML = data[0];
                                document.getElementById('dislikebadge_' + ansid).innerHTML = data[1];
                            }
                        });
                    }
                    else if (data == "dislike") {
                        document.getElementById(id).disabled = false;
                        $('#' + id).addClass("red");
                        $('#' + id).css("color", "white");
                        $('#like_' + ansid).removeClass("blue");
                        $('#like_' + ansid).removeClass("btn-primary");
                        $('#like_' + ansid).css('color', 'black');
                        $.ajax({
                            type: 'post'
                            , url: '/ques/totalcount'
                            , data: {
                                ansid: ansid
                            }
                            , dataType: 'json'
                            , success: function (data) {
                                document.getElementById('likebadge_' + ansid).innerHTML = data[0];
                                document.getElementById('dislikebadge_' + ansid).innerHTML = data[1];
                            }
                        });
                    }
                    else if (data == 'oka') {
                        $.ajax({
                            type: 'post'
                            , url: '/ques/totalcount'
                            , data: {
                                ansid: ansid
                            }
                            , dataType: 'json'
                            , success: function (data) {
                                document.getElementById('likebadge_' + ansid).innerHTML = data[0];
                                document.getElementById('dislikebadge_' + ansid).innerHTML = data[1];
                            }
                        });
                    }
                    else if (data == "oky") {
                        $.ajax({
                            type: 'post'
                            , url: '/ques/totalcount'
                            , data: {
                                ansid: ansid
                            }
                            , dataType: 'json'
                            , success: function (data) {
                                document.getElementById('likebadge_' + ansid).innerHTML = data[0];
                                document.getElementById('dislikebadge_' + ansid).innerHTML = data[1];
                            }
                        });
                    }
                }
            , });
        });
    });
    $("#anspost").click(function () {
        var id = document.getElementById('ques_id').innerHTML
        var str = document.querySelector(".ql-editor").innerHTML;
        var arr = new Array();
        var c = 0;
        $(".ql-editor img").each(function () {
            arr[c++] = this.src;
        });
        for (i = 0; i < arr.length; i++) {
            var s = arr[i].toString();
            let base64Length = s.length - (s.indexOf(',') + 1);
            let padding = (s.charAt(s.length - 2) === '=') ? 2 : ((s.charAt(s.length - 1) === '=') ? 1 : 0);
            let fileSize = base64Length * 0.75 - padding;
            if (fileSize > 1000000) {
                alert("File Size exceeded Max 1mb");
                return false;
            }
        }
        $.ajax({
            type: 'post'
            , url: '/ansposted'
            , data: {
                id: id
                , cont: str
            }
            , success: function (data) {
                if (data == "ok") {
                    $("#anssite").hide();
                    var x = document.getElementById("snackbar")
                    x.className = "show";
                    setTimeout(function () {
                        x.className = x.className.replace("show", "");
                    }, 6000);
                }
            }
        , });
    });

    function image_resize(qw, qe) {
        $(".showcont img").each(function () {
            $(this).addClass('img-responsive');
            var maxWidth = qw;
            /* Max hieght for the image */
            var maxHeight = qe;
            /* Used for aspect ratio */
            var ratio = 0;
            /* Current image width */
            var width = $(this).width();
            /* Current image height */
            var height = $(this).height();
            /* Check if the current width is larger than the max */
            if (width > maxWidth) {
                /* Get ratio for scaling image */
                ratio = (maxWidth / width);
                /* Set New hieght and width of Image */
                $(this).attr({
                    width: maxWidth
                    , height: (height * ratio)
                , });
                /* Reset height to match scaled image */
                height = (height * ratio);
                /* Reset width to match scaled image */
                width = (width * ratio);
                /* Check if current height is larger than max */
                if (height > maxHeight) {
                    /* Get ratio for scaling image*/
                    ratio = (maxHeight / height);
                    /* Set new height and width */
                    $(this).attr({
                        height: maxHeight
                        , width: (width * ratio)
                    , });
                }
            }
        });
    }
    $(document).ready(function () {
        image_resize(600, 600);
        
        @foreach($answer as $ans)
        var x = "{{\App\Vote::where('ans_id','=',$ans->ans_id)->where('up',1)->count('up')}}";
        document.getElementById('likebadge_{{$ans->ans_id}}').innerHTML = x;
        var y = "{{ \App\Vote::where('ans_id','=',$ans->ans_id)->where('down',1)->count('down') }}";
        document.getElementById('dislikebadge_{{$ans->ans_id}}').innerHTML = y;
        @endforeach
        
        $('#ansreport').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            document.getElementById('aid').value = rowid;
        });
    });
</script> @stop