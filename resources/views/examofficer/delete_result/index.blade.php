@extends('layouts.admin')
@section('title','Delete Result')
@section('content')
@inject('r','App\R')
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
                <div class="panel-heading">Delete Result</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/eo_delete_result') }}" data-parsley-validate>
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
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
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
                       
                <div class="col-sm-12" style="margin-top: 20px;">
                @if(isset($c))
                <hr/>
                  {{!$next = $s + 1}}
                  {{! $semester =DB::table('semesters')->where('semester_id',$sm)->first()}}
<div class="col-sm-4"><p> <strong>Semester : </strong>{{$semester->semester_name}}</p></div>
<div class="col-sm-4"><p><strong>Level : </strong>{{$l}}00</p></div>
<div class="col-sm-4"><p><strong>Session : </strong>{{$s.' / '.$next}}</p></div>
@if(count($c) > 0) 
<form class="form-horizontal" role="form" method="GET" action="{{ url('eo_delete_result_detail') }}" data-parsley-validate>
<div class="form-group">
<div class="col-sm-3">
<label for="level" class=" control-label">Course</label>
<select class="form-control" name="id" required>
<option value="">-- select --</option>
@foreach($c as  $k => $value)
<?php $fos = $r->get_fos($k); ?>
    <optgroup label="{{$fos}}">
                       @foreach($value as $v)
                      <option value="{{isset($v->registercourse_id) ? $v->registercourse_id : $v->id}}">{{$v->reg_course_code}}&nbsp;&nbsp;=&nbsp;&nbsp;{{$v->reg_course_status}}</option>
                      @endforeach
                         </optgroup>
                    @endforeach
                     </select>
                      <input type="hidden" name="level" value="{{$l}}">
                     <input type="hidden" name="semester" value="{{$sm}}">
                      <input type="hidden" name="session" value="{{$s}}">
                      <input type="hidden" name="programme_id" value="{{$pp}}">
                      </div>

<div class="col-sm-3">
                  <label for="level" class=" control-label">Period</label>
                     <select class="form-control" name="period" required>
                     <option value="">-- select --</option>
                     <option value="NORMAL">NORMAL</option>
                     @if(Auth::user()->programme_id == 2)
                                <option value="RESIT">RESIT</option>
                                @else
                                <option value="VACATION">VACATION</option>

                                @endif
                  
                
                     </select>
                      </div>
                 
                      

                      <div class="col-sm-3"><br/>
 
                        <button type="submit" class="btn btn-primary ">
                                    <i class="fa fa-btn fa-user"></i> Continue with Delete
                                </button>
                                </div>
                                </form>

                       @else
                        <p class="alert alert-warning">No Course has been assign to  you in these semester</p>
                        @endif
                        @endif           

                   
                    </div>
                    </div>
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

             