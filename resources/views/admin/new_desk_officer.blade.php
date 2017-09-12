@extends('layouts.admin')
@section('title','New Desk Officer')
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
                <div class="panel-heading">Create Desk Officer</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/new_desk_officer') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                         
                      

                            <div class="col-md-4">
                                <label for="faculty_id" class="control-label">Select Faculty</label>
                                 <select class="form-control" name="faculty_id" id="faculty_id" required>
                               <option value="">Select</option>
                               @if(count($f) > 0)
                               @foreach($f as $v)
                        <option value="{{$v->id}}">{{$v->faculty_name}}</option>
                                @endforeach
                                @endif
                             </select>

                                @if ($errors->has('faculty_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="col-md-4">
                                <label for="department_id" class="control-label">Select Department</label>
                                 <select class="form-control" name="department_id" id="department_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>

                           <!-- <div class="col-md-4">
                              <label for="fos_name" class=" control-label">New FOS</label>
                                
 <select multiple class="form-control" name="fos_id" id="fos_id" required></select>
                                @if ($errors->has('fos_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fos_name') }}</strong>
                                    </span>
                                @endif
                            </div>-->

                             <div class="col-md-4">
                                <label for="programme_id" class="control-label">Select Programme</label>
                                 <select class="form-control" name="programme_id"  required>
                               <option value="">Select</option>
                               @if(count($p) > 0)
                               @foreach($p as $v)
                        <option value="{{$v->id}}">{{$v->programme_name}}</option>
                                @endforeach
                                @endif
                             </select>

                                @if ($errors->has('programme_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('programme_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="col-md-4">
                              <label for="name" class=" control-label">Name</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4">
                              <label for="username" class=" control-label">username</label>
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="col-md-4">
                              <label for="password" class=" control-label">Password</label>
                                <input id="password" type="text" class="form-control" name="password" value="{{ old('password') }}" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                            <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Create
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>
@endsection  
@section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection
     <div class="modal fade" id="myModal" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
       
        <div class="modal-body text-danger text-center">
          <p>... processing ...</p>
        </div>
       
      </div>
      
    </div>
  </div>                    