@extends('layouts.admin')
@section('title','Registered Course')
@section('content')
@inject('R','App\R')
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
                <div class="panel-heading">Registered Course</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/get_adminreg_course') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                        
                               <div class="col-sm-2">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                              <div class="col-sm-3">
                              <label for="session" class="control-label">Department</label>
                              <select class="form-control" name="department" id="department_id" required>
                              <option value=""> - - Select - -</option>
                               
                                  @foreach ($d as $v)
                                 
                                  <option value="{{$v->id}}">{{$v->department_name}}</option>
                                  @endforeach
                                
                              </select>
                             
                            </div>
                            <div class="col-sm-3">
                              <label for="fos" class="control-label">Field Of Study</label>
                              <select class="form-control" name="fos" id="fos_id" required>
                            
                                
                              </select>
                             
                            </div>

                              <div class="col-sm-2">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" required>
                              <option value=""> - - Select - -</option>
                               
                                 
                                  <option value="1">100</option>
                                  <option value="2">200</option>
                                  <option value="3">300</option>
                                  <option value="4">400</option>
                                  <option value="5">500</option>
                                  <option value="6">600</option>
                                  <option value="7">700</option>
                                  <option value="8">800</option>
                                
                              </select>
                             
                            </div>
                      
                          
                            

                            <div class="col-md-2">
                            <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> View
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
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
          <div class="col-sm-12">
@if(isset($r))
                        @if(count($r) > 0)
       <?php  $department = $R->get_departmetname($dd);
 
        $fos_name =$R->get_fos($fos);    


     ?>
     <table  class="table table-bordered">
<tr><td>

      <p class="text-center" style="font-size:14px; font-weight:700;">REGISTERED COURSES</p>
    <div class="col-sm-8 www">
   <p>DEPARTMENT: {{$department}} ( {{$fos_name}})</p>
     </div>
  <div class="col-sm-4 ww">
   {{!$next = $g_s + 1}}
      <p> <strong>Level : </strong>{{$g_l}}00 &nbsp;&nbsp; <strong>Session : </strong>{{$g_s.' / '.$next}}</p>
    </div>

    </td></tr>
 
  
  
</table>
     <form class="form-horizontal" role="form" method="POST" action="{{ url('/delete_adminreg_multiple_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
            <input type="hidden" name="session" value="{{$g_s}}">          
                        <table class="table table-bordered table-striped">
                        <tr>
                          <th>Select</th>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Status</th>
                      <th>Unit</th>
                         <th>Semester</th>
                         <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($r as $v)
                       <tr>
                        <td><input type="checkbox" name="id[]" value="{{$v->id}}">

                         </td> 
                       <td>{{++$c}}</td>
                       <td>{{$v->reg_course_title}}</td>
                       <td>{{$v->reg_course_code}}</td>
                       <td>{{$v->reg_course_status}}</td>
                       <td>{{$v->reg_course_unit}}</td>
                       <td>@if($v->semester_id == 1)
                       First Semeter
                       @else
                       Second Semester
                       @endif</td>
                         <td><div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    @if($v->reg_course_status != 'G')
      <li><a href="{{url('add_adminreg_course',[$v->id,$g_s])}}">Add</a></li>
       <li><a href="{{url('edit_adminreg_course',[$v->id,$g_s])}}">Edit</a></li>
      @endif

  <li><a href="{{url('delete_adminreg_course',[$v->id,$g_s])}}">Delete</a></li>
 
  </ul>
</div></td>
                       
                       </tr>
                       @endforeach
<tr><td colspan="8"><input type="submit" value="Delete selected row" class="btn btn-primary"></td></tr>                       
                        </table>
                      </form>

                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                        @endif
                        </div>
@endsection  
@section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection

                    