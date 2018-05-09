@extends('admin.master') @section('pagetitle','Admin Subject Category') @section('css')
<style>
    .alert {
        padding: 15px 10px;
    }
    
    @media screen (max-width: 768px) {
        .alert {
            padding: 15px 10px;
        }
    }
</style> @stop @section('content')
<!--    -->
<div id="editmenu" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Category</h4> </div>
            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center text-capitalize"> Subjects Category</div>
                    <div class="panel-body">
                        <form action="" class="form-horizontal" method="post" id="editcat">{{method_field('PATCH')}} {{ csrf_field() }}
                            <div class="form-group">
                                <label for="subj" class="control-label">Subject Name</label>
                                <select name="subj" id="subj" class="form-control"> @foreach($re as $res)
                                    <option value="{{$res->subject_id}}">{{$res->subj_name}}</option> @endforeach </select>
                            </div>
                            <div class="form-group">
                                <label for="cat" class="control-label">Category</label>
                                <input type="text" class="form-control" id="cat" name="cat" pattern=".{3,}" required>
                                <input type="hidden" class="form-control" id="catid" name="catid" value=""> </div>
                            <div class="form-group">
                                <button class="btn btn-primary" name="update" role="button" id="update">Update Category</button>
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
<div class="box col-lg-11 col-lg-offset-1 col-sm-11 col-sm-offset-1 col-md-11 col-md-offset-1">
    <div class="col-lg-4 col-sm-4 col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center text-capitalize"> Subjects Category</div>
            <div class="panel-body">
                <form action="" class="form-horizontal" method="post"> {{ csrf_field() }}
                    <div class="form-group">
                        <label for="subj" class="control-label">Subject Name</label>
                        <select name="subj" id="subj" class="form-control"> @foreach($re as $res)
                            <option value="{{$res->subject_id}}">{{$res->subj_name}}</option> @endforeach </select>
                    </div>
                    <div class="form-group">
                        <label for="cat" class="control-label">Category</label>
                        <input type="text" class="form-control" id="cats" name="cat" pattern=".{3,}" required> </div>
                    <div class="form-group">
                        <button class="btn btn-primary" name="add" role="button" id="add">Add Category</button>
                    </div>
                </form>
            </div>
        </div> @if(Session::has('msg')) @if(Session::get('msg')==1) <span class="alert alert-warning text-nowrap">Duplicate Entry</span> @else <span class="alert alert-success text-nowrap">Successful</span> @endif @endif </div>
    <div class="col-lg-5 col-sm-5 col-md-5">
        <div style="display:none;"> {{$s = \App\Http\Controllers\BasicController::showsubject()}} </div>
        <label for="subject">Show only</label>
        <select onchange="selectsub()" name="subject" id="subject">
            <option value="">Select Subject</option> @foreach($s as $sub)
            <option value="{{$sub['subj_name']}}">{{$sub['subj_name']}}</option> @endforeach </select>
        <br>
        <br>
        <table id="myTable" class="table table-bordered table-condensed table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Category</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody> @foreach($result as $results)
                <tr>
                    <td>{{$results->subj_name}}</td>
                    <td>{{$results->category}}</td>
                    <td><a href="{{url('admin/index/sub_cat')}}?delete={{$results->sub_cat}}" class="btn">Delete</a></td>
                    <td><a href="#" data-toggle="modal" data-target="#editmenu" data-id='{{$results->sub_cat}}' data-cat='{{$results->category}}' class="btn">Edit</a></td>
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
<script>    
    $('#editmenu').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var cat = $(e.relatedTarget).data('cat');
        document.getElementById('catid').value = id;
        document.getElementById('cat').value = cat;
    });

    function selectsubcat() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("subjectcat");
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

    function selectsub() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("subject");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
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
            
     $('#cats,#cat').keypress(function (e) {
     var regex = new RegExp("^[A-Za-z? ]+$");
     var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
     if (!regex.test(key)) {
         event.preventDefault();
         return false;
     }
 });
    
</script> @endsection @endsection