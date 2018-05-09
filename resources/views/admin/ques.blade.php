@extends('admin.master') @section('pagetitle','Admin Questions') @section('css')
<style>
    .context {
        margin: 15px;
    }
    
    .flexbox {
        display: flex;
        justify-content: space-between;
    }
    
    #sorty {
        width: 550px;
        display: flex;
        justify-content: space-between;
    }
</style> @stop @section('content')
<div class="flexbox">
    <div id="sorty">
        <div>
            <label for="sorting">Sort By</label>
            <select class="form-control" onchange="sortTable()" name="sorting" id="sorting">
                <option value="" hidden>Sort By</option>
                <option value="1">Sort By Name(ASC)</option>
                <option value="3">Sort By Name(DESC)</option>
                <option value="2">Sort By Date</option>
            </select>
        </div>
        <div>
        <div style="display:none;"> {{$s = \App\Http\Controllers\BasicController::showsubject()}} </div>
            <label for="subject">Show only</label>
            <select class="form-control" onchange="selectsub()" name="subject" id="subject">
                <option value="">Select Subject</option> @foreach($s as $sub)
                <option value="{{$sub['subj_name']}}">{{$sub['subj_name']}}</option> @endforeach </select>
        </div>
        <div>
            <div style="display:none;"> {{$s = \App\Http\Controllers\BasicController::showsubjectcat()}} </div>
            <label for="subjectcat">Show Only</label>
            <select class="form-control" onchange="selectsubcat()" name="subjectcat" id="subjectcat">
                <option value="">Select Subject Category</option> @foreach($s as $sub)
                <option value="{{$sub->category}}">{{$sub->category}}</option> @endforeach </select>
        </div>
    </div>
    <div id="filtering">
        <div class="input-group-sm">
            <label for="filter">Search</label>
            <input type="text" class="form-control" name="filter" id="filter" onkeyup="myFun()" placeholder="Heading or User"> </div>
    </div>
</div>
@php 
echo "<script>
    localStorage.removeItem('url');
var u = window.location.href;
    localStorage.setItem('url',u);
</script>
";
@endphp
<div class="h3">Total {{$result->total()}} questions</div>
<div class="h5">In this page - {{$result->count()}}</div>
<table id="myTable" class="table table-bordered table-striped table-hover table-responsive context">
    <thead>
        <tr>
            <th>Ques Id</th>
            <th>Ques Title</th>
            <th>Ques Content</th>
            <th>tags</th>
            <th>Ques Views</th>
            <th>No of Ans</th>
            <th>Status</th>
            <th>Subject</th>
            <th>Sub Category</th>
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
            <td>{{ $results->ques_id }}</td>
            <td>{{ $results->ques_heading}}</td> @if(strlen($results->ques_content)>80)
            <td><b>Content too long Click on View to Check</b></td> @else
            <td>{!! $results->ques_content !!}</td> @endif
            <td>{{ $results->tags}}</td>
            <td>{{ $results->ques_views}}</td>
            <td>{{ $results->num_of_ans}}</td>
            <td>{{ $results->status}}</td>
            <td>{{$results->subj_name}}</td>
            <td>{{$results->category}}</td>
            <td>{{$results->username}}</td>
            <td>{{\Carbon\Carbon::parse($results->created_at,'Asia/Kolkata')}}</td>
            <td> <a href="{{ url('admin/index/questions') }}?disapprove={{$results->ques_id}}" class="btn @php if($results->status==0){ echo 'disabled'; }@endphp">Disapprove</a> </td>
            <td> <a href="{{ url('admin/index/questions') }}/approve/{{$results->ques_id}}" class="btn @php if($results->status==1){ echo 'disabled'; }@endphp">Approve</a> </td>
            <td> <a href="{{ url('admin/index/questions') }}?delete={{$results->ques_id}}" class="btn">Delete</a> </td>
            <td> <a href="{{route('questions',$results->slug)}}" target="_blank" class="btn">View</a> </td>
        </tr> @endforeach </tbody>
</table>
 {{$result->links()}} 
 @if(isset($_GET['delete']))
<form action="" method="post" id="formsubmit"> {{method_field('delete')}} {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$_GET['delete']}}">
    <button type="submit" name="submit" id="submit" style="display:none;"></button>
</form> @endif @if(isset($_GET['disapprove']))
<form action="" method="post" id="formsubmit"> {{method_field('PATCH')}} {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$_GET['disapprove']}}">
    <button type="submit" name="submit" id="submit" style="display:none;"></button>
</form> @endif @section('script')
<script>
    document.getElementById('submit').click();
</script>
<script src="{{asset('js/cmsques.js')}}"></script>
  @stop @endsection