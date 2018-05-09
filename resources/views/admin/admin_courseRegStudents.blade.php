@extends('layouts.admin')
@section('title','Registered Students')
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
        <div class="col-sm-12" >
            <div class="panel panel-default">
                <div class="panel-heading">Course Registered Student</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin_courseRegStudents') }}" data-parsley-validate>
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
                              <div class="col-sm-2">
                              <label for="session" class="control-label">Department</label>
                              <select class="form-control" name="department" id="department_id" required>
                              <option value=""> - - Select - -</option>
                               
                                  @foreach ($d as $v)
                                 
                                  <option value="{{$v->id}}">{{$v->department_name}}</option>
                                  @endforeach
                                
                              </select>
                             
                            </div>
                            <div class="col-sm-2">
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
                      
                               <div class="col-sm-2">
                              <label for="level" class=" control-label">Semester</label>
                              <select class="form-control" name="semester" required>
                              <option value=""> - - Select - -</option>
                               
                                 
                                  <option value="1">First Semester</option>
                                  <option value="2">Second Semester</option>
                                 
                                
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

                      
                        @if(isset($u))
                        <div class="col-sm-12">
                          @if(count($u))
                     <form class="form-horizontal" role="form" method="POST" action="{{ url('/delete_multiple_courseRegStudents') }}" data-parsley-validate>
                        {{ csrf_field() }}
                       
                          <table class="table table-bordered">
                            <tr>
                              <th>Select</th>
                              <th>S/N</th>
                              <th>Matric</th>
                              <th>Name</th>
                              <th>Action</th>
                              
                            </tr>
                             {{!!$c = 0}}
                       @foreach($u as $v)
                       <tr>
                        <td><input type="checkbox" name="id[]" value="{{$v->id}}">

                         </td> 
                       <td>{{++$c}}</td>
                       <td>{{$v->matric_number}}</td>
                       <td>{{$v->surname.' '.$v->firstname. ' '.$v->othername}}</td>
                       
                         <td><div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
  <li><a href="{{url('delete_courseRegStudents',$v->id)}}">Delete</a></li>
  </ul>
</div></td>
                       
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
<script src="{{URL::to('js/main.js')}}"></script>

@endsection

                    