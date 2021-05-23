@extends('layouts.admin')
@section('title','Registered Students')
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

    <div class="row" style="min-height: 520px;">
        <div class="col-sm-12" >
            <div class="panel panel-default">
                <div class="panel-heading">View Student</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin_viewStudents') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                        
                               <div class="col-sm-3">
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
                      <?php  $d =$R->get_departmetname($did);

                      $fos = $R->get_fos($fosid) ?>
                        <div class="col-sm-12">
                          <p><strong>Session  : </strong> {{$s}} &nbsp;&nbsp;&nbsp;&nbsp;
                          <strong>Department:</strong>
                          {{$d}}&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Field Of Study:</strong>
                          {{$fos}}</p>
                         
                          @if(count($u))
                 
                          <form class="form-horizontal" role="form" method="POST" action="{{ url('/tranferStudents') }}" data-parsley-validate>
                        {{ csrf_field() }}

                          <table class="table table-bordered table-striped">
                            <tr>
                            
                              <th>S/N</th>
                              <th>Select</th>
                              <th>Matric</th>
                              <th>Name</th>
                               <th>Phone</th>
                              
                              
                            </tr>
                             {{!!$c = 0}}
                       @foreach($u as $v)
                       <tr>
                      
                       <td>{{++$c}}</td>
                       <td><input type="checkbox" name="id[]" value="{{$v->id}}"/></td>
                       <td>{{$v->matric_number}}</td>
                       <td>{{$v->surname.' '.$v->firstname. ' '.$v->othername}}</td>
                        <td>{{$v->phone}}</td>
                     
                       
                       </tr>
                       @endforeach
                       
                          </table>


 <div class="col-sm-12" >
            <div class="panel panel-default">
                <div class="panel-heading">Transfer  Student To New Department</div>
                <div class="panel-body">
                   
                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                        
                               <div class="col-sm-3">
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
                              <label for="session" class="control-label">Faculty</label>
                              <select class="form-control" name="faculty" id="faculty_id2" required>
                              <option value=""> - - Select - -</option>
                               
                                  @foreach ($f as $v)
                                 
                                  <option value="{{$v->id}}">{{$v->faculty_name}}</option>
                                  @endforeach
                                
                              </select>
                             
                            </div>
                              <div class="col-sm-3">
                              <label for="session" class="control-label">Department</label>
                              <select class="form-control" name="department" id="department_id2" required>
                              
                               
                                
                              </select>
                             
                            </div>
                            <div class="col-sm-3">
                              <label for="fos" class="control-label">Field Of Study</label>
                              <select class="form-control" name="fos" id="fos_id2" required>
                            
                                
                              </select>
                             
                            </div>

                          
                      
                            

                            <div class="col-md-2">
                            <br/>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Transfer Students
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                      </div>

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

                    