@extends('layouts.admin')
@section('title','Convert Pin')
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
                <!-- /.row -->
                <div class="row" style="min-height: 520px;">
                <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Convert Pin</div>
                <div class="panel-body">
                    

                    <div class="col-sm-6">

                                 <form class="form-horizontal" role="form" method="POST" action="{{ url('convert_pin') }}" data-parsley-validate>
                                  {{ csrf_field() }}
                   <div class="form-group{{ $errors->has('start_serial_number') ? ' has-error' : '' }}">
                      <div class="col-md-12 form-group">
                                <label for="start_serial_number" class="control-label">Start Serial Number</label>
                                <input type="text" class="form-control" name="start_serial_number" value="">
                             @if ($errors->has('start_serial_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_serial_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="end_serial_number" class="control-label">End Serial Number</label>
                                <input type="text" class="form-control" name="end_serial_number" value="">
                             @if ($errors->has('end_serial_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('end_serial_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                              <div class="col-md-12 form-group">
                                <label for="session" class="control-label">Select session</label>
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
                            <br/>


<br/>
                            <div class="col-md-3 form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Convert
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