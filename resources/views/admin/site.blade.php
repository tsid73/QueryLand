@extends('admin.master') @section('pagetitle','Admin Site') @section('content') @if(session()->has('status'))
<div class="{{session()->get('status')}} text-center">Updation was Successful</div> @endif
@if(empty($result))
<div class="box col-lg-8 col-lg-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading text-center text-capitalize"> Site Content </div>
        <div class="panel-body">
            <form action="" class="form-horizontal" method="post" id="siteform"> {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="">
                    <label for="title" class="control-label">Site Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="" required> </div>
                <div class="form-group">
                    <label for="desc" class="control-label">Site Description</label>
                    <textarea name="desc" id="desc" rows="4" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="footer" class="control-label">Site Footer</label>
                    <input type="text" class="form-control" id="footer" name="footer" value="" required> </div>
                <br>
                <div class="form-group">
                    <label for="file">Choose Your Logo</label>
                    <input type="file" name="img" id="img" value="" required>
                    <br> <img src="" alt="" height="150px" width="150px" class="img-circle img-thumbnail" id="pro">
                    <input type="hidden" name="up" id="b64" value=""> </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="update" type="submit" id="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<div class="box col-lg-8 col-lg-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading text-center text-capitalize"> Site Content </div>
        <div class="panel-body">
            <form action="" class="form-horizontal" method="post" id="siteform"> {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{$result->site_id}}">
                    <label for="title" class="control-label">Site Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{$result->site_name}}" required> </div>
                <div class="form-group">
                    <label for="desc" class="control-label">Site Description</label>
                    <textarea name="desc" id="desc" rows="4" class="form-control" required>{{$result->site_description}}</textarea>
                </div>
                <div class="form-group">
                    <label for="footer" class="control-label">Site Footer</label>
                    <input type="text" class="form-control" id="footer" name="footer" value="{{$result->footer}}" required> </div>
                <br>
                <div class="form-group">
                    <label for="file">Choose Your Logo</label>
                    <input type="file" name="img" id="img" value="" required>
                    <br> <img src="{{$result->logo}}" alt="" height="150px" width="150px" class="img-circle img-thumbnail" id="pro">
                    <input type="hidden" name="up" id="b64" value=""> </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="update" role="button" id="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div> @stop @section('script')
<script>
    function readFile() {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/jpeg", "image/png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert('The image should be either JPEG/PNG');
            return false;
        }
        if (this.files && this.files[0]) {
         var FR = new FileReader();
         FR.addEventListener("load", function (e) {
        arr = e.target.result;
        var s = arr.toString();
         let base64Length = s.length - (s.indexOf(',') + 1);
         let padding = (s.charAt(s.length - 2) === '=') ? 2 : ((s.charAt(s.length - 1) === '=') ? 1 : 0);
         let fileSize = base64Length * 0.75 - padding;
         if (fileSize > 1000000) {
             alert("File Size exceeded Max 1mb");
             return false;
         }
             document.getElementById("pro").src = e.target.result;
             document.getElementById("b64").value = e.target.result;
         });
         FR.readAsDataURL(this.files[0]);
     }
    }
    
    document.getElementById("img").addEventListener("change", readFile);
    
    $('#title').keypress(function (e) {
        var regex = new RegExp("^[A-Za-z? -]+$");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $(document).ready(function () {
        $("#siteform").validate({
            rules: {
                title: {
                    required: true
                    , minlength: 5
                }
                , desc: {
                    required: true
                    , minlength: 6
                }
                , footer: {
                    required: true
                    , minlength: 8
                }
            }
            , messages: {
                title: {
                    required: "Please enter a Title"
                    , minlength: "Your Title must consist of at least 5 characters"
                }
                , desc: {
                    required: "Please provide a Description"
                    , minlength: "Your Description must be at least 6 characters long"
                }
                , footer: {
                    required: "Please provide a Footer"
                    , minlength: "Your Footer must be at least 6 characters long"
                }
            , }
        });
    });
</script> @stop