@extends('layouts.admin')
@section('title','Assign Course')
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
                <div class="panel-heading">Assign Courses</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/get_assign_course') }}" data-parsley-validate>
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
                        

                      

                      



                        @if(isset($rs))
                        @if(count($rs) > 0)
                        <hr/>
                  {{!$next = $g_s + 1}}
                        <p><span><strong>Level : </strong>{{$g_l}}00</span>&nbsp;
                        <span><strong>Session : </strong>{{$g_s.' / '.$next}}</span></p>
                          <form class="form-horizontal" role="form" method="POST" action="{{url('/assign_course')}}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="col-sm-7">
                        <table class="table table-bordered table-striped">
                        <tr>
                       <th>Select</th>
                       <th>Code</th>
                       <th>Status</th>
                       <th>Unit</th>
                       
                       </tr>
                      
                    
                       @foreach($rs as $v)
                      <tr>
                       <td>
                        <input type="hidden" name="fos_id[]" value="{{$v->fos_id}}">
                        <input type="hidden" name="level[]" value="{{$v->level_id}}">
                        <input type="hidden" name="semester_id[]" value="{{$v->semester_id}}">
                        <input type="hidden" name="session[]" value="{{$v->session}}">
                       <input type="checkbox" name="id[]" value="{{$v->id}}"></td>
                       <td> {{$v->reg_course_code}} </td>
                      <td> {{$v->reg_course_unit}} </td>
                        <td> {{$v->reg_course_status}} </td>
                        </tr>
                       @endforeach
                       </table>
                       </div>
                       <div class="col-sm-5">
            <table class="table table-bordered table-striped col-sm-5">
                        <tr>
                       <th>Select</th>
                       <th>Lecturer</th>
                       </tr>
                     @if(isset($lec))
                        @if(count($lec) > 0)
                           @foreach($lec as $vv)
                           <tr>
                           <td>
                          <input type="radio" name="lecturer" value="{{$vv->id}}"></td>
                          <td> {{$vv->name}}</td>
                          </tr>
                      @endforeach
                      </table>
                      </div>
                      <div class="clear"></div>
                      <div class="form-group col-sm-12 col-sm-offset-3">
 
                        <button type="submit" class="btn btn-danger btn-lg ">
                                    <i class="fa fa-btn fa-user"></i> Assig Courses
                                </button>
                                </div>
                                </form>
                       @else
                        <p class="alert alert-warning">No Lecturer is avalable</p>
                        @endif
                        @endif
                    
                       
                       @else
                        <p class="alert alert-warning">No register courses available is avalable</p>
                        @endif
                        @endif
                      
                     

                       
                        </div>
                        </div>
                        </div>
                        </div>


  @endsection                      