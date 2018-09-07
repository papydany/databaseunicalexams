@extends('layouts.admin')
@section('title','HOME')
@section('content')
@inject('r','App\R')
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
                <!-- /.row -->

<div class="row" style="min-height: 420px;">
      <?php $result= $r->getrolename(Auth::user()->id) ?>

  @if($result =="admin" || $result =="support" )
  <div class="row">
    <div class="col-sm-6">
           <form class="form-horizontal" role="form" method="GET" action="{{ url('/admin_studentdetails') }}" data-parsley-validate>
                      {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                      
                       <div class="col-md-8">
                                <label for="student_type" class="control-label">Matric Number</label>
                                <input type="text" name="matric_number" value="" class="form-control" />
                      

                                @if ($errors->has('student_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_type') }}</strong>
                                    </span>
                                @endif
                            </div>
<br/>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Search for Student
                                </button>
                            </div>

                        </div>

                        </form>
  </div>
   @if($result =="support")
      <div class="col-sm-6">
           <form class="form-horizontal" role="form" method="GET" action="{{ url('get_student_with_entry_year') }}" data-parsley-validate>
                      

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                      
                       <div class="col-md-8">
                                <label for="student_type" class="control-label">Entry Year</label>
                                <input type="text" name="entry_year" value="" class="form-control" />
                      

                               
                            </div>
<br/>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i>Continue
                                </button>
                            </div>

                        </div>

                        </form>
  </div>
  @endif
</div>
<hr/>
 <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-3x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div>Number Of Register Student</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('admin_getRegStudents')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-3x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"></div>
                                        <div>Course Registered Students</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('admin_courseRegStudents')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-3x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"></div>
                                        <div>View Students</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('admin_viewStudents')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-3x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"></div>
                                        <div>Contact Mail</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('contactMail')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-3x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div>Assign HOD Role</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('assign_hod_role')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                     <!-- <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-3x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div>Add Courses</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('assign_hod_role')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>-->
               
                
                </div>
                @endif
</div>

@endsection
