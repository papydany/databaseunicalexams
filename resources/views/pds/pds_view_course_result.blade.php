@extends('layouts.admin')
@section('title','View Result')
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
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">View Student</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" target="_blank" action="{{ url('/pds_view_course_result') }}" data-parsley-validate>
                           {{ csrf_field() }}
                        <div class="form-group">
                     <div class="col-sm-4">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session" required>
                                 <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                              </select>
                             
                            </div>

                               <div class="col-sm-4">
                              <label for="semester" class=" control-label">Course</label>
                              <select class="form-control" name="course" required>
                                 <option value=""> - - Select - -</option>
                                 @foreach($c as $v)
                                 <option value="{{$v->id}}">{{$v->course_title}}</option>
                               
                                  @endforeach
                              </select>
                             
                            </div>



                            

                          
                       

                           <div class="col-sm-3">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> continue
                                </button>
                            </div>

                        </div>

                        </form>


                        
                        </div>
                        </div>
                        </div>
                        </div>

@endsection