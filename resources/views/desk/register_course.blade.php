@extends('layouts.admin')
@section('title','Register Course')
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

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Registered Courses</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
                     <div class="col-sm-3">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level">
                               <option value=""> - - Select - -</option>
                                  @if(isset($l))
                                  @foreach($l as $v)
                                  <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>
   <div class="col-sm-3">
                              <label for="semester" class=" control-label">Semester</label>
                              <select class="form-control" name="semester">
                              <option value=""> - - Select - -</option>
                                  @if(isset($s))
                                  @foreach($s as $v)
                                  <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>
                          
                           @if(Auth::user()->programme_id == 4)
                             <div class="col-sm-3">
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
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row" style="background-color: #cce;padding-top: 20px; border-radius: 4px;"> 
                        <div class="col-sm-12">
                         <div class="panel panel-default">
                <div class="panel-heading">Register Courses</div>
                <div class="panel-body">
                         @if(isset($course))
                        @if(count($course) > 0)
                         @if(isset($f))
                          @if(count($f) > 0)
                             <form class="form-horizontal" role="form" method="POST" action="{{ url('/reg_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        @if(isset($m))
                     <input type="hidden" name="month" value="{{$m}}">
                        @endif
 <div class="form-group">
                     <div class="col-sm-4">
                              <label for="fos" class=" control-label">Field Of Study</label>
                              <select class="form-control" name="fos" required>
                               <option value=""> - - Select - -</option>
                                 
                                  @foreach($f as $v)
                                  <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                  @endforeach
                                  
                              </select>
                             
                            </div>
   <div class="col-sm-4">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session_id" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                          
                       

                           <div class="col-sm-3">
                                      <br/>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-user"></i> Register Course
                                </button>
                            </div>

                        </div>
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
                       <td>
                 <input type="checkbox" name="id[]" value="{{$v->id}}"> 

   </td>
                       </tr>
                       @endforeach
                        </table>
                         </form>
                       @endif
                        @else
                        <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    Field Of study have not been assign to the account.. contact system Adminstrator
    </div>
                       @endif  
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