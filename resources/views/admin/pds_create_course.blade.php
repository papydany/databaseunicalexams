@extends('layouts.admin')
@section('title','PDS New Course')
@section('content')
 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/pds_create_course') }}" data-parsley-validate>
                        {{ csrf_field() }}
                 
@for ($i = 0; $i < 5; $i++)
                        <div class="form-group">
                         <div class="col-sm-6">
                              <label for="Course_title" class=" control-label">Course Title</label>
                                <input id="faculty_name" type="text" class="form-control" name="course_title[{{$i}}]" value="{{ old('Course_title') }}">

                              
                            </div>
                             <div class="col-sm-3">
                              <label for="Course_code" class=" control-label">First semester Courses Code</label>
                                <input id="course_code" type="text" class="form-control" name="f_course_code[{{$i}}]" value="{{ old('course_code') }}">

                            </div>
  <div class="col-sm-3">
                              <label for="Course_code" class=" control-label">Second semester Courses Code</label>
                                <input id="course_code" type="text" class="form-control" name="s_course_code[{{$i}}]" value="{{ old('course_code') }}">

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