@extends('layouts.admin')
@section('title','Specialization')
@section('content')
@inject('R','App\R')

<?php $result= $R->getrolename(Auth::user()->id); ?>
 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>

    <div class="row">
        <div class="col-sm-12" style="min-height: 420px;">
            <div class="panel panel-default">
                <div class="panel-heading">Assign Specialization Field To Students</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/assignSpecialization') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                          @if($result =="admin" || $result =="support")
                            <div class="col-md-3">
                                <label for="faculty_id" class="control-label">Select Faculty</label>
                                 <select class="form-control" name="faculty_id" id="faculty_id" required>
                               <option value="">Select</option>
                               @if(count($f) > 0)
                               @foreach($f as $v)
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

                             <div class="col-md-3">
                                <label for="department_id" class="control-label">Select Department</label>
                                 <select class="form-control" name="department_id" id="department_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>

                            <div class="col-md-3">
                                <label for="department_id" class="control-label">Select FOS</label>
                                 <select class="form-control" name="fos_id" id="fos_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>
                            @else

                            <div class="col-sm-4">
                                <label for="fos" class=" control-label">Field Of Study</label>
                                <select class="form-control" name="fos_id" required>
                                 <option value=""> - - Select - -</option>
                                   
                                    @foreach($fos as $v)
                                    <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                    @endforeach
                                    
                                </select>
                               
                              </div>
                              @endif
                            <div class="col-sm-3">
                              <label for="session" class=" control-label">Entry Session</label>
                              <select class="form-control" name="session" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>


                            <div class="col-md-2">
                            <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>

                        </div>

                        </form>
                       
                       
                        @if(isset($u))
                        <hr/>
                      <?php  $d =$R->get_departmetname($did);

                      $fos = $R->get_fos($fosid) ?>
                        <div class="col-sm-12">
                          <p><strong>Entry Session  : </strong> {{$s}} &nbsp;&nbsp;&nbsp;&nbsp;
                          <strong>Department:</strong>
                          {{$d}}&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Field Of Study:</strong>
                          {{$fos}}</p>
                         
                          @if(count($u))
                 
                          <form class="form-horizontal" role="form" method="POST" action="{{ url('updateAssignSpecialization') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="col-sm-4 form-group">
                          <label for="fos" class=" control-label">Specialization Field Of Study</label>
                          <select class="form-control" name="specialization_id" required>
                           <option value=""> - - Select - -</option>
                             
                              @foreach($sp as $v)
                              <option value="{{$v->id}}">{{$v->name}}</option>
                              @endforeach
                              
                          </select>
                         
                        </div>
                        <br/>

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
                          <input type="submit" value="Assign Student" class="btn btn-primary"
                          />
                          </form>

                          @endif
                          @endif
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
@endsection  
@section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection
                   