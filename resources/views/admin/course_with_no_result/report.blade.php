@extends('layouts.display')
@section('title','Display Result')
@section('content')
@inject('r','App\R')
<div class="row" style="min-height: 420px;">
<div class="col-sm-12">
    @if(isset($reg))
    @if(count($reg) > 0)
    {{!$next = $s + 1}}
    {{! $semester =DB::table('semesters')
    ->where('semester_id',$sm)->first()}}
                           
<table  class="table table-bordered">
<tr><td>
<p class="text-center" style="font-size:18px; font-weight:500;">UNIVERSITY OF CALABAR</p>
    <p class="text-center" style="font-size:16px; font-weight:500;">CALABAR</p>
    <p class="text-center" style="font-size:14px; font-weight:500;">COURSES WITHOUT RESULT REPORT</p>
    <hr/>
   
  <div class="col-sm-4">
      <p> <strong>Level : </strong>{{$l}}00 </p>
      </div>
      <div class="col-sm-4">
      <p><strong>Session : </strong>{{$s.' / '.$next}}</p>
      </div>
      <div class="col-sm-4">
       <p><strong>Semester : </strong>{{$semester->semester_name}} </p>
       </div>
      

    </div>

    </td></tr>
 
  
  
</table>
{{!!$e = 0}}
@foreach($reg as $k => $value)
<?php  $department = $r->get_departmetname($k); ?>
<div class="col-sm-12">
<p >{{++$e}} &nbsp;&nbsp;<span class="text-center"> DEPARTMENT : <b> {{$department}}</b></span></p>
<br/>
                       
                 <table class="table table-bordered table-striped">
                 <tr>
                     
                        <th width="3%">S/N</th>
                        <th>Unit</th>
                        <th>Title</th>
                        <th>Code</th>
                      
                          </tr>
                            {{!!$c = 0}}
                      @foreach($value as $v)
                    <?php $fos =$r->get_fos($v->fos_id);?>
                      {{!$c = ++$c}}
                      <tr>
                      
                      <td>{{$c}}</td>
                       <td>{{$fos}}</td>

                        <td>{{strtoupper($v->reg_course_title)}}</td>
                         <td>{{$v->reg_course_code}}</td>
                      
                    
                      </tr>
                     
                      @endforeach
                  </table>
                  </div>
                  @endforeach


                       @else
                        <p class="alert alert-warning">No Result is available  is avalable</p>
                        @endif
                        
  @endif
                  </div>
                    </div>
                    </div>
                    </div>
                    </div>
  @endsection 
             
             