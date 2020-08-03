@extends('layouts.admin')
@section('title','Edit Course Unit')
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
                <div class="panel-heading">Edit Course Unit</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('update_course_unit') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                        
                          
                       <div class="col-sm-3">
                        <input type="hidden" name="id"  value="{{$c->id}}">
                                <label for="min" class="control-label">minimum Unit</label>
                                <input type="text" name="min" class="form-control" value="{{$c->min}}" required>

                                @if ($errors->has('min'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('min') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <label for="max" class="control-label">maximum Unit</label>
                                <input type="text" name="max" class="form-control" value="{{$c->max}}" required>

                                @if ($errors->has('max'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('max') }}</strong>
                                    </span>
                                @endif
                            </div>

                            

                            <div class="col-md-3">
                            <br/>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-btn fa-user"></i> Update
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

                     