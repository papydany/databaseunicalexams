@extends('layouts.display')
@section('title','View lecturer')
@section('content')
@inject('R','App\R')

                   <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
  @if(isset($l))
  @if(count($l) > 0)
       <?php  $department = $R->get_departmetname(Auth::user()->department_id);
     $faculty = $R->get_facultymetname(Auth::user()->faculty_id);
    
 ?>
     <table  class="table table-bordered">
<tr><td>
<p class="text-center" style="font-size:18px; font-weight:700;">UNIVERSITY OF CALABAR</p>
    <p class="text-center" style="font-size:16px; font-weight:700;">CALABAR</p>
      <p class="text-center" style="font-size:14px; font-weight:700;">LECTURERS USERNAME AND PASSWORD</p>
    <div class="col-sm-9 www">
  
    <p>FACULTY: {{$faculty}}</p>
      <p>DEPARTMENT: {{$department}}</p>
       
 
      </div>


    </td></tr>
 
  
  
</table>
                   
                      
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                          <th>Title</th>
                        <th>Name</th>
                         <th>Username</th>
                        <th>Email</th>
                       
                  
                       </tr>
                       {{!!$c = 0}}
                       @foreach($l as $v)
                       <tr>
                       <td>{{++$c}}</td>
                         <td>{{$v->title}}</td>
                       <td>{{$v->name}}</td>
                       <td>{{$v->username}}</td>
                       <td>{{$v->email}}</td>
                      
       

                       </tr>
                       @endforeach
                     
                        </table>


                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      