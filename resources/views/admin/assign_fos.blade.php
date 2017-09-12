@extends('layouts.admin')
@section('title','Assign Fos')
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

    <div class="row" style="min-height: 520px;">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">Assign Fos</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/assign_fos') }}" data-parsley-validate>
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
                                    <i class="fa fa-btn fa-user"></i> View
                                </button>
                            </div>

                        </div>

                        </form>

                        @if(isset($fos))
                        @if(count($fos) > 0)
                          <form class="form-horizontal" role="form" method="POST" action="{{ url('/assign_fosdesk') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <table class="table table-bordered table-striped">
                        <tr>
                     
                        <th>Fos</th>
                        <th>Desk Officer</th>
                       
                       </tr>
                       <tr>
                       <td>
                    
                       @foreach($fos as $v)
                     
                       <input type="checkbox" name="fos[]" value="{{$v->id}}"> &nbsp; {{$v->fos_name}} <br/>
                       @endforeach

                       </select>
                       </td>

                       <td>
                        @if(isset($u))
                        @if(count($u) > 0)
                           @foreach($u as $vv)
                          <input type="radio" name="deskofficer" value="{{$vv->id}}">&nbsp; {{$vv->name .'&nbsp;(&nbsp;'.$vv->username.'&nbsp;)&nbsp;'}}<br>
                     
                       
                       @endforeach
                       @else
                        <p class="alert alert-warning">No records is avalable</p>
                        @endif
                        @endif
                       </td>
                       </tr>
                      <tr>
                       <td colspan="2">
                       
                       <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-user"></i> Enter
                                </button>
                                </td>
                       
                     </tr>

                        </table>
                        </form>

                        @else
                        <p class="alert alert-warning">No records is avalable</p>
                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      