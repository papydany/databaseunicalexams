@extends('layouts.display')
@section('title','View Register Course')
@section('content')
@inject('R','App\R')

             
                  <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
@if(isset($r))
                        @if(count($r) > 0)
       <?php  $department = $R->get_departmetname(Auth::user()->department_id);
     $faculty = $R->get_facultymetname(Auth::user()->faculty_id);
        $fos =$R->get_fos($fos);    


     ?>
     <table  class="table table-bordered">
<tr><td>
<p class="text-center" style="font-size:18px; font-weight:700;">UNIVERSITY OF CALABAR</p>
    <p class="text-center" style="font-size:16px; font-weight:700;">CALABAR</p>
      <p class="text-center" style="font-size:14px; font-weight:700;">REGISTERED COURSES</p>
    <div class="col-sm-9 www">
  
    <p><b>FACULTY :</b> {{$faculty}}</p>
      <p><b>DEPARTMENT :</b> {{$department}}</p>
          <p><b>PROGRAMME :</b>  {{$fos}}</p>
 
      </div>
  <div class="col-sm-3 ww">
   {{!$next = $g_s + 1}}
      <p> <strong>Level : </strong>{{$g_l}}00 </p>
      <p><strong>Session : </strong>{{$g_s.' / '.$next}}</p>
   
     

    </div>

    </td></tr>
 
  
  
</table>
                      
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">TITLE</th>
                        <th class="text-center">CODE</th>
                        <th class="text-center">STATUS</th>
                      <th class="text-center">UNIT</th>
                         <th class="text-center">SEMESTER</th>
                      
                       </tr>
                       {{!!$c = 0}}
                       @foreach($r as $v)
                       <tr>
                       <td class="text-center">{{++$c}}</td>
                       <td>{{$v->reg_course_title}}</td>
                       <td class="text-center">{{$v->reg_course_code}}</td>
                       <td class="text-center">{{$v->reg_course_status}}</td>
                       <td class="text-center">{{$v->reg_course_unit}}</td>
                       <td class="text-center">@if($v->semester_id == 1)
                       First Semester
                       @else
                       Second Semester
                       @endif</td>
                       
                       </tr>
                       @endforeach
                        </table>

                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                        @endif
                        </div>
                        </div>

  @endsection 