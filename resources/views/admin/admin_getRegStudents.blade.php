@extends('layouts.admin')
@section('title','registered Students')
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
                <div class="panel-heading">Numbered Of students Registered</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin_getRegStudents') }}" data-parsley-validate>
                      {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                      
                      

                        

                            <div class="col-md-4">
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
                              <div class="col-md-4">
                                <label for="student_type" class="control-label">Select Student Type</label>
                                 <select class="form-control" name="student_type" required>
                               <option value="">Select</option>
                           <option value="1">PDS</option>    

                        <option value="2">Undergraduate</option>
                           <option value="3">Other Undergraduate</option> 
                             </select>

                                @if ($errors->has('student_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_type') }}</strong>
                                    </span>
                                @endif
                            </div>
<br/>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Generate
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        <div class="col-sm-6 col-sm-offset-3" style="background-color:#ccc; padding-top: 10px; padding-bottom: 10px; border-radius: 50px;">
                         @if(isset($n))
                <h1 class="text-danger text-center">{{$n}}</h1>
                 @endif
             </div>
                        </div>
                 


               
                </div>

@endsection                