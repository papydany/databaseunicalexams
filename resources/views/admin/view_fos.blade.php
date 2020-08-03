@extends('layouts.admin')
@section('title','View Fos')
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
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">View Fos</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/view_fos') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                         <div class="col-md-8">
                              <label for="department_id" class=" control-label">Department</label>
                                     <select class="form-control" name="department_id" required>
                               <option value="">Select</option>
                               @if(count($d) > 0)
                               @foreach($d as $v)
                        <option value="{{$v->id}}">{{$v->department_name}}</option>
                                @endforeach
                                @endif
                             </select>

                                @if ($errors->has('department_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('department_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                           <div class="col-md-2">
                                      <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> View Field Of Study
                                </button>
                            </div>

                        </div>

                        </form>

                        @if(isset($fos))
                        @if(count($fos) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Fos</th>
                        <th>Programme</th>
                        <th>duration</th>
                        <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($fos as $v)
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->fos_name}}</td>
                       <td>{{! $p = DB::table('programmes')
                       ->find($v->programme_id)}}
                      {{$p->programme_name}}</td>
                           <td> {{$v->duration}}</td>
                      <td> <div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('edit_fos',$v->id)}}">Edit</a></li>
     <li><a href="{{url('delete_fos',$v->id)}}">Delete</a></li>
    
  </ul>
</div></td>
                       </tr>
                       @endforeach
                        </table>

                        @else
                        <p class="alert alert-warning">No records is avalable</p>
                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      