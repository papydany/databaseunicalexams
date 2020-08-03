@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center text-danger"><strong>LOGIN</strong></div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-sm-4 control-label">Username</label>

                            <div class="col-sm-6">
                                <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autofocus >

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-sm-4 control-label">Password</label>

                            <div class="col-sm-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                     

                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>

                                
                            </div>
                        </div>
                           <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-4">
                                <a href="{{ url('password_reset') }}">I forgot my password</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
