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
            $fos =$r->get_fos($f_id);


     ?>
                   
                   {{!$next = $s + 1}}
                  {{! $semester =DB::table('semesters')
                  ->where('semester_id',$sm)->first()}}
                           
<table  class="table table-bordered">
<tr><td>
<p class="text-center" style="font-size:18px; font-weight:700;">UNIVERSITY OF CALABAR</p>
    <p class="text-center" style="font-size:16px; font-weight:700;">CALABAR</p>
    <p class="text-center" style="font-size:14px; font-weight:700;">RESULT REPORT</p>
    <div class="col-sm-9 www">
  
    <p>FACULTY: {{$faculty}}</p>
      <p>DEPARTMENT: {{$department}}</p>
      <p>PROGRAMME:  {{$fos}}</p>
 <p>LECTURER:  {{Auth::user()->title.'&nbsp;&nbsp;'.Auth::user()->name}}</p>
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
                     
                        <th width="3%">S/N</th>
                        <th width="17%">Martic Number</th>
                        <th>Names</th>
                        <th width="7%">Script No</th>
                        <th width="5%">CA</th>
                        <th width="5%">Exams</th>
                        <th width="5%">Total</th>
                        <th width="5%">Grade</th>
                          </tr>
                            {{!!$c = 0}}
                      @foreach($u as $v)
                    <?php $result= $r->getresult($v->id) ?>
                      {{!$c = ++$c}}
                      <tr>
                      
                      <td>{{$c}}</td>
                       <td>{{$v->matric_number}}</td>

                        <td>{{strtoupper($v->surname." ".$v->firstname." ".$v->othername)}}</td>
                        <td>{{isset($result->scriptNo) ?$result->scriptNo : ''}}</td>
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
             