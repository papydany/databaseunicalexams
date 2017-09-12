@extends('layouts.admin')
@section('title','New Lecturers')
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
                <div class="panel-heading">Create Lecturer</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/new_lecturer') }}" data-parsley-validate>
                        {{ csrf_field() }}
@for ($i = 0; $i < 10; $i++)
                        <div class="form-group{{ $errors->has('faculty_name') ? ' has-error' : '' }}">
                         <div class="col-sm-2">
                              <label for="faculty_name" class=" control-label">Title</label>
                               <select class="form-control" name="title[{{$i}}]">
                               <option value="">Select</option>
                                   <option value="Mr">Mr</option>
                                   <option value="Mrs">Mrs</option>
                                   <option value="Miss">Miss</option>
                                   <option value="Dr">Dr</option>
                                     <option value="Dr(Mrs)">Dr(Mrs)</option>
                                   <option value="Prof">Prof</option>
                                  <option value="Prof(Mrs)">Prof(Mrs)</option>
                                  <option value="Assoc Prof">Assoc Prof</option>
                                   <option value="Rev(Dr)">Rev(Dr)</option>
                                   <option value="Rev(Sis)">Rev(Sis)</option>
                                   <option value="Rev(prof)">Rev(Prof)</option>
                                   <option value="Barr">Barr</option>
                                   <option value="Barr Mrs">Barr Mrs</option>
                             
                               </select>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                         <div class="col-sm-4">
                              <label for="faculty_name" class=" control-label">Name</label>
                                <input id="faculty_name" type="text" class="form-control" name="name[{{$i}}]" value="{{ old('faculty_name') }}">

                                @if ($errors->has('faculty_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                             <div class="col-sm-3">
                              <label for="faculty_name" class=" control-label">Username</label>
                                <input id="faculty_name" type="text" class="form-control" name="username[{{$i}}]" value="{{ old('faculty_name') }}">

                                @if ($errors->has('faculty_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="col-sm-3">
                              <label for="faculty_name" class=" control-label">Password</label>
                                <input id="faculty_name" type="text" class="form-control" name="password[{{$i}}]" value="{{ old('faculty_name') }}">

                                @if ($errors->has('faculty_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            </div>
                            @endfor
                           <div class="col-md-3">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Add Lecturer
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      