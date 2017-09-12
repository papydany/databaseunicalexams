@extends('layouts.admin')
@section('title','PDS New Course')
@section('content')
 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">View Courses</div>
                <div class="panel-body">
                 @if(isset($c))
                        @if(count($c) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>First semester Code</th>
                    
                         <th>Second Semester Code</th>
                        <th>Action</th>
                       </tr>
                       {{!!$cc = 0}}
                       @foreach($c as $v)
                       <tr>
                       <td>{{++$cc}}</td>
                       <td>{{$v->course_title}}</td>
                       <td>{{$v->f_course_code}}</td>
                      
                       <td>{{$v->s_course_code}}
                     </td>
                       <td><div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Edit</a></li>
    
  </ul>
</div></td>
                       </tr>
                       @endforeach
                        </table>

                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>


@endsection