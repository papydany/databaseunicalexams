@extends('layouts.admin')
@section('title','View Used Pin')
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
                <div class="panel-heading">Used Pin</div>
                <div class="panel-body">
                    <div class="col-sm-6">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/get_used_pin') }}" data-parsley-validate>
                      
                   <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                      <div class="col-md-8">
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
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Viewed Used Pin
                                </button>
                            </div>

                        </div>

                        </form>
                    </div>
                    <div class="col-sm-6">

                                 <form class="form-horizontal" role="form" method="GET" action="{{ url('/get_serial_number') }}" data-parsley-validate>
                   <div class="form-group{{ $errors->has('serial_number') ? ' has-error' : '' }}">
                      <div class="col-md-6">
                                <label for="serial_number" class="control-label">Enter Serial Number</label>
                                <input type="text" class="form-control" name="serial_number" value="">
                             @if ($errors->has('serial_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serial_number') }}</strong>
                                    </span>
                                @endif
                            </div>
<br/>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Submit
                                </button>
                            </div>

                        </div>

                        </form>
                    </div>
                        </div>
                        </div>
                        </div>
                @if(isset($pin))
               

<table class="table table-bordered table-striped">
                <tr>
                <th>S/N</th>
                <th>Student Id</th>
                <th>Matric Number</th>
                 <th>Seria Number</th>
                 <th>Pin</th>
                 <th>Last date updated</th>
                </tr>
                <tr>
                    

                  @if(count($pin) > 0)   
                  <th>1</th>
                <th>{{$pin->student_id}}</th>
                <th>{{$pin->matric_number}}</th>
                 <th>{{$pin->id}}</th>
                 <th>{{$pin->pin}}</th>
                 <th>{{date('F j , Y - h:i:sa',strtotime($pin->updated_at))}}</th>  
                </tr>
               
                @endif
                @endif
                 
                @if(isset($u))

                @if(count($u) > 0)
                <table class="table table-bordered table-striped">
                <tr>
                <th>S/N</th>
                <th>Student Id</th>
                <th>Matric Number</th>
                 <th>Seria Number</th>
                 <th>Pin</th>
                 <th>Last date updated</th>
                </tr>
               {{!!$c = 0}}
                @foreach($u as $v)
                <tr>
                <td>{{++$c }}</td>
                <td>{{$v->student_id}}</td>
                <td>{{$v->matric_number}}</td>
                <td>{{$v->id}}</td>
              
                <td>{{$v->pin}}</td>
                  <td>{{date('F j , Y - h:i:sa',strtotime($v->updated_at))}} </td>
                </tr>
                


                @endforeach 	


                </table>
 <p> {{$u->setPath($url)->render()}}   </p>
                @endif
                @endif

               
                </div>

@endsection                