@extends('layouts.admin')
@section('title','Enter student')
@section('content')
        <!-- Page Heading -->
        <style type="text/css">
            hr {
    margin-top: 5px;
    margin-bottom: 5px;
    border: 0;
    border-top: 1px solid #000;
}
.table>tbody>tr>td {
    padding: 8px 0px;
}
.fc { width: 30%;margin: auto;}
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
       
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/post_more_result') }}" data-parsley-validate>

               
                    {{ csrf_field() }}

                     @foreach($u as $v)

                    <div class="col-sm-10 col-sm-offset-1">
                     <table class="table table-bordered table-striped">
                     <h4 class="modal-title text-center text-danger">
                     {{strtoupper($v->surname." ".$v->firstname." ".$v->othername)." (".$v->matric_number.")"}}
                   </h4>
                      <input type="hidden" name="fos_id" value="{{$v->fos_id}}"/>
                  
                     
                    {{! $course =DB::connection('mysql2')->table('course_regs')
                     ->where('studentreg_id',$v->id)
                     ->get()
                    }}

<tr>
<td class="text-center text-danger">
Code
<hr>
Unit
<hr>
Grade
</td>
@foreach($course as $cv)
 {{! $result =DB::connection('mysql2')->table('student_results')
                         ->where('coursereg_id',$cv->id)
                         ->get()
                         }} 
   


<td class="text-center">
   <span class="text-info"> {{$cv->course_code}}</span>
    <hr/>
  <span class="text-danger">{{$cv->course_unit}}</span>
  <hr/>
   @if(count($result) > 0)
    @foreach($result as $rv)

    <input type="text" class="form-control fc" name="grade[{{$rv->id.'~'.$cv->id.'~'.$cv->user_id.'~'.$cv->level_id.'~'.$cv->semester_id.'~'.$cv->session.'~'.$cv->period.'~'.$cv->course_id.'~'.$cv->course_unit.'~'.$v->matric_number.'~'.$v->id}}]" value="{{$rv->grade}}"/>  

      @endforeach
     @else 
<input type="text" class="form-control fc" name="grade[{{$cv->id.'~'.$cv->user_id.'~'.$cv->level_id.'~'.$cv->semester_id.'~'.$cv->session.'~'.$cv->period.'~'.$cv->course_id.'~'.$cv->course_unit.'~'.$v->matric_number.'~'.$v->id}}]" value=""/>  

    @endif    
    </td>                    
@endforeach
</tr>
</table>
</div>
<div class="clearfix"></div>
@endforeach
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