@extends('layouts.admin')
@section('title','Registered Students')
@section('content')
 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                      
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
 <div class="row" style="min-height: 520px;">
        <div class="col-sm-12" >
            <div class="panel panel-default">
                <div class="panel-heading">Mail</div>
                @if(isset($c))

                @if(count($c) > 0)
                <table class="table table-bordered table-stripe">
                	<tr>
                		<th>S/N</th>
                		<th>Matric Number</th>
                        <th>Phone</th>
                		<th>Email</th>
                		<th>Dates</th>
                		<th>Action</th>
                		<th>Status</th>
                	</tr>
                	{{!! $i =0}}
                	@foreach($c as $v)
<tr>
                		<td>{{++$i}}</td>
                		<td>{{$v->matric_number}}</td>
                        <td>{{$v->phone}}</td>
                		<td>{{$v->email}}</td>
                		<td>{{$v->created_at}}</td>
                		<td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal{{$i}}">View Details</button></td>
                		<td>Status</td>
                	</tr>

                	<div id="myModal{{$i}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/replyemail') }}" data-parsley-validate>
                        {{ csrf_field() }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$v->matric_number}}</h4>
      </div>
      <div class="modal-body">
        <p>{{$v->message}}</p>
        <p>Reply</p>
        <input type="hidden"  name="id" value="{{$v->id}}">
        <input type="text" class="form-control" name="email" value="{{$v->email}}" required>
        <br/>
        <textarea class="form-control" rows="10" name="reply" required=""></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-success">submit</button>
      </div>
  </form>
    </div>

  </div>
</div>
                	@endforeach
                	
                </table>



                @endif


                @endif
            </div>
        </div>
    </div>

@endsection  