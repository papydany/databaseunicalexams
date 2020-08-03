@extends('layouts.admin')
@section('title','Student Details')
@section('content')
@inject('R','App\R')
<div class="row">
  <div class="col-lg-12">
     <ol class="breadcrumb">
      <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
      </li>
      </ol>
  </div>
</div>
  
    
       
<div class="col-sm-12">
    <div class="row" style="min-height: 520px;">
           
      <div class="panel-heading"> Student Details</div>
@if(isset($u))
 @if(!empty($u))
                      <?php  $department =$R->get_departmetname($u->department_id);

                      $fos = $R->get_fos($u->fos_id);
                      $faculty =$R->get_facultymetname($u->faculty_id);
                      $programme =$R->get_programmename($u->programme_id);
                      $img_url ="https://unicalexams.edu.ng/img/student/".$u->image_url;
                      $url ="https://unicalexams.edu.ng/edit_imagerrrrrrr98888880/".$u->id;

                      ?>
<div class="col-sm-9">
<table class="table table-bordered table-striped">
  <tr>
      <th>Surname</th>
      <th>First Name</th>
     <th>Other Name</th>
    <th>Matric Number</th>
</tr>
 <tr>
     <td>{{$u->surname}}</td>
    <td>{{$u->firstname}}</td>
    <td>{{$u->othername}}</td>
    <td>{{$u->matric_number}}</td>
</tr> <tr>
                            
                              <th>Programme</th>
                              <th>Faculty</th>
                              <th>Department</th>
                               <th>FOS</th>
                          </tr>
                          <tr>
                      
                       <td>{{$programme}}</td>
                       <td>{{$faculty}}</td>
                       <td>{{$department}}</td>
                        <td>{{$fos}}</td>
                       </tr>
                      <tr>
                            <th>Entry Year</th>
                              <th>Sex</th>
                              <th>Phone</th>
                              <th>Email</th>
                          </tr>
                          <tr>
                      <td>{{$u->entry_year}}</td>
                       <td>{{$u->gender}}</td>
                       <td>{{$u->phone}}</td>
                       <td>{{$u->email}}</td>
                       </tr>
                       
                          </table>
</div>
 <div class="col-sm-3">

  <p><img id="logo" src="{{$img_url}}" alt="student image"></p>
  <p><a href="{{$url}}" class="btn  btn-primary" target="_blank"> Edit Image</a> </p>
  <p><a href="{{url('edit_matric_number',$u->id)}}" class="btn   btn-primary btn-block" target="_blank"> Edit Matric Number</a> </p>
  <p><a href="{{url('edit_profile',$u->id)}}" class="btn   btn-warning btn-block" target="_blank"> Edit Profile </a> </p>
 

 </div>

<div class="col-sm-12" style="background-color:khaki;padding:20px; margin-bottom
:30px;">
  
    <h4 class="modal-title">Update Entry year </h4>
   <form class="form-horizontal" role="form" method="POST" action="{{ url('/update_entry_year') }}" data-parsley-validate>
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{$u->id}}">
                    <input type="hidden" name="present_entry_year" value="{{$u->entry_year}}">
                    <input type="hidden" name="matric_number" value="{{$u->matric_number}}">

                    <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                        <div class="col-sm-4">
                        <label for="session" class=" control-label">Session</label>
                        <select class="form-control" name="session" required>
                            <option value=""> - - Select - -</option>

                            @for ($year = (date('Y')); $year >= 2016; $year--)
                                {{!$yearnext =$year+1}}
                                <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                            @endfor

                        </select>

                            @if ($errors->has('session_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('session_id') }}</strong>
                                </span>
                            @endif
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-btn fa-user"></i> Update Entry Year
                    </button>
                    </div> </form>
                  </div>
<div class="clear-fix"></div>

@if(count($sr) > 0)
<div class="col-sm-12">
  <div class="panel-heading"> Student Registration Details</div>
  <table class="table table-bordered table-striped">
    <tr>
      <th>Session</th>
      <th>Semester</th>
      <th>Level</th>
      <th>Season</th>
      <th>Action</th>
    </tr>
    @foreach($sr as $sv)
 <tr>
      <td>{{$sv->session}}</td>
      <td>{{$sv->semester == 1 ?'First' : 'Second'}}</td>
      <td>{{$sv->level_id}}</td>
       <td>{{$sv->season}}</td>
      <td><a href="{{url('deleteRegistration',$sv->id)}}" class="btn btn-xs btn-danger">Delete</a></td>
    </tr>
    @endforeach
  </table>
</div>

@else

<div class="col-sm-12">
    <div class="col-sm-6">
    <h4 class="modal-title">Edit Department</h4>
   <form class="form-horizontal" role="form" method="POST" action="{{ url('updatedepartment2') }}" data-parsley-validate>
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{$u->id}}">

                    <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                      <div class="col-md-12">
                            <label for="faculty_id" class="control-label">Select Faculty</label>
                             <select class="form-control" name="faculty_id" id="faculty_id" required>
                           <option value="">Select</option>
                           @if(count($fc) > 0)
                           @foreach($fc as $v)
                    <option value="{{$v->id}}">{{$v->faculty_name}}</option>
                            @endforeach
                            @endif
                         </select>

                            @if ($errors->has('faculty_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('faculty_id') }}</strong>
                                </span>
                            @endif
                        </div>
                     <div class="col-md-12">
                          <label for="department_name" class=" control-label">New Department</label>
                             <select class="form-control" name="department_id" id="department_id" required>
                           <option value="">Select</option>
                           </select>
                        </div>

                          <div class="col-md-12">
                          <label for="department_name" class=" control-label">Field Of Study</label>
                             <select class="form-control" name="fos_id" id="fos_id" required>
                           <option value="">Select</option>
                           </select>
                        </div>
                  

                        

                      

                        <div class="col-md-2">
                        <br/>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-btn fa-user"></i> Update
                            </button>
                        </div>

                    </div>

                    </form>
                  </div>
  </div>
@endif



                          @else
<div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Stuents is available!!!
    </div>

                          @endif
                     
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
<script src="{{URL::to('js/main.js')}}"></script>

@endsection

                    