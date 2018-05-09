@extends('layouts.pds_display')
@section('title','Home')
@section('content')

    <div class="col-xs-12">

    <table class="table table-bordered">
   <tr>
    <td colspan="6">
    </td>
    <td colspan="4">
        First Semester
    </td>
    <td colspan="4">
       Second Semester
    </td>
     <td colspan="3">
       Summary
    </td>
   </tr>
    <tr>
    <td>S/n</td>
    <td>Matric number</td>
    <td>Surname</td>
    <td>Other Name</td>
    <td>Sex</td>
    <td>State</td>
    <td>Ca</td>
    <td>Exams</td>
    <td>Score</td>
    <td>Grade 1</td>
    <td>Ca</td>
    <td>Exams</td>
    <td>Score</td>
    <td>Grade 2</td>
    <td>AVG</td>
    <td>Grade</td>
    <td>Pts</td>
</tr>
    {{!!$cc= 0}}
      @inject('r','App\R')
  
    @foreach($u as $v)
 <?php $g1= $r->get_course_grade($v->id,$cs,$ss,1);
       $g2= $r->get_course_grade($v->id,$cs,$ss,2);
       $avg =$r->get_course_avg($v->id,$cs,$ss);
       $gp = $r->get_course_grade_point($avg); ?>

    <tr>
    <td>{{++$cc}}</td>
    <td>{{$v->matric_number}}</td>
    <td>{{strtoupper($v->surname)}}</td>
    <td>{{strtoupper($v->firstname." ".$v->othername)}}</td>
    <td>{{$v->gender}}</td>
     <td>{{$v->state->state_name}}</td>
     <!-- first score-->

     @if(count($g1) > 0)
     @foreach($g1 as $g1v)
     <td>{{$g1v->ca}}</td>
<td>{{$g1v->exam}}</td>
<td>{{$g1v->total}}</td>
<td>{{$g1v->grade}}</td>
     @endforeach

     @else
     <td></td> <td></td><td></td> <td></td>
     @endif
         <!-- second score-->
  @if(count($g2) > 0)       
  @foreach($g2 as $g2v)
     <td>{{$g2v->ca}}</td>
<td>{{$g2v->exam}}</td>
<td>{{$g2v->total}}</td>
<td>{{$g2v->grade}}</td>
     @endforeach
   @else
     <td></td> <td></td><td></td> <td></td>
     @endif
     <td>{{$avg}}</td>
     <td>{{$gp['grade']}}</td>
        <td>{{$gp['point']}}</td>
    </tr>


    @endforeach

 
</table>
 
       </div>
     


@endsection