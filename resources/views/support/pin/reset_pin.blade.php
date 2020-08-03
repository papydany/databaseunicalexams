@extends('layouts.admin')
@section('title','Reset Pin')
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
                <div class="panel-heading">Reset Pin</div>
                <div class="panel-body">
                    

                    <div class="col-sm-6">

                                 <form class="form-horizontal" role="form" method="POST" action="{{ url('reset_pin') }}" data-parsley-validate>
                                  {{ csrf_field() }}
                   <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                      <div class="col-md-12 form-group">
                                <label for="start_serial_number" class="control-label"> Serial Number</label>
                                <input type="text" class="form-control" name="id" value="">
                             @if ($errors->has('id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id') }}</strong>
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
                                    <i class="fa fa-btn fa-user"></i>Reset
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