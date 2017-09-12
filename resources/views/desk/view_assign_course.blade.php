@extends('layouts.admin')
@section('title','View Assign Course')
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
                <div class="panel-heading">View Assign Courses</div>
                <div class="panel-body">
                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/view_assign_course') }}" data-parsley-validate>
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
                              <label for="fos" class=" control-label">Field Of Study</label>
                              <select class="form-control" name="fos" required>
                               <option value=""> - - Select - -</option>
                                 
                                  @foreach($f as $v)
                                  <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                  @endforeach
                                  
                              </select>
                             
                            </div>

                               <div class="col-sm-3">
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
                            </div>
                            <div class="form-group">
   
                             <div class="col-sm-3">
                                      <br/>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>
                            </div>
                              </form>

                                @if(isset($ac))
                        @if(count($ac) > 0)
                        <hr/>
                  {{!$next = $g_s + 1}}
                        <p><span><strong>Level : </strong>{{$g_l}}00</span>&nbsp;&nbsp;
                        <span><strong>Session : </strong>{{$g_s.' / '.$next}}</span>&nbsp;&nbsp;
                         <strong>Semester : </strong>@if ($s_id == 1)
                         FIRST
                         @elseif ($s_id == 2)
                         SECOND
                         @endif</span>
                        </p>
                       
                     
                        <table class="table table-bordered table-striped">
                        <tr>
                      
                       <th>Code</th>
                       <th>Unit</th>
                       <th>Status</th>
                       <th>Assign To</th>
                       <td>Action</td>
                       
                       </tr>
                      
                    
                       @foreach($ac as $v)
                      <tr>
                      
                        
                       <td> {{$v->reg_course->reg_course_code}} </td>
                      <td> {{$v->reg_course->reg_course_unit}} </td>
                      <td> {{$v->reg_course->reg_course_status}} </td>
                         <td> {{$v->user->name}} </td>
                         <td><div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('remove_assign_course',$v->id)}}">Remove</a></li>
    
  </ul>
</div></td>
                        </tr>
                       @endforeach
                       </table>
                      
                  
                       @else
                        <p class="alert alert-warning">No Assign course is available is avalable</p>
                        @endif
                        @endif
                        </div>
                              </div>
                              </div>
                              </div>

   @endsection                            
                             
