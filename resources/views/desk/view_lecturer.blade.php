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
                        <th>Password</th>
                        <th>Action</th>
                  
                       </tr>
                       {{!!$c = 0}}
                       @foreach($l as $v)
                       <tr>
                       <td>{{++$c}}</td>
                         <td>{{$v->title}}</td>
                       <td>{{$v->name}}</td>
                       <td>{{$v->username}}</td>
                       <td>{{$v->plain_password}}</td>
                       <td><div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('edit_lecturer',$v->id)}}">Edit</a></li>
    
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