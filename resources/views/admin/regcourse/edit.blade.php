@extends('layouts.admin')
@section('title','Edit Register Course')
@section('content')
@inject('R','App\R')

             
                  <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
@if(isset($r))
                        @if(count($r) > 0)
       <?php  $department = $R->get_departmetname($r->department_id);
 
        $fos =$R->get_fos($r->fos_id);    


     ?>
     <table  class="table table-bordered">
<tr><td>

      <p class="text-center" style="font-size:14px; font-weight:700;">EDIT REGISTERED COURSES</p>
    <div class="col-sm-9 www">
  
  
      <p>DEPARTMENT: {{$department}}</p>
          <p>PROGRAMME:  {{$fos}}</p>
 
      </div>
  <div class="col-sm-3 ww">
   {{!$next = $r->session + 1}}
      <p> <strong>Level : </strong>{{$r->level_id}}00 </p>
      <p><strong>Session : </strong>{{$r->session.' / '.$next}}</p>
   
     

    </div>

    </td></tr>
 
  
  
</table>
<div class="col-sm-8">
     <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_adminreg_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
            <input type="hidden" name="session" value="{{$r->session}}"> 
            <input type="hidden" name="id" value="{{$r->id}}">          
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>Title</th>
                        <th><input type="text" value="{{$r->reg_course_title}}" name="title"  class="form-control" required=""></th>
                      </tr>
                      <tr>
                        <th>Code</th>
                        <th><input type="text" name="code" value="{{$r->reg_course_code}}" class="form-control" required></th>
                      </tr>
                      <tr>
                      <th>Status</th>
                      <th><select name="status" class="form-control" required>
                          <option value="">select</option>
                          <option value="C">C</option>
                          <option value="E">E</option>
                        </select></th>
                      </tr>
                      <tr>
                      <th>Unit</th>
                       <td><input type="text" name="unit" value="{{$r->reg_course_unit}}" class="form-control"></td>
                     </tr>
                     <th>Semester</th>
                       <td>@if($r->semester_id == 1)
                       First Semeter
                       @else
                       Second Semester
                       @endif</td>
                     <tr>
                     </tr>
                 
<tr><td></td><td colspan="8"><input type="submit" value="Update" class="btn btn-primary"></td></tr>                       
                        </table>
                      </form>
                    </div>

                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                        @endif
                        </div>
                        </div>

  @endsection 