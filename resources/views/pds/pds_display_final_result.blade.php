@extends('layouts.pds_display')
@section('title','Home')
@section('content')

    <div class="col-xs-12">

    <table class="table table-bordered">
   
    <tr>
    <td>S/n</td>
    <td>Matric number</td>
    <td>Surname</td>
    <td>Other Name</td>
    <td>Sex</td>
    <td>State</td>
   
 <?php $course_no =count($c) ?>
    @for ($i=0; $i < $course_no; $i++)
<td colspan="2">{{$c[$i]['f_course_code']}}</td>

    @endfor
    <td>Total point</td>
    </tr>
    {{!!$cc= 0}}
  

      @inject('r','App\R')
    
  
    @foreach($u as $v)

  {{!!$Total = 0}}
    <tr>
    <td>{{++$cc}}</td>
    <td>{{$v->matric_number}}</td>
    <td>{{strtoupper($v->surname)}}</td>
    <td>{{strtoupper($v->firstname." ".$v->othername)}}</td>
    <td>{{$v->gender}}</td>
     <td>{{$v->state->state_name}}</td>
        @for ($i=0; $i < $course_no; $i++)

 <?php 
 $cs =$c[$i]['id'];
$avg =$r->get_course_avg($v->id,$cs,$ss);
$gp = $r->get_course_grade_point($avg); 
?>
       
       <td>{{$gp['grade']}}</td>
        <td>{{$gp['point']}}</td>


   
 <?php   
$Total += $gp['point'];
?>
 @endfor  
<td>{{$Total}}</td>
     
    </tr>


    @endforeach

 
</table>
 
       </div>
     


@endsection