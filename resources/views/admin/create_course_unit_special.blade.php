@extends('layouts.admin')
@section('title','Create Course Unit')
@section('content')
@inject('R','App\R')
<?php $result= $R->getrolename(Auth::user()->id) ?>
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
                <div class="panel-heading">Create Course Unit 
                @if($result =="support" || $result =="admin")
                <a href="create_course_unit" class="btn btn-info pull-right">
                                    <i class="fa fa-btn fa-user"></i> Back 
                                </a>
                   @endif             
                                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/create_course_unit_special') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                        
                               <div class="col-sm-2">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                            @if($result =="Deskofficer")
                            <div class="col-sm-3">
                                <input type="hidden" name="department" value="{{$ud->department_id}}">
                            <label for="fos" class=" control-label">Field Of Study</label>
                            <select class="form-control" name="fos" required>
                                <option value=""> - - Select - -</option>

                                @foreach($f as $v)
                                    <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                @endforeach

                            </select>

                        </div>
                            @else
                              <div class="col-sm-2">
                              <label for="session" class="control-label">Department</label>
                              <select class="form-control" name="department" id="department_id" required>
                              <option value=""> - - Select - -</option>
                               
                                  @foreach ($d as $v)
                                 
                                  <option value="{{$v->id}}">{{$v->department_name}}</option>
                                  @endforeach
                                
                              </select>
                             
                            </div>
                            <div class="col-sm-2">
                              <label for="fos" class="control-label">Field Of Study</label>
                              <select class="form-control" name="fos" id="fos_id" required>
                            
                                
                              </select>
                             
                            </div>
                            @endif
                              <div class="col-sm-2">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" required>
                              <option value=""> - - Select - -</option>
                               
                                 
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
                       <div class="col-sm-1">
                                <label for="min" class="control-label">min Unit</label>
                                <input type="text" name="min" class="form-control" required>

                                @if ($errors->has('min'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('min') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-1">
                                <label for="max" class="control-label">max Unit</label>
                                <input type="text" name="max" class="form-control" required>

                                @if ($errors->has('max'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('max') }}</strong>
                                    </span>
                                @endif
                            </div>

                            

                            <div class="col-md-2">
                            <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Create
                                </button>
                            </div>

                        </div>

                        </form>
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

                    