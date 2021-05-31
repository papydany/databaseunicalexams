@extends('layouts.admin')
@section('title','Delete Register Course')
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
                <div class="panel-heading">View Register Courses</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('get_registeredcourse') }}"  data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
                     <div class="col-sm-2">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" required>
                                <option value=""> -- Select --</option>
                                  @if(isset($l))
                                  @foreach($l as $v)
                                  <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>

                         
                             <div class="col-sm-3">
                              <label for="fos" class=" control-label">Field Of Study</label>
                              <select class="form-control" name="fos" id='fos' required>
                               <option value=""> - - Select - -</option>
                                 
                                  @foreach($f as $v)
                                  <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                  @endforeach
                                  
                              </select>
                             
                            </div>
                            <div class="col-sm-3">
                              <label for="fos" class=" control-label">Specialization Field Of Study</label>
                              <select class="form-control" name="sfos" id='sfos' required>
                                  <option value=""> - - Select - -</option>
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
                                <button type="submit" class="btn btn-success btn-lg">
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
                          
                          <p><b>Specialization:</b> ( {{$fn->fos_name}})</p>
                            </div>
                         <div class="col-sm-6 ww">
                          {{!$next = $g_s + 1}}
                             <p> <strong>Level : </strong>{{$g_l}}00 &nbsp;&nbsp; &nbsp;&nbsp;<strong>Session : </strong>{{$g_s.' / '.$next}}</p>
                           </div>
                        <div class="col-sm-12">

@inject('R','App\R')

       @if(count($r) > 0)
       
     <form class="form-horizontal" role="form" method="POST" action="{{ url('delete_adminreg_multiple_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
          <input type="hidden" name="session" value="{{$g_s}}">             
                        <table class="table table-bordered table-striped">
                        <tr>
                          <th></th>
                        <th class="text-center">S/N</th>
                        <th class="text-center">TITLE</th>
                        <th class="text-center">CODE</th>
                        <th class="text-center">STATUS</th>
                      <th class="text-center">UNIT</th>
                         <th class="text-center">SEMESTER</th>
                         <th>Action</th>
                      
                       </tr>
                       {{!!$c = 0}}
                       @foreach($r as $vs)
                       <tr>
                         <td>
                            @if($vs->reg_course_status != 'G')
                           <input type="checkbox" name="id[]" value="{{$vs->id}}">
                           @endif
                      
                         </td>
                       <td class="text-center">{{++$c}}</td>
                       <td>{{$vs->reg_course_title}}</td>
                       <td class="text-center">{{$vs->reg_course_code}}</td>
                       <td class="text-center">{{$vs->reg_course_status}}</td>
                       <td class="text-center">{{$vs->reg_course_unit}}</td>
                       <td class="text-center">@if($vs->semester_id == 1)
                       First Semester
                       @else
                       Second Semester
                       @endif</td>
                                              <td>
                                                  @if($vs->reg_course_status != 'G')
                                                  <div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    
      <li><a href="{{url('add_adminreg_course',[$vs->id,$g_s])}}">Add</a></li>
       <li><a href="{{url('edit_adminreg_course',[$vs->id,$g_s])}}">Edit</a></li>
       <li><a href="{{url('delete_adminreg_course',[$vs->id,$g_s])}}">Delete</a></li>
     

  
  </ul>
</div>
@endif</td>
                       </tr>
                       @endforeach
                       <tr><td colspan="8"><input type="submit" value="Delete selected row" class="btn btn-danger"></td></tr>
                        </table>

                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                     
                       

 
                        </div>
                        @endif
                        </div>

                        <div class="modal fade" id="myModal" role="dialog" style="margin-top: 100px;">
                          <div class="modal-dialog">
                          
                            <!-- Modal content-->
                            <div class="modal-content">
                             
                              <div class="modal-body text-danger text-center">
                                <p>... processing ...</p>
                              </div>
                             
                            </div>
                            
                          </div>
                        </div>
  @endsection
  @section('script')
    <script src="{{ URL::to('js/main.js') }}"></script>

@endsection