@extends('admin.master')
@section('pagetitle','Admin Users')
@section('content')
@php 
echo "<script>
    localStorage.removeItem('url');
var u = window.location.href;
    localStorage.setItem('url',u);
</script>
";
@endphp
  <div id="filtering" style="width: 250px; float:right;">
        <div class="input-group-sm">
            <label for="filter">Search</label>
            <input type="text" class="form-control" name="filter" id="filter" onkeyup="myFun()" placeholder="User or Email"> </div>
    </div>
<div class="h3">Total {{$result->total()}} users</div>
<div class="h5">In this page - {{$result->count()}}</div>
 
<table id="myTable" class="table table-bordered table-condensed table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th>User id</th>
            <th>User's name</th>
            <th>Email</th>
            <th>User Xp</th>
            <th>User's Level</th>
            <th>User's field</th>
            <th>User pic</th>
            <th>Created at</th>
            <th>Delete</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody> @foreach($result as $results)
        <tr>
            <td>{{ $results->user_id }}</td>
            @if(empty($results->name))
            <td>{{$results->username}}</td>
            @else
            <td>{{$results->name}}</td>
            @endif
            <td>{{ $results->email }}</td>
            <td>{{ $results->user_xp}}</td>
            <td>{{ $results->user_level}}</td>
            <td>{{ $results->user_field}}</td>
            <td><img src="{{$results->user_pic}}" alt="" height="50px" width="50px" class="img-thumbnail"></td> 
            <td>{{$results->created_at}}</td>
            <td>
                <a href="{{url('admin/index/users')}}?delete={{$results->user_id}}" class="btn">Delete</a>
            </td>
            <td>
                <a href="/user/profile/{{$results->username}}" class="btn">View</a>
            </td>
        </tr> @endforeach </tbody>
</table> 
{{$result->links()}} 
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
@section('script')
<script>
function myFun() {
        // Declare variables 
        var input, filter, table, tr, td, tdd, i;
        input = document.getElementById("filter");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            tdd = tr[i].getElementsByTagName("td")[2];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || tdd.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                }
                else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@stop
@endsection
