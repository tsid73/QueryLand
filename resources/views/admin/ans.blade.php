@extends('admin.master') @section('pagetitle','Admin Answers') @section('css')
<style>
    @media screen and (min-width: 768px) {
        .modal-dialog {
            width: auto;
        }
    }
    
    .context {
        margin: 15px;
    }
    
    .flexbox {
        display: flex;
        justify-content: space-between;
    }
    
</style> @stop @section('content')
<!--    -->
<div id="ansview" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Ans</h4> </div>
            <div class="modal-body">
                <div class="fetched-data" style="max-width:600px;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--   -->
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
<div class="h3">Total {{$result->total()}} answers</div>
<div class="h5">In this page - {{$result->count()}}</div>
<table id="myTable" class="table table-bordered table-striped table-hover table-responsive context">
    <thead>
        <tr>
            <th>Ans Id</th>
            <th>Ques Title</th>
            <th>Ans Content</th>
            <th>Upvotes</th>
            <th>Downvotes</th>
            <th>Num of Comments</th>
            <th>Status</th>
            <th>User</th>
            <th>Created at</th>
            <th>Disapprove</th>
            <th>Approve</th>
            <th>Delete</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody> @foreach($result as $results)
        <tr>
            <td>{{ $results->ans_id }}</td>
            <td>{{ $results->ques_heading}}</td> @if(strlen($results->ans_content)>80)
            <td><b>Content too long Click on View to Check</b></td> @else
            <td>{!! $results->ans_content !!}</td> @endif
            <td>{{ $results->up}}</td>
            <td>{{ $results->down}}</td>
            <td>{{ $results->num_of_comments}}</td>
            <td>{{ $results->status}}</td>
            <td>{{$results->username}}</td> 
            <td>{{ \Carbon\Carbon::parse($results->created_at,'Asia/Kolkata')}}</td>
            <td> <a href="{{ url('admin/index/answers') }}?disapprove={{$results->ans_id}}" class="btn @php if($results->status==0){ echo 'disabled'; }@endphp">Disapprove</a> </td>
            <td> <a href="{{ url('admin/index/answers') }}?approve={{$results->ans_id}}" class="btn @php if($results->status==1){ echo 'disabled'; }@endphp">Approve</a> </td>
            <td> <a href="{{ url('admin/index/answers') }}?delete={{$results->ans_id}}" class="btn">Delete</a> </td>
            <td>
                <button class="btn" id="view" data-toggle="modal" data-target="#ansview" data-id='{{$results->ans_id}}'>View</button>
            </td>
        </tr> @endforeach </tbody>
</table> 
{{$result->links()}} 
@if(isset($_GET['delete']))
<form action="" method="post" id="formsubmit"> {{method_field('DELETE')}} {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$_GET['delete']}}">
    <button type="submit" name="submit" id="submit" style="/display:none;"></button>
</form> @section('script')
<script>
    document.getElementById('submit').click();
</script> @stop @endif @if(isset($_GET['approve']))
<form action="" method="post" id="formsubmit"> {{method_field('PATCH')}} {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$_GET['approve']}}">
    <button type="submit" name="submit" id="submit" style="display:none;"></button>
</form> @section('script')
<script>
    document.getElementById('submit').click();
</script> @stop @endif @if(isset($_GET['disapprove']))
<form action="" method="post" id="formsubmit"> {{method_field('PUT')}} {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$_GET['disapprove']}}">
    <button type="submit" name="submit" id="submit" style="display:none;"></button>
</form> @section('script')
<script>
    document.getElementById('submit').click();
</script> @stop @endif @section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        $('#ansview').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
//            alert(rowid);
            $.ajax({
                type: 'post'
                , url: '/admin/index/answers'
                , data: 'rowid=' + rowid
                , success: function (data) {
                    localStorage.setItem("data", data);
                    var va = localStorage.getItem("data");
                    $('.fetched-data').html(va);
                    localStorage.removeItem('data');
                }
            });
        });
    });
    $(document).ready(function () {
        image_resize();
    })

    function image_resize() {
        $("img").each(function () {
            /* Max width for the image */
            var maxWidth = 500;
            /* Max hieght for the image */
            var maxHeight = 500;
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
            }
        });
    }
    
    function sortTable() {
        var e = document.getElementById("sorting");
        var op = e.value;
        if (op == 1) {
            sorthead();
        }
        else if (op == 2) {
            sortdate();
        }
        else if(op==3)
            {
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