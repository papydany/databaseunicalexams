@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                        @if(Session::has('warning'))
<div class=" col-sm-12 alert alert-warning" role="alert" >
      {{Session::get('warning')}}
  </div>
      @endif
                              @if(Session::has('success'))
<div class=" col-sm-12 alert alert-success" role="alert" >
      {{Session::get('success')}}
  </div>
      @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('password_reset') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Enter Username</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
