@extends('layouts.admin')
@section('title','New Programme')
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
                <div class="panel-heading">Create Programme</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/new_programme') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('programme_name') ? ' has-error' : '' }}">
                         <div class="col-md-6">
                              <label for="programme_name" class=" control-label">Programme</label>
                                <input id="programme_name" type="text" class="form-control" name="programme_name" value="{{ old('programme_name') }}" required>

                                @if ($errors->has('faculty_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('programme_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                           <div class="col-md-3">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Add Programme
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      