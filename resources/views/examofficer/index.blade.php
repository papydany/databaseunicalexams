@extends('layouts.admin')
@section('title','Lecturer')
@section('content')
@inject('r','App\R')

<?php $role =$r->getroleId(Auth::user()->id); 

$acct =$r->getResultActivation($role); ?>
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
                <!-- /.row -->
  
                 <div class="row" style="min-height: 420px;">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Enter Result</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/eo_assign_courses') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
                     <div class="col-sm-2">
                              <label for="programme" class=" control-label">Programme</label>
                              <select class="form-control" name="programme" id="programme_id" required>
                                  <option value=""> - - Select - -</option>
                                  @if(isset($p))
                                  @foreach($p as $v)
                                  <option value="{{$v->id}}">{{$v->programme_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>

                         
                         

                               <div class="col-sm-2">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session"  required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                   @if($acct != null)
                                   @if($acct == $year )
                                   <option value="">Session Deactivated</option>
                                   
                                   @else
                                   <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                   @endif

                                   @else
                                   <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                   @endif
                                  
                                  @endfor
                                
                              </select>
                             
                            </div>
                              <div class="col-sm-3">
                              <label for="semester" class=" control-label">Level</label>
                              <select class="form-control" name="level" id="level_id"  required>
                                  <option value=""> - - Select - -</option>
                                 
                               
                                 
                              </select>
                             
                            </div>
                          <div class="col-sm-3">
                              <label for="semester" class=" control-label">Semester</label>
                              <select class="form-control" name="semester" id="semester_id"  required>
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
                           
                              </form>  </div>
                        </div>
                        </div>
                        </div>
                <!-- /.row -->
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

             