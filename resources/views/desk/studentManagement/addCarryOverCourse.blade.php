@extends('layouts.admin')
@section('title','Add CarryOver Course')
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
                <div class="panel-heading">Add CarryOver Courses</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('getStudentManagementAddCarryOverCourse') }}"  data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
                     <div class="col-sm-2">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level">
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

                               <div class="col-sm-2">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session_id" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                            <div class="col-sm-3 col-md-2">
                            <label for="level" class=" control-label">Season</label>
                            <select class="form-control" name="season">
                                <option value=""> - - Select - -</option>
                                <option value="NORMAL">NORMAL</option>
                                 @if(Auth::user()->programme_id == 2)
                                <option value="RESIT">RESIT</option>
                                @else
                                <option value="VACATION">VACATION</option>

                                @endif

                            </select>

                        </div>
                             @if(Auth::user()->programme_id == 4)
                             <div class="col-sm-2">
                              <label for="semester" class=" control-label">Entry Month</label>
                              <select class="form-control" name="month">
                                 <option value="">-- Select --</option>
                                 <option value="1">April Contact</option>
                                 <option value="2">August Contact</option>
                                 
                              </select>
                             
                            </div>
                            @endif
   
                             <div class="col-sm-2">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>
                            </div>

                      

                        </form>
                         
                        </div>
                        </div>

                        </div>
                        @if(isset($r))
                        <div class="col-sm-6 www">
                          <p><b>Unit:</b> ( {{$fn->fos_name}})</p>
                            </div>
                         <div class="col-sm-6 ww">
                          {{!$next = $g_s + 1}}
                             <p> <strong>Level : </strong>{{$g_l}}00 &nbsp;&nbsp; <strong>Session : </strong>{{$g_s.' / '.$next}}</p>
                           </div>
                        <div class="col-sm-12">

@inject('R','App\R')

       @if(count($r) > 0)
       
     <form class="form-horizontal" role="form" method="POST" action="{{ url('postStudentManagementAddCarryOverCourse') }}" data-parsley-validate>
                        {{ csrf_field() }}
          <input type="hidden" name="session" value="{{$g_s}}">
          <input type="hidden" name="level_id" value="{{$g_l}}">
          <input type="hidden" name="fos_id" value="{{$fos}}">
          <input type="hidden" name="season" value="{{$season}}">
          <div class='col-sm-5'>
          <table class="table table-bordered table-striped">
                        <tr>
                          <th></th>
                        <th class="text-center">S/N</th>
                        <th class="text-center">matric Number</th>
                        <th class="text-center">Name</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($rs as $v)
                       <?php $name = $v->surname.' '.$v->firstname.' '.$v->othername;?>
                       <tr>
                         <td>
                        
                           <input type="checkbox" name="ids[]" value="{{$v->id}}">
                           
                      
                         </td>
                       <td class="text-center">{{++$c}}</td>
                       <td>{{$v->matric_number}}</td>
                       <td>{{$name}}</td>
                       </tr>
                       @endforeach
          </table>
          </div> 
          <div class="col-sm-7">
                        <table class="table table-bordered table-striped">
                        <tr>
                          <th></th>
                        <th class="text-center">S/N</th>
                        <th class="text-center">TITLE</th>
                        <th class="text-center">CODE</th>
                        <th class="text-center">STATUS</th>
                      <th class="text-center">UNIT</th>
                         <th class="text-center">SEMESTER</th>
                        
                      
                       </tr>
                       {{!!$c = 0}}
                       @foreach($r as $vs)
                       <tr>
                         <td>
                           
                           <input type="checkbox" name="idc[]" value="{{$vs->id}}">
                           <input type="hidden" name="code[{{$vs->id}}]" value="{{$vs->reg_course_code}}">
                           <input type="hidden" name="status[{{$vs->id}}]" value="{{$vs->reg_course_status}}">
                           <input type="hidden" name="semester[{{$vs->id}}]" value="{{$vs->semester_id}}">
                           <input type="hidden" name="unit[{{$vs->id}}]" value="{{$vs->reg_course_unit}}">
                           <input type="hidden" name="course_id[{{$vs->id}}]" value="{{$vs->course_id}}">
                           <input type="hidden" name="title[{{$vs->id}}]" value="{{$vs->reg_course_title}}">
                         </td>
                       <td class="text-center">{{++$c}}</td>
                       <td>{{$vs->reg_course_title}}</td>
                       <td class="text-center">{{$vs->reg_course_code}}</td>
                       <td class="text-center">{{$vs->reg_course_status}}</td>
                       <td class="text-center">{{$vs->reg_course_unit}}</td>
                       <td class="text-center">@if($vs->semester_id == 1)
                       First 
                       @else
                       Second 
                       @endif</td>
                                             
                       </tr>
                       @endforeach
                       <tr><td colspan="8"><input type="submit" value="Add Course" class="btn btn-primary"></td></tr>
                        </table>

                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Course Records!!!
    </div>
          </div>

                        @endif
                     
                       

 
                        </div>
                        @endif
                        </div>


  @endsection                      