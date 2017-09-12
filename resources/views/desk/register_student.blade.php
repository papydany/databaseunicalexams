@extends('layouts.admin')
@section('title','View Registered student')
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

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">View Registered Student</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register_student') }}" data-parsley-validate >
                    {{ csrf_field() }}
                    <div class="form-group">



                        <div class="col-sm-3 col-md-2">
                            <label for="fos" class=" control-label">Field Of Study</label>
                            <select class="form-control" name="fos_id" required>
                                <option value=""> - - Select - -</option>

                                @foreach($f as $v)
                                    <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-sm-3 col-md-2">
                            <label for="session" class=" control-label">Session</label>
                            <select class="form-control" name="session_id" required>
                                <option value=""> - - Select - -</option>

                                @for ($year = (date('Y')); $year >= 2016; $year--)
                                    {{!$yearnext =$year+1}}
                                    <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                @endfor

                            </select>

                        </div>

                        <div class="col-sm-3 col-md-2">
                            <label for="semester" class=" control-label">Semester</label>
                            <select class="form-control" name="semester_id">
                                <option value=""> - - Select - -</option>
                                @if(isset($s))
                                    @foreach($s as $v)
                                        <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="col-sm-3 col-md-2">
                            <label for="level" class=" control-label">Level</label>
                            <select class="form-control" name="level">
                                <option value=""> - - Select - -</option>
                                @if(isset($l))
                                    @foreach($l as $v)
                                        <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="col-sm-3 col-md-2">
                            <label for="level" class=" control-label">Season</label>
                            <select class="form-control" name="season">
                                <option value=""> - - Select - -</option>

                                        <option value="NORMAL">NORMAL</option>
                                <option value="VACATION">VACATION</option>

                            </select>

                        </div>

                        <div class="col-sm-3 col-md-2">
                            <br/>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fa fa-btn fa-user"></i> View Student
                            </button>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>
    @if(isset($u))
        @if(count($u) > 0)
            {{!$next = $ss+1}}
            <div class="col-sm-12">
 <form class="form-horizontal" role="form" method="POST" action="{{ url('/more_result') }}" data-parsley-validate>
                                        {{ csrf_field() }}

                <p>
                    <span><strong>Entry Year : </strong>{{$ss." / ".$next}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span><strong>Level : </strong>{{$l_id}}00</span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span><strong>Semester : </strong>
                    @if(Auth::user()->programme_id == 4)

                    @else
                        @if($l_id == 1)
                         First
                        @else
                       Second
                        @endif
                  </span>
                     @endif
                </p>

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>S/N</th>
                       <!-- <th>Select</th>-->
                        <th>Matric Number</th>
                        <th>Name</th>
                       <!-- <th>View Course</th>-->

                    </tr>
                    {{!!$c = 0}}
                    @foreach($u as $v)
                        <tr>
                            <td>{{++$c}}</td>
                            <!--<td><input type="checkbox" value="{{$v->id}}" name="id[]"> </td>-->
                            <td>{{$v->matric_number}}</td>
                            <td>{{$v->surname." ".$v->firstname." ".$v->othername}}</td>
                           <!-- <td>
                                <button type="button" class="btn btn-danger " data-toggle="modal" data-target="#myModal{{$v->id}}">Enter Result</button></td>-->
                        </tr>
<!-- ======== =============== for student course reg ========================================-->
                        
                        {{! $course =DB::connection('mysql2')->table('course_regs')
                         ->where('studentreg_id',$v->id)
                         ->get()
                         }}
@if(isset($course))
@if(count($course) > 0)


                                <div id="myModal{{$v->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/entering_result') }}" data-parsley-validate>
                                        {{ csrf_field() }}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title text-center text-danger">{{strtoupper($v->surname." ".$v->firstname." ".$v->othername)}}</h4>
                                        <h4 class="modal-title text-center text-success">{{$v->matric_number}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-sm-offset-1 col-sm-10" style="margin-bottom: 5px;">
                                        <div class="col-sm-3 text-center" >Code</div>
                                        <div class="col-sm-3 text-center" >Unit</div>
                                        <div class="col-sm-3 text-center" >Grade</div>
                                         <input type="hidden" name="fos_id" value="{{$v->fos_id}}"/>
                                            <input type="hidden" name="user_id" value="{{$v->user_id}}"/>
                                            <input type="hidden" name="matric_number" value="{{$v->matric_number}}"/>
                                            <input type="hidden" name="session_id" value="{{$v->session}}"/>
                                            <input type="hidden" name="semester_id" value="{{$v->semester}}"/>
                                            <input type="hidden" name="level_id" value="{{$v->level_id}}"/>
                                            <input type="hidden" name="season" value="{{$v->season}}"/>
                                            </div>
                                        @foreach($course as $vv)
<!-- ================================== for student result ========================================-->
                        {{! $result =DB::connection('mysql2')->table('student_results')
                         ->where('coursereg_id',$vv->id)
                         ->get()
                         }}        
                                            <div class="col-sm-offset-1 col-sm-10" style="margin-bottom: 9px;">
                                            <div class="col-sm-3 text-center text-success" > {{$vv->course_code}}</div>
                                            <div class="col-sm-3 text-center text-info" >{{$vv->course_unit}}</div>
                                            <div class="col-sm-3 text-center text-danger">
                                            @if(count($result) > 0)
                                            @foreach($result as $rv)
 <input type="text" class="form-control" name="grade[{{$rv->id.'~'.$vv->id.'~'.$vv->course_id.'~'.$vv->course_unit}}]" value="{{$rv->grade}}"/>
                                            @endforeach
                                            @else
 <input type="text" class="form-control" name="grade[{{$vv->id.'~'.$vv->course_id.'~'.$vv->course_unit}}]" value=""/>
                                            @endif
                                               

                                                </div>
                                                </div>
                                                <div class="clearfix"></div>


                                            @endforeach



                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                        

                            </div>
                        </div>
                            @endif
                        @endif
</form>
                    @endforeach
                </table>
                 <!--<button type="submit" class="btn btn-danger">Submit</button>-->
                </form>

                @else
                    <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
                        No Student is avalable!!!
                    </div>

                @endif
                @endif
            </div>
</div>
</div>
</div>


@endsection