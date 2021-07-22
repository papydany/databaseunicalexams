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
                <div class="panel-heading">Edit Fos</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_fos') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('fos') ? ' has-error' : '' }}">
                         <div class="col-md-6">
                              <label for="fos" class=" control-label">Fos Name</label>
                              <input id="id" type="hidden" class="form-control" name="id" value="{{isset($f->id) ? $f->id : ''}}">
                                <input id="fos" type="text" class="form-control" name="fos_name" value="{{isset($f->fos_name) ? $f->fos_name : ''}}" required>

                                @if ($errors->has('fos_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fos_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label for="fos" class=" control-label">Degree</label>
                                
                                  <input id="fos" type="text" class="form-control" name="degree" value="{{isset($f->degree) ? $f->degree: ''}}" required>
  
                                  @if ($errors->has('degree'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('degree') }}</strong>
                                      </span>
                                  @endif
                              </div>
                            <div class="col-md-3">
                              <label for="fos" class=" control-label">Duration</label>
                              
                                <input id="fos" type="text" class="form-control" name="duration" value="{{isset($f->duration) ? $f->duration: ''}}" required>

                                @if ($errors->has('duration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                @endif
                            </div>
                           <div class="col-md-3">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Update Fos
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      