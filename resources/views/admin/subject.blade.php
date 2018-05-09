@extends('admin.master') @section('pagetitle','Admin Subject') @section('content')
<div id="editmenu" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Category</h4> </div>
            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center text-capitalize"> Subjects</div>
                    <div class="panel-body">
                        <form action="" class="form-horizontal" method="post" id="menuedit">{{method_field('PATCH')}} {{ csrf_field() }}
                            <div class="form-group">
                                <label for="sub" class="control-label">Subject Name</label>
                                <input type="text" name="sub" id="sub" pattern=".{3,}" class="form-control" required> </div>
                            <div class="form-group">
                                <label for="tag" class="control-label">Tags</label>
                                <input type="text" class="form-control" id="tag" name="tag" required>
                                <input type="hidden" class="form-control" id="sid" name="sid" value=""> </div>
                            <div class="form-group">
                                <button class="btn btn-primary" name="update" role="button" id="update">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box col-lg-10 col-lg-offset-2 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
    <div class="col-lg-5 col-sm-5 col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading text-center text-capitalize"> Subjects</div>
            <div class="panel-body">
                <form action="" class="form-horizontal" method="post" id="menu"> {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title" class="control-label">Subject Name</label>
                        <input type="text" class="form-control" id="title" name="title" value="" required> </div>
                    <div class="form-group">
                        <label for="tags" class="control-label">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags" value="" required> </div>
                    <div class="form-group">
                        <button class="btn btn-primary" name="add" role="button" id="add">Add Subject</button>
                    </div>
                </form>
            </div>
        </div> @if(Session::has('msg')) @if(Session::get('msg')==1) <span class="alert alert-warning text-nowrap">Duplicate Entry</span> @else <span class="alert alert-success text-nowrap">Successful</span> @endif @endif
         @if(Session::has('msgs'))
         @if(Session::get('msgs')==1) <span class="alert alert-warning text-nowrap">Subject is Used in Questions</span> @else <span class="alert alert-success text-nowrap">Successful</span>
        Session::forget('msgs');
         @endif
          @endif </div>
    <div class="col-lg-5 col-sm-5 col-md-5">
        <table class="table table-bordered table-condensed table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>Subject Id</th>
                    <th>Subject Name</th>
                    <th>Tags</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody> @foreach($result as $results)
                <tr>
                    <td>{{$results->subject_id}}</td>
                    <td>{{$results->subj_name}}</td>
                    <td>{{$results->tag}}</td>
                    <td><a href="{{url('admin/index/subject')}}?delete={{$results->subject_id}}" class="btn">Delete</a></td>
                    <td><a href="#" data-toggle="modal" data-target="#editmenu" data-id='{{$results->subject_id}}' data-name='{{$results->subj_name}}' data-tag='{{$results->tag}}' class="btn">Edit</a></td>
                </tr> @endforeach </tbody>
        </table>
    </div>
</div> @if(isset($_GET['delete']))
<form action="" method="post" id="formsubmit"> {{method_field('Delete')}} {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$_GET['delete']}}">
    <button type="submit" name="submit" id="submit"></button>
</form> @section('script')
<script>
    document.getElementById('submit').click();
</script> @stop @endif @section('script')
@if(Session::has('msgs'))
         @if(Session::get('msgs')==1)
         <script>
    var url = window.location.href;
    window.location.href = url.split('?')[0];
             Session::forget('msgs');
         </script>
         @endif
          @endif
<script>
    $('#editmenu').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var sub = $(e.relatedTarget).data('name');
        var tag = $(e.relatedTarget).data('tag');
        document.getElementById('sid').value = id;
        document.getElementById('sub').value = sub;
        document.getElementById('tag').value = tag;
    });
    $('#title,#sub').keypress(function (e) {
        var regex = new RegExp("^[A-Za-z]+$");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $('#tag,#tags').keypress(function (e) {
        var regex = new RegExp("^[A-Za-z? ,-]+$");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
</script> @endsection @endsection