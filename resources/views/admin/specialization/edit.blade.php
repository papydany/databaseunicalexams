@extends('layouts.admin')
@section('title','Edit Fos')
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
                <div class="panel-heading">Edit Specialization</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/editSpecialization') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('fos') ? ' has-error' : '' }}">
                         <div class="col-md-6">
                              <label for="fos" class=" control-label"> Name</label>
                              <input id="id" type="hidden" class="form-control" name="id" value="{{isset($f->id) ? $f->id : ''}}">
                                <input id="fos" type="text" class="form-control" name="name" value="{{isset($f->name) ? $f->name : ''}}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                              <label for="fos" class=" control-label">Level</label>
                              
                                <input id="fos" type="text" class="form-control" name="level" value="{{isset($f->level) ? $f->level: ''}}" required>

                                @if ($errors->has('level'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                                @endif
                            </div>
                           <div class="col-md-3">
                                      <br/>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Update
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      