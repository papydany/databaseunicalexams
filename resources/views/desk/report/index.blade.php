@extends('layouts.admin')
@section('title','Generate Result')
@section('content')
@inject('r','App\R')
<?php $result= $r->getrolename(Auth::user()->id); ?>
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
                <div class="panel-heading">Generate Result</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('getreport') }}" target="_blank" data-parsley-validate>
                        {{ csrf_field() }}
                          <input type="hidden" name="duration" id="duration" value="">

                        @if($result =="admin" || $result =="support")

<div class="form-group">
  <input type="hidden" name="admin" value="1">
                        

                       <div class="col-sm-3">
                                 <label for="faculty">Faculty</label>
                                <select class="form-control" name="faculty_id" id="faculty_id">
                                    <option value="">Select</option>
                                    @if(isset($fc))
                                    @foreach($fc as $v)
                                    <option value="{{$v->id}}">{{$v->faculty_name}}</option>

                                    @endforeach

                                    @endif
                                </select>
                                </div>

                                <div class="col-sm-3">
                              <label for="password-confirm" >Department</label>
                              <select class="form-control" name="department_id" id="department_id" required>
                             </select>

                               
                            </div>
                            <div class="col-sm-3">
                                 <label for="faculty">Field Of Study</label>
                                  <select class="form-control" name="fos" id="fos_id" required>
                             </select>
                                </div>
                                 <div class="col-sm-3">
                              <label for="semester" class=" control-label">Result Type</label>
                              <select class="form-control" name="result_type" id="result_type"  required>
                                  <option value=""> - - Select - -</option>
                                 
                              </select>
                             
                            </div>

                        </div>
                          <div class="form-group">
                              <div class="col-sm-3">
                              <label for="level" class=" control-label">Level</label>
                              
                             <select class="form-control" name="level" id="level_id" required>
                                  <option value=""> - - Select - -</option>
                                 
                              </select>
                            </div>
                          
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
                              <div class="col-sm-2">
                                 <br/>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>

                            
                          </div>



@else
                        <div class="form-group">
 <div class="col-sm-2">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session"  required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
 <div class="col-sm-3">
                              <label for="fos" class=" control-label">Field Of Study</label>
                              <select class="form-control" name="fos" id="fos_id" required>
                               <option value=""> - - Select - -</option>
                                 
                                  @foreach($f as $v)
                                  <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                  @endforeach
                                  
                              </select>
                             
                            </div>

                     <div class="col-sm-2">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" id="level_id" required>
                                  <option value=""> - - Select - -</option>
                                 
                              </select>
                             
                            </div>

                         
                            

                              
                          <div class="col-sm-3">
                              <label for="semester" class=" control-label">Result Type</label>
                              <select class="form-control" name="result_type" id="result_type"  required>
                                  <option value=""> - - Select - -</option>
                                 
                              </select>
                             
                            </div>
                          
                              <div class="col-sm-2">
                                 <br/>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>
                            </div>
                             @endif
                           
                              </form>  </div>
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

                      
 