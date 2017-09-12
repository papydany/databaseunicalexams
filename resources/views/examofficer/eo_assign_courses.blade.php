@extends('layouts.admin')
@section('title','Enter Result')
@section('content')
    @inject('r','App\R')
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
                  <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Enter Result</div>
                <div class="panel-body">
                <div class="col-sm-4 col-sm-offset-4">
                  {{!$next = $s + 1}}
                  {{! $semester =DB::table('semesters')
                  ->where('semester_id',$sm)->first()}}
                        <p> <strong>Semester : </strong>{{$semester->semester_name}}</p>
                        <p><strong>Level : </strong>{{$l}}00</p>
                        <p><strong>Session : </strong>{{$s.' / '.$next}}</p>
                   
                          @if(isset($c))
                        @if(count($c) > 0)


                      <form class="form-horizontal" role="form" method="GET" action="{{ url('/eo_result_c') }}" data-parsley-validate>
                    
                  <div class="form-group">
                  <label for="level" class=" control-label">Course</label>
                     <select class="form-control" name="id" required>
                     <option value="">-- select --</option>
                    

                      @foreach($c as $v)
                      <option value="{{$v->registercourse_id}}">{{$v->reg_course_code}}</option>
                      @endforeach
           
                     </select>
                      <input type="hidden" name="level" value="{{$l}}">
                     <input type="hidden" name="semester" value="{{$sm}}">
                      <input type="hidden" name="session" value="{{$s}}">
                      </div>
  <div class="form-group">
                  <label for="level" class=" control-label">Period</label>
                     <select class="form-control" name="period" required>
                     <option value="">-- select --</option>
                     <option value="NORMAL">NORMAL</option>
                      <option value="VACATION">VACATION</option>
                
                     </select>
                      </div>

                         <div class="form-group ">
 
                        <button type="submit" class="btn btn-danger btn-lg ">
                                    <i class="fa fa-btn fa-user"></i> Continue
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
  @endsection                  