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

                        @if(Auth::user()->faculty_id == $med)
                        <div class="col-sm-3">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level">
                               <option value=""> - - Select - -</option>
                        {{$i = 1}}
                                @foreach($l as $k => $v)
                               
                                @if($v->level_id < 3)

                                <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                              
                                @else
                                <option value="{{$v->level_id}}">PART {{$i++}}</option>
                              
                                @endif
                                 @if($v->level_id == 6)
                                   @break;
                                   @endif
                              
                                @endforeach
                                
                              </select>
                             
                            </div>
                            <input type="hidden" name="semester" value="1"/>
                        @else
                     <div class="col-sm-4">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level">
                                  @if(isset($l))
                                  @foreach($l as $v)
                                  <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>

                            <div class="col-sm-4">
                              <label for="semester" class=" control-label">Semester</label>
                              <select class="form-control" name="semester">
                                  @if(isset($s))
                                  @foreach($s as $v)
                                  <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>
                            @endif
                      @if(Auth::user()->programme_id == 4)
                             <div class="col-sm-4">
                              <label for="semester" class=" control-label">Entry Month</label>
                              <select class="form-control" name="month">
                                 <option value="">-- Select --</option>
                                 <option value="1">April Contact</option>
                                 <option value="2">August Contact</option>
                                 
                              </select>
                             
                            </div>
                            @endif
                        </div>
@for ($i = 0; $i < 10; $i++)
                        <div class="form-group">
                         <div class="col-sm-4">
                              <label for="Course_title" class=" control-label">Course Title</label>
                                <input id="faculty_name" type="text" class="form-control" name="course_title[{{$i}}]" value="{{ old('Course_title') }}">

                              
                            </div>
                             <div class="col-sm-3">
                              <label for="Course_code" class=" control-label">Courses Code</label>
                                <input id="course_code" type="text" class="form-control" name="course_code[{{$i}}]" value="{{ old('course_code') }}">

                            </div>
                            @if(Auth::user()->faculty_id == $med)
                            <input type="hidden" name="course_unit[{{$i}}]" value="3"/>
                            <input type="hidden" name="status[{{$i}}]" value="C"/>
                            @else

                             <div class="col-sm-2">
                              <label for="course_unit" class=" control-label">Course Unit</label>
                                <input id="course_unit" type="text" class="form-control" name="course_unit[{{$i}}]" value="{{ old('course_unit') }}">
                                </div>
                          
                            <div class="col-sm-2">
                              <label for="course_unit" class="control-label">Course Status</label>
                              <select class="form-control" name="status[{{$i}}]">
                              <option value=""> -- Select -- </option>
                                <option value="C">Compulsary</option>
                                  <option value="E">Elective</option>
                                  </select>
                              
                                </div>
                                @endif
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