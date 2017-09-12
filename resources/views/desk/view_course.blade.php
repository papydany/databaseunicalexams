@extends('layouts.admin')
@section('title','View Course')
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
                <div class="panel-heading">View Courses</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/view_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
                     <div class="col-sm-4">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level">
                                  @if(isset($l))
                                  @foreach($l as $v)
                                  <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>
                             @if(Auth::user()->programme_id == 4)
                             <div class="col-sm-4">
                              <label for="semester" class=" control-label">Entry Month</label>
                              <select class="form-control" name="month">
                                 <option value="">-- Select --</option>
                                 <option value="1">April Contact</option>
                                 <option value="2">August Contact</option>
                                 
                              </select>
                             
                            </div>
                            @endif

                          
                       

                           <div class="col-sm-3">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> View Course
                                </button>
                            </div>

                        </div>

                        </form>
                         @if(isset($course))
                        @if(count($course) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Status</th>
                      <th>Unit</th>
                         <th>Semester</th>
                        <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($course as $v)
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->course_title}}</td>
                       <td>{{$v->course_code}}</td>
                       <td>{{$v->status}}</td>
                       <td>{{$v->course_unit}}</td>
                       <td>@if($v->semester == 1)
                       First Semester
                       @else
                       Second Semester
                       @endif</td>
                       <td><div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('edit_course',$v->id)}}">Edit</a></li>
    
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