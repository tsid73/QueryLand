@extends('admin.master') @section('pagetitle','Admin Comments') @section('css')
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
        <label for="sorting">Sort By</label>
        <select class="form-control" onchange="sortTable()" name="sorting" id="sorting">
            <option value="" hidden>Sort By</option>
            <option value="1">Sort By Name(ASC)</option>
            <option value="3">Sort By Name(DESC)</option>
            <option value="2">Sort By Date</option>
        </select>
    </div>
    <div id="filtering">
        <div class="input-group-sm">
            <label for="filter">Search</label>
            <input type="text" class="form-control" name="filter" id="filter" onkeyup="myFun()" placeholder="Heading or User"> </div>
    </div>
</div>
<div class="h3">Total {{$result->total()}} comments</div>
<div class="h5">In this page - {{$result->count()}}</div>
<table id="myTable" class="table table-bordered table-condensed table-striped table-hover table-responsive context">
    <thead>
        <tr>
            <th>Comment Id</th>
            <th>Ques Title</th>
            <th>Ans Content</th>
            <th>Comment</th>
            <th>User</th>
            <th>Created at</th>
            <th>Delete</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody> @foreach($result as $results)
        <tr>
            <td>{{ $results->comment_id }}</td>
            <td>{{ $results->ques_heading}}</td> @if(strlen($results->ans_content)>80)
            <td><b>Content too long Click on View to Check</b></td> @else
            <td>{!! $results->ans_content !!}</td> @endif @if(strlen($results->comment_body)>150)
            <td><b>Content too long Click on View to Check</b></td> @else
            <td>{{ $results->comment_body}}</td> @endif
            <td>{{$results->username}}</td>
            <td>{{ \Carbon\Carbon::parse($results->created_at,'Asia/Kolkata')->format('Y-m-d')}}</td>
            <td> <a href="{{url('admin/index/comments')}}?delete={{$results->comment_id}}" class="btn">Delete</a> </td>
            <td> <a href="{{route('questions',$results->slug)}}" class="btn">View</a> </td>
        </tr> @endforeach </tbody>
</table> 
{{$result->links()}} 
@if(isset($_GET['delete']))
<form action="" method="post" id="formsubmit"> {{method_field('Delete')}} {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$_GET['delete']}}">
    <button type="submit" name="submit" id="submit"></button>
</form> @section('script')
<script>
    document.getElementById('submit').click();
</script> @stop @endif @section('script')
<script>
    function sortTable() {
        var e = document.getElementById("sorting");
        var op = e.value;
        if (op == 1) {
            sorthead();
        }
        else if (op == 2) {
            sortdate();
        }
        else if (op == 3) {
            sortheaddesc();
        }
    }

    function sorthead() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("myTable");
        switching = true;
        /*Make a loop that will continue until
        no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[1];
                y = rows[i + 1].getElementsByTagName("TD")[1];
                //check if the two rows should switch place:
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    function sortheaddesc() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("myTable");
        switching = true;
        /*Make a loop that will continue until
        no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[1];
                y = rows[i + 1].getElementsByTagName("TD")[1];
                //check if the two rows should switch place:
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    function sortdate() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("myTable");
        switching = true;
        /*Make a loop that will continue until
        no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[8];
                y = rows[i + 1].getElementsByTagName("TD")[8];
                //check if the two rows should switch place:
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
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
            tdd = tr[i].getElementsByTagName("td")[7];
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
</script> @stop @endsection