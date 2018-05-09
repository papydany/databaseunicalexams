@extends('layouts.admin')
@section('title','New FOS')
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
        <div class="col-sm-12" style="min-height: 420px;">
            <div class="panel panel-default">
                <div class="panel-heading">Create Field Of Study</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/new_fos') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                         <div class="col-md-4">
                              <label for="fos_name" class=" control-label">New FOS</label>
                                <input id="fos_name" type="text" class="form-control" name="fos_name" value="{{ old('department_name') }}" required>

                                @if ($errors->has('fos_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fos_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                      

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
                              <label for="duration" class=" control-label">Duration</label>
                                <input id="duration" type="number" class="form-control" name="duration" value="{{ old('duration') }}" required>

                                @if ($errors->has('duration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('duration') }}</strong>
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
@endsection  
@section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection
                   