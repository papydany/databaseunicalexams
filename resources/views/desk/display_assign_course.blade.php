@extends('layouts.display')
@section('title','View Register Course')
@section('content')
@inject('R','App\R')

             
                  <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
 @if(isset($ac))
@if(count($ac) > 0)
       <?php  $department = $R->get_departmetname(Auth::user()->department_id);
     $faculty = $R->get_facultymetname(Auth::user()->faculty_id);
        $fos =$R->get_fos($fos);    
 ?>
     <table  class="table table-bordered">
<tr><td>
<p class="text-center" style="font-size:18px; font-weight:700;">UNIVERSITY OF CALABAR</p>
    <p class="text-center" style="font-size:16px; font-weight:700;">CALABAR</p>
      <p class="text-center" style="font-size:14px; font-weight:700;">ASSIGNED COURSES</p>
    <div class="col-sm-9 www">
  
    <p>FACULTY: {{$faculty}}</p>
      <p>DEPARTMENT: {{$department}}</p>
          <p>PROGRAMME:  {{$fos}}</p>
 
      </div>
  <div class="col-sm-3 ww">
   {{!$next = $g_s + 1}}
      <p> <strong>Level : </strong>{{$g_l}}00 </p>
      <p><strong>Session : </strong>{{$g_s.' / '.$next}}</p>
   
         <p> <strong>Semester : </strong>@if ($s_id == 1)
                         FIRST
                         @elseif ($s_id == 2)
                         SECOND
                         @endif</span>
                        </p>

    </div>

    </td></tr>
 
  
  
</table>
                      
                       
                  
                    
                    
                    
                       
                     
                        <table class="table table-bordered table-striped">
                        <tr>
                      
                       <th>Code</th>
                       <th>Unit</th>
                       <th>Status</th>
                       <th>Lecturer Assigned To</th>
               
                       
                       </tr>
                      
                    
                       @foreach($ac as $v)
                      <tr>
                      
                        
                       <td> {{$v->reg_course->reg_course_code}} </td>
                      <td> {{$v->reg_course->reg_course_unit}} </td>
                      <td> {{$v->reg_course->reg_course_status}} </td>
                         <td> {{$v->user->title.'&nbsp; &nbsp;' .$v->user->name}} </td>
                        </tr>
                       @endforeach
                       </table>
                      
                  
                       @else
                        <p class="alert alert-warning">No Assign course is available is avalable</p>
                        @endif
                        @endif
                        </div>
                              </div>
                              </div>
                              </div>

  @endsection 