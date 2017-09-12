@extends('layouts.admin')
@section('title','Register Students')
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
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/pds_student1') }}" data-parsley-validate>
                    
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
                              <label for="semester" class=" control-label">Semester</label>
                              <select class="form-control" name="semester" required>
                                 <option value=""> - - Select - -</option>
                                 <option value="1">First Semester</option>
                                  <option value="2">Second Semester</option>
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


                         @if(isset($u))

                        @if(count($u) > 0)
                          <hr/>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/pds_result') }}" data-parsley-validate>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="semester" value="{{$s}}">
                                          <input type="hidden" name="session" value="{{$ss}}">
                        <table class="table table-bordered table-striped">
                        <tr><th></th>
                        <th>S/N</th>
                        <th>Names</th>
                        <th>Matric Number</th>
                        <th>Sex</th>
                      
                        <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($u as $v)
                       <tr>
                       <td><input type="checkbox" value="{{$v->id}}" name="id[]"> </td>
                       <td>{{++$c}}</td>
                       <td>{{$v->surname." ".$v->firstname." ".$v->othername}}</td>
                       <td>{{$v->matric_number}}</td>
                       <td>{{$v->gender}}</td>
                      
                       <td><div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Edit</a></li>
    
  </ul>
</div></td>
                       </tr>
                       @endforeach
                        </table>
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </form>
{{$u->setPath($url)->render()}}
                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

@endsection