@extends('layouts.admin')
@section('title','Registered Student')
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
                <!-- /.row -->
  
                 <div class="row" style="min-height: 510px;">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">View Registered Students</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/r_student') }}" data-parsley-validate>
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
                              <div class="col-sm-4 col-sm-offset-4" style="margin-top: 20px;">

                              
@if(isset($c))
                        @if(count($c) > 0)

                        {{!$next = $s + 1}}
                  {{! $semester =DB::table('semesters')
                  ->where('semester_id',$sm)->first()}}
                        <p> <strong>Semester : </strong>{{$semester->semester_name}}</p>
                        <p><strong>Level : </strong>{{$l}}00</p>
                        <p><strong>Session : </strong>{{$s.' / '.$next}}</p>

                      <form class="form-horizontal" role="form" method="POST" action="{{ url('/d_student') }}" target="_blank" data-parsley-validate>
                    {{ csrf_field() }}
                  <div class="form-group">
                  <label for="level" class=" control-label">Course</label>
                     <select class="form-control" name="id" required>
                     <option value="">-- select --</option>
                      @foreach($c as $v)
                      <option value="{{$v->registercourse_id.'~'.$v->fos_id.'~'.$v->reg_course_code}}">{{$v->reg_course_code}}</option>
                      @endforeach
                     </select>

                      <input type="hidden" name="level" value="{{$l}}">
                     <input type="hidden" name="semester" value="{{$sm}}">
                      <input type="hidden" name="session" value="{{$s}}">
                      </div>
  <div class="form-group">
                  <label for="level" class=" control-label">Session</label>
                     <select class="form-control" name="period" required>
                     <option value="">-- select --</option>
                     <option value="NORMAL">NORMAL</option>
                      <option value="VACATION">VACATION</option>
                
                     </select>
                      </div>

                         <div class="form-group ">
 
                        <button type="submit" class="btn btn-success btn-block ">
                                    <i class="fa fa-btn fa-user"></i>View Result
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

           