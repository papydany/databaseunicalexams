@extends('layouts.admin')
@section('title','Transfer Officer')
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
        <div class="col-sm-12" style="min-height: 420px;">
            <div class="panel panel-default">
                <div class="panel-heading">Transfer Officer</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('transfer_officer') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                     

                            <div class="col-md-4">
                                <label for="faculty_id" class="control-label">Select Faculty</label>
                                 <select class="form-control" name="fac_id" id="fac_id" required>
                               <option value="">Select</option>
                               @if(count($f) > 0)
                               @foreach($f as $v)
                        <option value="{{$v->id}}">{{$v->faculty_name}}</option>
                                @endforeach
                                @endif
                             </select>

                                @if ($errors->has('faculty_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="col-md-4">
                                <label for="department_id" class="control-label">Select Department</label>
                                 <select class="form-control" name="dept_id" id="dept_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>

                               <div class="col-md-4">
                                <label for="department_id" class="control-label">Select DeskOfficer</label>
                                 <select class="form-control" name="officer_id" id="officer_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>
</div>
             <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                     

                            <div class="col-md-4">
                                <label for="faculty_id" class="control-label">Moved To Faculty</label>
                                 <select class="form-control" name="m_fac_id" id="m_fac_id" required>
                               <option value="">Select</option>
                               @if(count($f) > 0)
                               @foreach($f as $v)
                        <option value="{{$v->id}}">{{$v->faculty_name}}</option>
                                @endforeach
                                @endif
                             </select>

                                @if ($errors->has('faculty_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="col-md-4">
                                <label for="department_id" class="control-label">Moved To Department</label>
                                 <select class="form-control" name="m_dept_id" id="m_dept_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>

                               <div class="col-md-4">
                                <label for="department_id" class="control-label">Select Programme</label>
                                   <select class="form-control" name="programme_id"  required>
                               <option value="">Select</option>
                               @if(count($p) > 0)
                               @foreach($p as $v)
                        <option value="{{$v->id}}">{{$v->programme_name}}</option>
                                @endforeach
                                @endif
                             </select>
                            </div>
</div>           

                            

                            <div class="col-md-3">
                            <br/>
                                <button type="submit" class="btn btn-success btn-l">
                                    <i class="fa fa-btn fa-user"></i> MOVED
                                </button>
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
                   