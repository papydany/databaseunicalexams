@extends('layouts.display')
@section('title','Display Result')
@section('content')
@inject('r','App\R')

             
                  <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
      @if(isset($u))
       @if(count($u) > 0)
     <?php  $department = $r->get_departmetname(Auth::user()->department_id);
     $faculty = $r->get_facultymetname(Auth::user()->faculty_id);
            $fos =$r->get_fos($fos_id);


     ?>
                   
                   {{!$next = $s + 1}}
                  {{! $semester =DB::table('semesters')
                  ->where('semester_id',$sm)->first()}}
                           
<table  class="table table-bordered">
<tr><td>
<p class="text-center" style="font-size:18px; font-weight:700;">UNIVERSITY OF CALABAR</p>
    <p class="text-center" style="font-size:16px; font-weight:700;">CALABAR</p>
  
    <div class="col-sm-9 www">
  
    <p>FACULTY: {{$faculty}}</p>
      <p>DEPARTMENT: {{$department}}</p>
      <p>PROGRAMME:  {{$fos}}</p>
 
      </div>
  <div class="col-sm-3 ww">
      <p> <strong>Level : </strong>{{$l}}00 </p>
      <p><strong>Session : </strong>{{$s.' / '.$next}}</p>
       <p><strong>Semester : </strong>{{$semester->semester_name}} </p>
        <p><strong>Course  : </strong>{{$course_code}}</p>

    </div>

    </td></tr>
 
  
  
</table>

            
                       
                 <table class="table table-bordered table-striped">
                 <tr>
                     
                        <th class="text-center">S/N</th>
                        <th class="text-center">MATRIC NUMBERS</th>
                        <th class="text-center">NAMES</th>
                        <th class="text-center">CA</th>
                        <th class="text-center">EXAMS</th>
                        <th class="text-center">TOTAL</th>
                        <th class="text-center">GRADE</th>
                          </tr>
                            {{!!$c = 0}}
                      @foreach($u as $v)
                    <?php $result= $r->getresult($v->id) ?>
                      {{!$c = ++$c}}
                      <tr>
                      
                      <td>{{$c}}</td>
                       <td>{{$v->matric_number}}</td>

                        <td>{{strtoupper($v->surname." ".$v->firstname." ".$v->othername)}}</td>
                         <td>{{isset($result->ca) ?$result->ca : ''}}</td>
                       <td>{{isset($result->exam) ? $result->exam: ''}}</td>
                     <td>{{isset($result->total) ? $result->total: ''}}</td>
                        <td class="text-center">
                   
                    

                   
                       
{{isset($result->grade) ?$result->grade :''}}
                      </td>
                      </tr>
                     
                      @endforeach
                  </table>


                       @else
                        <p class="alert alert-warning">No Register students  is avalable</p>
                        @endif
                        
  @endif
                  </div>
                    </div>
                    </div>
                    </div>
                    </div>
  @endsection 
             