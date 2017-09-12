@extends('layouts.admin')
@section('title','Edit Faculty')
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
                <div class="panel-heading">Edit Faculty</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/post_edit_faculty') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('faculty_name') ? ' has-error' : '' }}">
                         <div class="col-md-6">
                              <label for="department_name" class=" control-label">Faculty</label>
                              <input id="id" type="hidden" class="form-control" name="id" value="{{isset($f->id) ? $f->id : ''}}">
                                <input id="faculty_name" type="text" class="form-control" name="faculty_name" value="{{isset($f->faculty_name) ? $f->faculty_name : ''}}" required>

                                @if ($errors->has('faculty_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                           <div class="col-md-3">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Update faculty
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      