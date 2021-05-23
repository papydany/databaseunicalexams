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
 @if(Auth::user()->email == null)

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-justified text-danger" id="exampleModalLabel"> NOTICE!  NOTICE!!  NOTICE!!!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p> Result Uploading will be </p>

     <p>Every User is advice to update their account, with a valid <strong>Email address.</strong> This is to enable you reset the passwords if forgotton.</p>
        <p class="text-danger"><strong>NB</strong></p> 
         <ul>
         <li>   To reset your password, you must have updated the portal with your valid email address.</li>
         <li> Click on the reset password link on the login page</li>
         <li> Enter your username name. (the system admin can fetch your username for you)</li>
         <li>A link will be sent to your email you have entered into the portal</li>
         <li>Login to your email account and click on the link that redirect to our portal. Enter your new password and submit</li>
     </ul>
     <p><strong class="text-danger">Henceforth, Admin will not be responsible for the retrieving of your password.We can only help with your username. </strong> Once you update your email address you will stop seeing these pop up.</p>
     
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>
@endif
      <?php $result= $r->getrolename(Auth::user()->id); ?>

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
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-2x"></i>
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
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"></div>
                                        <div>Registered Students</div>
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
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-2x"></i>
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
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-2x"></i>
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
                                        <i class="fa fa-comments fa-2x"></i>
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
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div>Assign Exams Officer Role</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('assign_exams_officer')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                      <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div>Transfer Officer</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('transfer_officer')}}">
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
                                        <i class="fa fa-support fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div>Courses With No Result</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('course_with_no_result')}}">
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
                                        <i class="fa fa-comments fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div>Publish Result</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('publish_result')}}">
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
                                        <i class="fa fa-tasks fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            <a href="">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                      <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            <a href="">
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
                                        <i class="fa fa-support fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            <a href="">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
               
                
                </div>
                @endif
                @if($result =="Deskofficer")
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
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                    
                                        </div>
                                        <div> Student Management</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('studentManagement')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                @endif
</div>

@endsection
