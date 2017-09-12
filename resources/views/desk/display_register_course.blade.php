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
  
    <p>FACULTY: {{$faculty}}</p>
      <p>DEPARTMENT: {{$department}}</p>
          <p>PROGRAMME:  {{$fos}}</p>
 
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
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Status</th>
                      <th>Unit</th>
                         <th>Semester</th>
                      
                       </tr>
                       {{!!$c = 0}}
                       @foreach($r as $v)
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->reg_course_title}}</td>
                       <td>{{$v->reg_course_code}}</td>
                       <td>{{$v->reg_course_status}}</td>
                       <td>{{$v->reg_course_unit}}</td>
                       <td>@if($v->semester_id == 1)
                       First Semeter
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