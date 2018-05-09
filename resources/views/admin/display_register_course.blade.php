@extends('layouts.admin')
@section('title','View Register Course')
@section('content')
@inject('R','App\R')

             
                  <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
@if(isset($r))
                        @if(count($r) > 0)
       <?php  $department = $R->get_departmetname($d);
 
        $fos =$R->get_fos($fos);    


     ?>
     <table  class="table table-bordered">
<tr><td>

      <p class="text-center" style="font-size:14px; font-weight:700;">REGISTERED COURSES</p>
    <div class="col-sm-9 www">
  
  
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
     <form class="form-horizontal" role="form" method="POST" action="{{ url('/delete_adminreg_multiple_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
            <input type="hidden" name="session" value="{{$g_s}}">          
                        <table class="table table-bordered table-striped">
                        <tr>
                          <th>Select</th>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Status</th>
                      <th>Unit</th>
                         <th>Semester</th>
                         <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($r as $v)
                       <tr>
                        <td><input type="checkbox" name="id[]" value="{{$v->id}}">

                         </td> 
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
                         <td><div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
  <li><a href="{{url('delete_adminreg_course',[$v->id,$g_s])}}">Delete</a></li>
  <li><a href="{{url('edit_adminreg_course',[$v->id,$g_s])}}">Edit</a></li>
  </ul>
</div></td>
                       
                       </tr>
                       @endforeach
<tr><td colspan="8"><input type="submit" value="Delete selected row" class="btn btn-primary"></td></tr>                       
                        </table>
                      </form>

                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                        @endif
                        </div>
                        </div>

  @endsection 