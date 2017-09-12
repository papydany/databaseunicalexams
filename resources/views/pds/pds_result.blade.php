@extends('layouts.admin')
@section('title','Enter student')
@section('content')
        <!-- Page Heading -->
        <style type="text/css">
            
.t {
    padding: 2px 0px !important;
}
.fc { width: 40%;margin: auto;height: 24px;}

.sub_rotate{
    -ms-transform: rotate(-90deg); /* IE 9 */
    -webkit-transform: rotate(-90deg); /* Safari */
    -moz-transform: rotate(-90deg);
    transform: rotate(-90deg);

    height:80px;
    text-transform: uppercase;

width:2px;
position:relative;
left:95px;
top:40px;
} 
        </style>
<div class="row">
    <div class="col-lg-12">
       
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">Enter Student</div>
            <div class="panel-body">
             @if(isset($u))

            @if(count($u) > 0)
            <h3>@if($s == 1)
            First Semester
               @elseif($s== 2)
Second Semester
               @endif
               &nbsp; &nbsp; &nbsp; Session {{$ss}}
               </h3>
       
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/post_more_result') }}" data-parsley-validate>

               
                    {{ csrf_field() }}

                 

                    <div class="col-sm-12 table-responsive">
                     <table class="table table-bordered table-striped">
<tr>
<td>S/N</td>
<td>Surname</td>
<td>FirstName</td>
<td>OtherName</td>
<td>MatricNumber</td>
<td class="text-center text-danger">
Subject
<br/>
Scores
</td>
@foreach($c as $cv)
 <td class="t">
 @if($s == 1)
 
 <p class="sub_rotate"> {{$cv->f_course_code}}</p>
 @elseif($s ==2)
 
  <p class="sub_rotate"> {{$cv->s_course_code}}</p>

 @endif

</td>                    
@endforeach
</tr>
<?php $no =0; ?>
@foreach($u as $v)
<tr>
<td>{{++$no}}
<td>{{strtoupper($v->surname)}}</td><td>{{strtoupper($v->firstname)}}</td><td> {{strtoupper($v->othername)}}</td>
<td>{{$v->matric_number}}</td>
<td> 
<p class="text-danger">CA </p>
 <p class="text-info">Exams</p>
 </td>
@foreach($c as $cv)
<td class="t">
<p>
name="grade[{{$cv->id.'~'.$cv->user_id.'~'.$cv->level_id.'~'.$cv->semester_id.'~'.$cv->session.'~'.$cv->period.'~'.$cv->course_id.'~'.$cv->course_unit.'~'.$v->matric_number.'~'.$v->id}}]"
<input type="" class="form-control fc " name="ca[$v->id,$s]" value="" /></p>


<p><input type="" class="form-control fc " name="exams[]" value=""  /></p>
</td>
@endforeach
</tr>
@endforeach
</table>
</div>
<div class="clearfix"></div>

<div class="form-group">
<div class="col-sm-10 col-sm-offset-1">
 <button type="submit" class="btn btn-danger">Submit</button>
 </div>
</div>
                    </form>
                  
                     @endif
                @endif
                    </div>
                    </div>
                    </div>
                    </div>
@endsection