@extends('layouts.admin')
@section('title','New Course')
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

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Courses</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/new_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
                 

                            <div class="col-sm-4">
                              <label for="semester" class=" control-label">Semester</label>
                              <select class="form-control" name="semester">
                                        <option value="">Select</option>
                                  <option value="1">First Semester</option>
                                       <option value="2">Second Semester</option>
                              </select>
                             
                            </div>
                   
                        </div>
@for ($i = 0; $i < 8; $i++)
                        <div class="form-group">
                         <div class="col-sm-4">
                              <label for="Course_title" class=" control-label">Course Title</label>
                                <input id="faculty_name" type="text" class="form-control" name="course_title[{{$i}}]" value="{{ old('Course_title') }}">

                              
                            </div>
                             <div class="col-sm-4">
                              <label for="Course_code" class=" control-label">Courses Code</label>
                                <input id="course_code" type="text" class="form-control" name="course_code[{{$i}}]" value="{{ old('course_code') }}">

                            </div>

                             <div class="col-sm-4">
                              <label for="course_unit" class=" control-label">Course Unit</label>
                                <input id="course_unit" type="text" class="form-control" name="course_unit[{{$i}}]" value="{{ old('course_unit') }}">
                                </div>
                          
                           
                            </div>
                            @endfor
                           <div class="col-md-3">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Add Course
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      