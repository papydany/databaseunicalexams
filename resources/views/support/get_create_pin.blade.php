@extends('layouts.admin')
@section('title','Create Admin')
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
                <div class="panel-heading">Create Pin</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/create_pin') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                         <div class="col-md-3">
                              <label for="name" class=" control-label">number of pin</label>
                                <input id="number" type="number" class="form-control" name="number" value="{{ old('number') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                      

                            <div class="col-md-3">
                                <label for="password-confirm" class="control-label">pin Lenght</label>
                                 <select class="form-control" name="pin_lenght" required>
                               <option value="">Select</option>
                               @for($i=8;$i < 13; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                                @endfor
                             </select>

                                @if ($errors->has('pin_lenght'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pin_lenght') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label for="session" class="control-label">pin session</label>
                                 <select class="form-control" name="session" required>
                               <option value="">Select</option>
                               @for($i=2016;$i <= Date('Y'); $i++)
                               {{$next =$i+1}}

                        <option value="{{$i}}">{{$i.' / '.$next}}</option>
                                @endfor
                             </select>

                                @if ($errors->has('session'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('session') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Generate Pin
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      