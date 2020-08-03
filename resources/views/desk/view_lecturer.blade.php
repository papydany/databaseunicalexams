@extends('layouts.admin')
@section('title','View lecturer')
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
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">View Lecturer</div>
                <div class="panel-body">
                   
                        @if(isset($l))
                        @if(count($l) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                          <th>Title</th>
                        <th>Name</th>
                         <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                        <th>Edit Right Status</th>
                       <th>Edit Right</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($l as $v)
                       <tr>
                       <td>{{++$c}}</td>
                         <td>{{$v->title}}</td>
                       <td>{{$v->name}}</td>
                       <td>{{$v->username}}</td>
                       <td>{{$v->email}}</td>
                       <td><div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('edit_lecturer',$v->id)}}">Edit</a></li>
    
  </ul>
</div></td>
<td>{{$v->edit_right}}</td>
<td><div class="btn-group">
  <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Enabled <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('/edit_right',[$v->id,0])}}">0</a></li>
    <li><a href="{{url('/edit_right',[$v->id,6])}}">6</a></li>
    <li><a href="{{url('/edit_right',[$v->id,8])}}">8</a></li>
    <li><a href="{{url('/edit_right',[$v->id,10])}}">10</a></li>
    <li><a href="{{url('/edit_right',[$v->id,12])}}">12</a></li>

  </ul>
</div></td>
       

                       </tr>
                       @endforeach
                     
                        </table>
  {{ $l->links() }}

                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      