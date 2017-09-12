@extends('layouts.admin')
@section('title','Create Course Unit')
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
                <div class="panel-heading">Create Course Unit <a href="create_course_unit_special" class="btn btn-danger pull-right">
                                    <i class="fa fa-btn fa-user"></i> Add Special Course Unit
                                </a></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/create_course_unit') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                        
                               <div class="col-sm-3">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                       <div class="col-sm-3">
                                <label for="min" class="control-label">minimum Unit</label>
                                <input type="text" name="min" class="form-control" required>

                                @if ($errors->has('min'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('min') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <label for="max" class="control-label">maximum Unit</label>
                                <input type="text" name="max" class="form-control" required>

                                @if ($errors->has('max'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('max') }}</strong>
                                    </span>
                                @endif
                            </div>

                            

                            <div class="col-md-3">
                            <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Create
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>
@endsection  
@section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection

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