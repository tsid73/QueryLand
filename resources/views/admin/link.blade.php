@extends('admin.master') @section('pagetitle','Admin Links') @section('content')
<div class="box col-lg-10 col-lg-offset-2 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
    <div class="col-lg-6 col-sm-6 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading text-center text-capitalize"> Navigation Links </div>
            <div class="panel-body">
                <form action="" class="form-horizontal" method="post">
                   {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title" class="control-label">Link Name</label>
                        <input type="text" class="form-control" id="title" name="title" value=""> </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Link Address</label>
                        <input type="text" class="form-control" id="address" name="address" value=""> </div>
                    <div class="form-group">
                        <button class="btn btn-primary" name="add" role="button" id="add">Add Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
       <div class="col-lg-4 col-sm-4 col-md-4">
        <table class="table table-bordered table-condensed table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>Link Id</th>
                    <th>Link Name</th>
                    <th>Link Address</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody> @foreach($result as $results)
                <tr>
                    <td>{{$results->link_id}}</td>
                    <td>{{$results->link_name}}</td>
                    <td>{{$results->link_href}}</td>
                    <td><a href="{{url('admin/index/link')}}?delete={{$results->link_id}}" class="btn">Delete</a></td>
                </tr> @endforeach </tbody>
        </table>
    </div>
</div>
@if(isset($_GET['delete']))
<form action="" method="post" id="formsubmit"> {{method_field('Delete')}} {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$_GET['delete']}}">
    <button type="submit" name="submit" id="submit"></button>
</form> 
@section('script')
<script>
    document.getElementById('submit').click();
</script>
@stop
@endif
@endsection