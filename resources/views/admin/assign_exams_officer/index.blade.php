@extends('layouts.admin')
@section('title','Assign Examsofficer Role')
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
        <div class="col-sm-12" style="min-height: 520px;">
            <div class="panel panel-default">
                <div class="panel-heading">Assign  Examsofficer Role <a href="{{url('view_assign_exams_officer')}}" class="btn btn-danger pull-right">View Exams Officer</a></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('get_lecturer_4_exams_officer') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                      
                      

                            <div class="col-md-4">
                                <label for="faculty_id" class="control-label">Select Faculty</label>
                                 <select class="form-control" name="faculty_id" id="faculty_id" required>
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
                                 <select class="form-control" name="department_id" id="department_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>

                        

                     
                            <div class="col-md-3">
                            <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        <div class="col-sm-12">
                                @if(isset($dname))
                                <h4><b>Department :: </b>{{$dname->department_name}} </h4>
                                @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('assign_exams_officer') }}" data-parsley-validate>
                                {{ csrf_field() }}
                        <div class="col-sm-7"> 
                           @if(isset($u))
                        @if(count($u) > 0)
                        
                        <table class="table table-bordered table-striped">
                        <tr>
                          <td>Select</td>
                        <th>S/N</th>
                        <th>Name</th>
                         <th>Username</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($u as $v)
                       <tr>
                        <td><label><input type="radio" name="optradio" value="{{$v->id.'~'.$v->department_id}}"></label></td>
                       <td>{{++$c}}</td>
                        
                       <td>{{$v->name}}</td>
                       <td>{{$v->username}}</td>
                     </tr>
                       @endforeach
                    
                        </table>
                      
 

                        @endif
                        @endif

                        </div>
                        <div class="col-sm-5">
                                @if(isset($fos))
                                @if(count($fos) > 0)
                                @foreach($fos as $v)
                     
                                <input type="checkbox" name="fos[]" value="{{$v->id}}"> &nbsp; {{$v->fos_name}} <br/>
                                @endforeach
                                <br/>
                                <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="btn btn-success btn-block" name="hod" value="Assign Exams Officer">
                        </div>
                                @endif
                                @endif
                          
                    </div>
                    </form>
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
                   