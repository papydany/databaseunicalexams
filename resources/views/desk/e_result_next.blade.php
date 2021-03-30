@extends('layouts.admin')
@section('title','Enter Result')
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
                <div class="panel-heading">Enter Result</div>
                <div class="panel-body">
                <div class="col-sm-4 col-sm-offset-4">
                  {{!$next = $s_id + 1}}
                  {{! $semester =DB::table('semesters')
                  ->where('semester_id',$sm_id)->first()}}
                        <p> <strong>Semester : </strong>{{$semester->semester_name}}</p>
                        <p><strong>Level : </strong>{{$l_id}}00</p>
                        <p><strong>Session : </strong>{{$s_id.' / '.$next}}</p>
                   
                          @if(isset($rc))
                        @if(count($rc) > 0)
                      <form class="form-horizontal" role="form" method="GET" action="{{ url('e_result_c') }}" data-parsley-validate>
                     
                  <div class="form-group">
                  <label for="level" class=" control-label">Course</label>
                     <select class="form-control" name="id" required>
                     <option value="">-- select --</option>
                      @foreach($rc as $v)
                      @if(Auth::user()->faculty_id == $med)
                      <option value="{{$v->id}}">{{$v->reg_course_title}}</option>
                    
                      @else
                      <option value="{{$v->id}}">{{$v->reg_course_code}}&nbsp;&nbsp;=&nbsp;&nbsp;{{$v->reg_course_status}}</option>
                    
                      @endif
                       @endforeach
                     </select>
                      </div>
                      <div class="form-group">
                  <label for="level" class="control-label">Season</label>
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
 
                        <button type="submit" class="btn btn-danger btn-lg ">
                                    <i class="fa fa-btn fa-user"></i> Continue
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
                    </div>
  @endsection                  