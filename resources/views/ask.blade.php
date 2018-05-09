@extends('templates.master') @section('pagetitle','Ask') @section('css')
<style>
    .mr-top {
        margin-top: 40px;
    }
</style> @stop @section('content')
<div class="row mr-top">
    @if(session()->has('id'))
    <div class="alert alert-success text-center">Question  sent to admin for review and will be posted afterwards.</div> @endif
    <div class="col-lg-7 col-sm-8 col-lg-offset-1">
        <div id="er" class="alert alert-success" style="display:none;"></div>
        <div class="panel panel-primary">
            <div class="panel-heading"> Question </div>
            <div class="panel-body" id="reloadup">
                <form action="" method="post" class="form-horizontal" id="getdata"> {{ csrf_field() }}
                        <label for="title">Question Title</label>
                        <input type="text" class="form-control" name="title" id="title" maxlength="190" autofocus>
                    <br>
                        <div style="display:none;">{{ $result = \App\Subject::all()}}</div>
                        <label for="opt">Choose Subject</label>
                        <div style="width:200px;">
                        <select name="opt" id="options" class="form-control" onchange="getsub()">
                            <option value="" hidden>Select</option> @foreach($result as $results)
                            <option value="{{$results->subject_id}}">{{$results->subj_name}}</option> @endforeach </select>
                        </div>
                    <br>
                       <div style="width:200px;">
                        <label for="subopt">Choose Sub Category</label>
                        <select name="subopt" id="suboption" class="form-control">
                            <option value="" hidden>Select Sub Category</option>
                        </select>
                    </div>
                    <br>
                        <label for="content">Question Content</label>
                        <div id="toolbar"></div>
                        <div id="editor"></div>
                        <textarea id="cont" name="cont" cols="40" rows="5" style="display:none;"></textarea>
                        <label for="tag">Tags(max 5)</label>
                        <input type="text" name="tag" id="tag" class="form-control" required>
                    <br>
                    <div class="input-group-btn">
                        <input class="btn btn-primary" type="submit" value="Ask Question" name="submit" id="ask"> </div>
                </form> @if(Session::get('msg')==1)
                <div id="msg"><span class="alert alert-success">Successfully sent to admin</span></div> @endif </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-3"> 
    <div class="h4">Instructions</div>
    <div>
<p>1.Question images should be legible.</p>
<p>2.Question images should be maximum size of 1mb.</p>
<p>3.Question images posted must have a Question Subject and the related tags.</p>
<p>4.Question images should be clear enough or else it will be discarded.</p>
<p>5.Tags must be separated with either Space or Comma.</p>
<p>6.Tags can be combined using hypen(-).</p>
<p>7.Ask as much as you can....!!!</p>
    </div>
      </div>
</div> @section('script')
<script>
</script>
<script>
    $('#tag').keypress(function (e) {
    var regex = new RegExp("^[A-Za-z? ,-]+$");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
    });
    $("#getdata").submit(function (e) {
        var str = document.querySelector(".ql-editor").innerHTML;
//        console..log(str);
        var arr = new Array();
        var c = 0;
        $("img").each(function () {
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
        document.getElementById("cont").value = str;
    });

    function getsub() {
        var sub = document.getElementById('options').value;
        $.ajax({
            type: 'post'
            , url: '/getsubcat'
            , data: {
                subj: sub
            }
            , dataType: 'json'
            , success: function (data) {
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