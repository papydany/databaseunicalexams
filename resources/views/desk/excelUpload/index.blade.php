@extends('layouts.admin')
@section('title','Enter Result')
@section('content')
@inject('r','App\R')
 <!-- Page Heading -->
 <style type="text/css">
 .fc {padding:0px;text-align: center;font-weight: bolder;font-size: 14px;}
 .table>tbody>tr>td{padding:4px;}
 .cc {width:6%;}
        </style>
                <div class="row">
                
                <?php $fos= $r->get_fos($c->fos_id) ?>
                    <div class="col-lg-12">
                       
                        <ol class="breadcrumb">
                            <li class="active" style="font-weight: bolder;">
                            @if(Auth::user()->faculty_id == $med)
                            Course  : {{$c->reg_course_title}}
                            @else
                               Course Code : {{$c->reg_course_code}}
                               &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                               Course Unit : {{$c->reg_course_unit}}
                               &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                               @endif
                               <?php $next = $c->session + 1;?>
                             Session: {{$c->session.' / '.$next}}
                              &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                              Level: {{$c->level_id}}00
                              &nbsp;&nbsp; &nbsp;&nbsp;
                              Semester: {{$c->semester_id}}
                                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                Field Of Study :{{$fos}}
                            </li>
                        </ol>
                    </div>
                </div>
                  <div class="row" style="min-height: 520px;">
       
            <div class="panel panel-default">
                <div class="panel-heading">Upload  Result 
                  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                  <span class="text-center text-success"><strong>Result Type :</strong>&nbsp;{{$rt}}</span></div>
                <div class="panel-body">
             
                
                   
                      <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('excel_insert_result') }}" data-parsley-validate>
                   
                        {{ csrf_field() }}
                      
                      
                        <input type="hidden" name="registeredCourseId" value="{{$c->id}}">
                        <input type="hidden" name="faculty_id" value="{{$f}}">
                        <input type="hidden" name="period" value="{{$period}}">
                        <input type="hidden" name="session" value="{{$c->session}}">
                        <input type="hidden" name="level" value="{{$c->level_id}}">
                        <input type="hidden" name="semester" value="{{$c->semester_id}}">
                        <input type="hidden" name="unit" value="{{$c->reg_course_unit}}">
                 <table class="table table-bordered table-striped">
                 <tr>
                       
                        
                        <th class="text-center">MATRIC NUMBERS</th>
                        <th class="text-center">NAMES</th>
                        <th width="15%"  class="text-center">Script No</th> 
                        <th class="cc text-center">CA</th> 
                        <th class="cc text-center">EXAMS</th>
                        <th class="cc text-center">TOTAL</th>
                      
                          </tr>
                          
                  
<tr></tr>
<td>
  <label>select excell file</label>
<input type="file" name="excel_import_result" value="" class="form-control">
</td>
<td colspan="3"></td>
<td colspan="2" style="padding-top: 18px;padding-bottom:10px;">

<button type="submit" class="btn btn-primary btn-block ">
<i class="fa fa-btn fa-user"></i> Submit Result</button>
</td>
</tr>
</table>                            
</form>

 </div>
</div>
</div>
</div>
  @endsection 
