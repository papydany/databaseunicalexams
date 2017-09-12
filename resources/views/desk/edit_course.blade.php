@extends('layouts.admin')
@section('title','Edit lecturer')
@section('content')
 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>

  <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Course</div>
                <div class="panel-body">
                   
                        @if(isset($c))
                        <form method="POST" action="{{url('edit_course',$c->id)}}" data-parsley-validate>
                        {{ csrf_field() }}
                        <table class="table table-bordered table-striped">
                        <tr>
                   
                          <th> Course Title</th>
                        <th> Course Code </th>
                        
                        <th>Course Unit</th>
                        <th>Status</th>
                   <th>Action</th>
                       </tr>
                       
                       <tr>
                     
                         <td> <input  type="text" class="form-control" name="course_title" value="{{$c->course_title}}" required></td>
                       <td>  <input  type="text" class="form-control" name="course_code" value="{{$c->course_code}}" required></td>
                
                       <td><input  type="text" class="form-control" name="course_unit" value="{{$c->course_unit}}" required></td>
                       <td><select class="form-control" name="status" required>
                              <option value=""> -- Select -- </option>
                                <option value="C">Compulsary</option>
                                  <option value="E">Elective</option>
                                  </select></td>
                      
       <td><input type="submit" name="" class="btn btn-success" value="submit"></td>

                       </tr>
                   
                     
                        </table>
 
</form>
                    
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      