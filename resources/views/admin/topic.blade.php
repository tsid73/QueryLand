@extends('admin.master') @section('pagetitle','Admin Topic') @section('content')
<!--    -->
<div id="editmenu" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Topic</h4> </div>
            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center text-capitalize">Topic</div>
                    <div class="panel-body">
                        <form action="" class="form-horizontal" method="post" id="edittopic">{{method_field('PATCH')}} {{ csrf_field() }}
                            <div class="form-group">
                                <label for="top" class="control-label">Topic</label>
                                <input type="text" class="form-control" id="top" name="top" value="" required> 
                            </div>
                            <div class="form-group">
                                <label for="tags" class="control-label">Tags</label>
                                <input type="text" class="form-control" id="tags" name="tags" value="" required> 
                                <input type="hidden" class="form-control" id="topid" name="topid" value=""> 
                                </div>
                            <div class="form-group">
                                <button class="btn btn-primary" name="update" role="button" id="update">Update Topic</button>
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
<!--   -->
<div class="box col-lg-10 col-lg-offset-2 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
    <div class="col-lg-5 col-sm-5 col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading text-center text-capitalize"> Topics</div>
            <div class="panel-body">
                <form action="" class="form-horizontal" method="post" id="posttopic"> {{ csrf_field() }}
                    <div class="form-group">
                        <label for="subj" class="control-label">Topic</label>                                               <input type="text" class="form-control" id="tops" name="tops" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="tag" class="control-label">Tags</label>
                        <input type="text" class="form-control" id="tag" name="tag" required> </div>
                    <div class="form-group">
                        <button class="btn btn-primary" name="add" role="button" id="add">Add Topic</button>
                    </div>
                </form>
            </div>
        </div>
        @if(Session::has('msg')) @if(Session::get('msg')==1) <span class="alert alert-warning text-nowrap">Duplicate Entry</span> @else <span class="alert alert-success text-nowrap">Successful</span> @endif @endif
    </div>
    <div class="col-lg-5 col-sm-5 col-md-5">
        <table class="table table-bordered table-condensed table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>Topic</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody> @foreach($result as $results)
                <tr>
                    <td>{{$results->topics}}</td>
                    <td><a href="{{url('/admin/index/topic/del')}}/{{$results->id}}" class="btn">Delete</a></td>
                    <td><a href="#" data-toggle="modal" data-target="#editmenu" data-id='{{$results->id}}' data-cat='{{$results->topics}}' data-tag='{{$results->tags}}' class="btn">Edit</a></td>
                </tr> @endforeach </tbody>
        </table>
    </div>
</div>
@section('script')
<script>
    $('#editmenu').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var cat = $(e.relatedTarget).data('cat');
        var tag = $(e.relatedTarget).data('tag');
        document.getElementById('topid').value = id;
        document.getElementById('top').value = cat;
        document.getElementById('tags').value = tag;
        });
    
    
    $(document).ready(function () {
        $("#edittopic").validate({
            rules: {
                top: {
                    minlength: 5
                }
                , tags: {
                    minlength: 3
                }
            }
            , messages: {
                top: {
                    minlength: "Your Title must consist of at least 5 characters"
                }
                , tags: {
                    minlength: "Your tags must be at least 3 characters long"
                }
            , }
        });
    });
    
    $(document).ready(function () {
        $("#posttopic").validate({
            rules: {
                tops: {
                    minlength: 5
                }
                , tag: {
                    minlength: 3
                }
            }
            , messages: {
                tops: {
                    minlength: "Your Title must consist of at least 5 characters"
                }
                , tag: {
                    minlength: "Your tags must be at least 3 characters long"
                }
            , }
        });
    });
    
</script> @endsection @endsection