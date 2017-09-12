@extends('layouts.admin')
@section('title','View Department')
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
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">View Department</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/view_department') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('faculty_name') ? ' has-error' : '' }}">
                         <div class="col-md-8">
                              <label for="faculty_id" class=" control-label">Faculty</label>
                                     <select class="form-control" name="faculty_id" required>
                               <option value="">Select</option>
                               @if(count($f) > 0)
                               @foreach($f as $v)
                        <option value="{{$v->id}}">{{$v->faculty_name}}</option>
                                @endforeach
                                @endif
                             </select>

                                @if ($errors->has('faculty_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                           <div class="col-md-2">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> View Department
                                </button>
                            </div>

                        </div>

                        </form>

                        @if(isset($d))
                        @if(count($d) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Department</th>
                        <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($d as $v)
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->department_name}}</td>
                       <td><div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('edit_department',$v->id)}}">Edit</a></li>
    
  </ul>
</div></td>
                       </tr>
                       @endforeach
                        </table>


                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      