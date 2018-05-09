@extends('admin.master') 
@section('pagetitle','Admin Reports') 
@section('css')
<style>
    .context {
        margin: 15px;
    }
    
    .flexbox {
        display: flex;
        justify-content: space-between;
    }
</style> @stop @section('content')
<div class="flexbox">
    <div id="sorty">
        <label for="sorting">Show only</label>
        <select class="form-control" onchange="selectsub()" name="qora" id="qora">
                <option value="">Select Ques or Ans</option>
                <option value="1">Ques</option>
                <option value="2" >Ans</option>
        </select>
    </div>
    <div id="filtering">
        <div class="input-group-sm">
            <label for="filter">Search</label>
            <input type="text" class="form-control" name="filter" id="filter" onkeyup="myFun()" placeholder="QorA or User"> </div>
    </div>
</div>
<div class="h3">Total {{$result->total()}} reports</div>
<div class="h5">In this page - {{$result->count()}}</div>
<table id="myTable" class="table table-bordered table-condensed table-striped table-hover table-responsive context">
    <thead>
        <tr>
            <th>Report Id</th>
            <th>Ques or Ans</th>
            <th>Content</th>
            <th>User</th>
            <th>Created at</th>
            <th>Delete</th>
            <th>Mark</th>
        </tr>
    </thead>
    <tbody> @foreach($result as $results)
        <tr>
            <td>{{ $results->rid }}</td>
            <td>{{ $results->QorA}}</td> 
            <td>{{ $results->content}}</td>
            <td>{{$results->username}}</td>
            <td>{{ \Carbon\Carbon::parse($results->created_at,'Asia/Kolkata')->format('Y-m-d')}}</td>
            <td> <a href="{{url('admin/index/report/delete')}}/{{$results->rid}}" class="btn">Delete</a> </td>
            <td> <a href="{{ url('admin/index/report/mark')}}/{{$results->rid}}" class="btn">Mark as Read</a> </td>
        </tr> @endforeach </tbody>
</table> 
{{$result->links()}}
@section('script')
<script>
    function selectsub() {
        // Declare variables 
        var input, filter, table, tr, td, i;
        input = document.getElementById("qora");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                }
                else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
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
            tdd = tr[i].getElementsByTagName("td")[3];
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
@stop @stop