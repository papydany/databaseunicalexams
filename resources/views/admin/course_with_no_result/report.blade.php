@extends('layouts.display')
@section('title','Display Result')
@section('content')
@inject('r','App\R')
<style>
  p{font-size:12px;
  font-weight: bold;}
  td{font-size:10px;
  }
  .table>tbody>tr>td{padding: 1px;font-weight: bold;}
  .table>tbody>tr>th{padding: 3px;}
</style>
<div class="row" style="min-height: 420px;">
<div class="col-sm-12">
    @if(isset($reg))
    @if(count($reg) > 0)
    {{!$next = $s + 1}}
    
                           
<table  class="table table-bordered">
<tr><td>
<p class="text-center" style="font-size:20px; font-weight:500;">UNIVERSITY OF CALABAR</p>
<p class="text-center" style="font-size:14px; font-weight:500;">COURSES WITHOUT RESULTS</p>

   
  <div class="col-sm-4">
      <p> <strong>Level : </strong>{{$l}}00 </p>
      </div>
      <div class="col-sm-4">
      <p><strong>Session : </strong>{{$s.' / '.$next}}</p>
      </div>
      <div class="col-sm-4">
       <p><strong>Semester : </strong>First & Second</p>
       </div>
      

    </div>

    </td></tr>
 
  
  
</table>
{{!!$e = 0}}
@foreach($reg as $k => $value)
<?php $faculty =$r->get_facultymetname($k);
$collectionDepartment =$value->groupBy('department_id');


//$department = $r->get_departmetname($k); ?>
<div class="col-sm-12">

<p class="text-center"> &nbsp;&nbsp;<span class="text-justify"><b> FACULTY:  {{$faculty}}</b></span></p>
{{!!$ee = 0}}
        @foreach($collectionDepartment as $keyitem =>  $item)  
        <?php $department = $r->get_departmetname($keyitem);
        
        $collectionFosId =$item->groupBy('fos_id');
      
        ?>  
        <p class="text-center"> &nbsp;&nbsp;<span class="text-center"><b> DEPARTMENT :  {{$department}}</b></span></p>           
        {{!!$eee = 0}}
        @foreach($collectionFosId as $keyfosid =>  $itemfosid)  
        <?php
        
       
        $fos =$r->get_fos($keyfosid);?>
        <p >{{++$eee}} &nbsp;&nbsp;<span class="text-center"> Unit : <b> {{$fos}}</b></span></p>
        <table class="table table-bordered table-striped">
                 <tr>
                     
                        <th width="3%">S/N</th>
                        
                        <th>Course Title</th>
                        <th>Course Code</th>
                        <th>Semester</th>
                      
                          </tr>
                            {{!!$c = 0}}
                      @foreach($itemfosid as $v)
                   
                      {{!$c = ++$c}}
                      <tr>
                      
                      <td width='5%'>{{$c}}</td>
                      

                        <td width='55%'>{{strtoupper($v->reg_course_title)}}</td>
                         <td width='20%'>{{$v->reg_course_code}}</td>
                         <td width='15%'>{{$v->semester_id == 1 ? 'First' : 'Second'}} Semester</td>
                    
                      </tr>
                     
                      @endforeach
                  </table>
                  @endforeach
                  @endforeach
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
             
             