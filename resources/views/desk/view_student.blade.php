@extends('layouts.admin')
@section('title','View student')
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
            <div class="panel-heading">View student</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/view_student') }}" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="form-group">



                        <div class="col-sm-3">
                            <label for="fos" class=" control-label">Field Of Study</label>
                            <select class="form-control" name="fos_id" required>
                                <option value=""> - - Select - -</option>

                                @foreach($f as $v)
                                    <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-sm-3">
                            <label for="session" class=" control-label">Session</label>
                            <select class="form-control" name="session_id" required>
                                <option value=""> - - Select - -</option>

                                @for ($year = (date('Y')); $year >= 2016; $year--)
                                    {{!$yearnext =$year+1}}
                                    <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                @endfor

                            </select>

                        </div>

                        <div class="col-sm-3">
                            <label for="session" class=" control-label">Entry Month</label>
                            <select class="form-control" name="entry_month" required>
                                @if(Auth::user()->programme_id == 4)
                                <option value=""> - - Select - -</option>
                                    <option value="1">April</option>
                                    <option value="1">August</option>
                                @else
                                    <option value="0">January</option>
                                @endif


                            </select>

                        </div>


                        <div class="col-sm-3">
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
                        {{!$next = $s + 1}}

            <div class="col-sm-12">


                        <p>
                            <span><strong>Entry Year : </strong>{{$s.' / '.$next}}</span></p>

                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>S/N</th>
                                <th>Matric Number</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Gender</th>

                            </tr>
                            {{!!$c = 0}}
                            @foreach($u as $v)
                                <tr>
                                    <td>{{++$c}}</td>
                                    <td>{{$v->matric_number}}</td>
                                    <td>{{$v->surname." ".$v->firstname." ".$v->othername}}</td>
                                    <td>{{$v->phone}}</td>
                                    <td>{{$v->gender}}</td>
                                </tr>
                            @endforeach
                        </table>

                    @else
                        <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
                            No Student is available!!!
                        </div>

                    @endif
                @endif
            </div>
        </div>
    </div>
</div>


@endsection

