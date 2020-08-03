@extends('layouts.admin')
@section('title','Publish Result')
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
        <div class="col-sm-12" style="min-height: 420px;">
            <div class="panel panel-default">
                <div class="panel-heading">Publish Result</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('get_publish_result') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label for="department_id" class="control-label">Select Programme</label>
                                   <select class="form-control" name="programme_id"  required>
                               <option value="">Select</option>
                               @if(count($p) > 0)
                               @foreach($p as $v)
                        <option value="{{$v->id}}">{{$v->programme_name}}</option>
                                @endforeach
                                @endif
                             </select>
                            </div>

                            <div class="col-md-4">
                                <label for="faculty_id" class="control-label">Select Faculty</label>
                                 <select class="form-control" name="faculty_id" id="faculty_id1" required>
                               <option value="">Select</option>
                               @if(count($f) > 0)
                               @foreach($f as $v)
                        <option value="{{$v->id}}">{{$v->faculty_name}}</option>
                                @endforeach
                                @endif
                             </select>

                                @if ($errors->has('faculty_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="col-md-4">
                                <label for="department_id" class="control-label">Select Department</label>
                                 <select class="form-control" name="department_id" id="department_id1"  required>
                               <option value="">Select</option>
                               </select>
                            </div>
                            <div class="col-md-4">
                                    <label for="session" class="control-label">Select Session</label>
                            <select class="form-control" name="session" required>
                                    <option value=""> Select Session</option>
                                     
                                        @for ($year = (date('Y')); $year >= 2016; $year--)
                                        {{!$yearnext =$year+1}}
                                        <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                        @endfor
                                      
                                    </select>
                            </div>
                            <div class="col-md-4">
                                    <label for="level" class="control-label">Select Level</label>
                            <select class="form-control" name="level" required>
                                    <option value=""> Select Level</option>
                                     
                                       
                                        <option value="1">100</option>
                                        <option value="2">200</option>
                                        <option value="3">300</option>
                                        <option value="4">400</option>
                                        <option value="5">500</option>
                                        <option value="6">600</option>
                                        <option value="7">700</option>
                                        <option value="8">800</option>
                                      
                                    </select>
                            </div>
                            <div class="col-md-3">
                                <br/>
                                    <button type="submit" class="btn btn-success btn-l">
                                        <i class="fa fa-btn fa-user"></i> Continue
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if(isset($fos))
                        @if(count($fos))
                        <hr/>
                    <div class="col-sm-12"><p><b>Level</b> {{$l}}00
                        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <b> session</b> {{$s}} / {{$ns}}</p></div>
                        <div class="col-sm-6">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('publish') }}" data-parsley-validate>
             {{ csrf_field() }}
                        <table class="table table-bordered table-striped">
                                <input type="hidden" name="level_id" value="{{$l}}" />
                                <input type="hidden" name="session" value="{{$s}}" />
                        @foreach ($fos as $v)
                        <tr>
                            <td><input type="checkbox" name="fos_id[]" value="{{$v->id}}" /></td>
                            <td colspan="2">{{$v->fos_name}}</td>
                            
                        </tr>

                            
                        @endforeach
                        <tr>
                            
                                    <td colspan="3"><button type="submit" class="btn btn-primary btn-l">
                                            <i class="fa fa-btn fa-user"></i> Submit
                                        </button></td>
                        </tr>
                        </table>
            </form>
                        </div>
                        @if(isset($pr))
                        @if(count($pr))
                        <div class="col-sm-6">
            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Field Of Study</th>
                                    <th>date published last</th>
                                </tr>
                                @foreach ($pr as $v)
                                <tr>
                                        <td>{{$v->fos->fos_name}}</td>
                                        <td>{{date('d-M-Y',strtotime($v->publish_date))}}</td>
                                    </tr>   
                                @endforeach
                                
                            </table>
            
                        </div>
                        @endif
                        @endif

                    @endif
                    @endif
                        </div>
                        </div>
                        </div>
                        </div>

     <div class="modal fade" id="myModal" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
       
        <div class="modal-body text-danger text-center">
          <p>... processing ...</p>
        </div>
       
      </div>
      
    </div>
  </div>                        
@endsection  
@section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection
                   