@extends('layouts.admin')
@section('title','Delete Result')
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
                <div class="panel-heading">Delete Result</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/delete_result') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
                     <div class="col-sm-2">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" id="level_id" required>
                                  <option value=""> - - Select - -</option>
                                  @if(isset($l))
                                  @foreach($l as $v)
                                  <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                  @endforeach
                                  @endif
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
                              <label for="semester" class=" control-label">Semester</label>
                              <select class="form-control" name="semester"  required>
                                  <option value=""> - - Select - -</option>
                                  @if(isset($s))
                                  @foreach($s as $v)
                                  <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>
                                  @endforeach
                                  @endif
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
 <div class="col-sm-4 col-sm-offset-4" style="margin-top: 20px;">

                              
@if(isset($c))
                        @if(count($c) > 0)

                        {{!$next = $si + 1}}
                  {{! $semester =DB::table('semesters')
                  ->where('semester_id',$sm)->first()}}
                        <p> <strong>Semester : </strong>{{$semester->semester_name}}</p>
                        <p><strong>Level : </strong>{{$li}}00</p>
                        <p><strong>Session : </strong>{{$si.' / '.$next}}</p>

                      <form class="form-horizontal" role="form" method="POST" action="{{ url('/delete_result_detail') }}" data-parsley-validate target="_blank">
                    {{ csrf_field() }}
                  <div class="form-group">
                  <label for="level" class=" control-label">Course</label>
                     <select class="form-control" name="id" required>
                     <option value="">-- select --</option>
                      @foreach($c as $v)
                      <option value="{{$v->id.'~'.$v->course_id.'~'.$v->reg_course_code}}">{{$v->reg_course_code}}</option>
                      @endforeach
                     </select>
                     <input type="hidden" name="fos_id" value="{{$f_id}}">
                      <input type="hidden" name="level" value="{{$li}}">
                     <input type="hidden" name="semester" value="{{$sm}}">
                      <input type="hidden" name="session" value="{{$si}}">
                      </div>
  <div class="form-group">
                  <label for="level" class=" control-label">Season</label>
                     <select class="form-control" name="period" required>
                     <option value="">-- select --</option>
                     <option value="NORMAL">NORMAL</option>
                      <option value="VACATION">VACATION</option>
                
                     </select>
                      </div>
                      <div class="form-group">
                  <label for="level" class=" control-label">Result Type</label>
                <select class="form-control" name="result_type" required>
                     <option value="">-- select --</option>
                     <option value="Sessional">Sessional</option>
                     <option value="Omitted">Omitted</option>
                    <option value="Correctional">Correctional</option>
               </select>
                      </div>

                         <div class="form-group ">
 
                        <button type="submit" class="btn btn-success btn-block ">
                                    <i class="fa fa-btn fa-user"></i>Continue
                                </button>
                                </div>
                                </form>

                       @else
                        <p class="alert alert-warning">No Course is avalable</p>
                        @endif
                        @endif           


</div>

                        </div>
                        </div>
                        </div>


  @endsection 
                      
 