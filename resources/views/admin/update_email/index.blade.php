@extends('layouts.admin')
@section('title','Change Email')
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
                <div class="panel-heading">Update Officer  Email</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('update_email') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                         <div class="col-md-6">
                              <label for="password" class=" control-label">Enter New Email</label>
                              <input  type="hidden" name="id" value="{{ $d->id }}">

                               
                                <input  type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                           <div class="col-md-3">
                                      <br/>
                                <button type="submit" class="btn btn-success">
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