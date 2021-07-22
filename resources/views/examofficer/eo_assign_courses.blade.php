@extends('layouts.admin')
@section('title','Enter Result')
@section('content')
@inject('r','App\R')
<?php 
use Illuminate\Support\Facades\Auth;
$role =$r->getrolename(Auth::user()->id); ?>

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
                
                  
@if($role =='examsofficer' && isset($c) || $role =='examsofficer' && isset($c2) || isset($c))
@if($role =='examsofficer' && count($c) > 0 || $role =='examsofficer' && count($c2) > 0 || count($c) > 0)

                    
                       


                      <form class="form-horizontal" role="form" method="GET" action="{{ url('eo_result_c') }}" data-parsley-validate>
                    
                  <div class="form-group">
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

                    @if($role =='examsofficer')

                    @foreach($c2 as  $k => $value)
                    <?php $fos = $r->get_fos($k); ?>
                     <optgroup label="{{$fos}}">
                     @foreach($value as $v)
                    <option value="{{isset($v->registercourse_id) ? $v->registercourse_id : $v->id}}">{{$v->reg_course_code}}&nbsp;&nbsp;=&nbsp;&nbsp;{{$v->reg_course_status}}</option>
                    @endforeach
                    
                       </optgroup>
                  @endforeach
                  @endif
                     </select>
                      <input type="hidden" name="level" value="{{$l}}">
                     <input type="hidden" name="semester" value="{{$sm}}">
                      <input type="hidden" name="session" value="{{$s}}">
                      <input type="hidden" name="programme_id" value="{{$p}}">
                      </div>
  <div class="form-group">
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
                            @if(Auth::user()->programme_id != 2)
                <div class="form-group">
                  <label for="result_type" class=" control-label">Result Type</label>
                <select class="form-control" name="result_type" required>
                     <option value="">-- select --</option>
                     <option value="Sessional">Sessional</option>
                     @if($role == 'examsofficer')
                     <option value="Omitted">Omitted</option>
                     @endif
                     <!--<option value="Correctional">Correctional</option>-->
               </select>
                      </div>
                       @endif

                         <div class="form-group ">
 
                        <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                               
                                <button type="submit" name="excel" value="excel" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Use Excel to Upload
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