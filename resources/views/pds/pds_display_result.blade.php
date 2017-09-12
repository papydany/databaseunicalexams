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
<td>{{$c[$i]['course_title']}}</td>

    @endfor
    <td>Total point</td>
    </tr>
    {{!!$cc= 0}}
     @inject('r','App\R')
     <?php $course= $r->getcourse() ?>
    @foreach($u as $v)
 <?php $result= $r->select_result_display($v->id,$course,$sm,$ss);
$result_point= $r->get_result_point($v->id,$course,$sm,$ss);

 ?>
    <tr>
    <td>{{++$cc}}</td>
    <td>{{$v->matric_number}}</td>
    <td>{{strtoupper($v->surname)}}</td>
    <td>{{strtoupper($v->firstname." ".$v->othername)}}</td>
    <td>{{$v->gender}}</td>
     <td>{{$v->state->state_name}}</td>
         @for ($i=0; $i < $course_no; $i++)
        
<td>{{$result[$i]['grade']}}</td>

    @endfor
   <td>{{$result_point}}</td>
    </tr>


    @endforeach

 
</table>
 
       </div>
     


@endsection