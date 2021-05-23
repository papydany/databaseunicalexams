@extends('layouts.admin')
@section('title','View Fos')
@section('content')
@inject('R','App\R')
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
                <div class="panel-heading">View Specialization</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/viewSpecialization') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                     
                      

                            <div class="col-md-3">
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

                             <div class="col-md-3">
                                <label for="department_id" class="control-label">Select Department</label>
                                 <select class="form-control" name="department_id" id="department_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>

                            <div class="col-md-3">
                                <label for="department_id" class="control-label">Select FOS</label>
                                 <select class="form-control" name="fos_id" id="fos_id" required>
                               <option value="">Select</option>
                               </select>
                            </div>
                           <div class="col-md-2">
                                      <br/>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> View
                                </button>
                            </div>

                        </div>

                        </form>

                        @if(isset($s))
                        <?php $faculty =$R->get_facultymetname($ff); 
                        $department =$R->get_departmetname($d);
                        $fos =$R->get_fos($fos); ?>
                        <div class="col-md-4"><b>Faculty : </b>{{$faculty}}</div>
                        <div class="col-md-4"><b>Department :</b>{{$department}}</div>
                       
                        <div class="col-md-4"><b>Fos :</b>{{$fos}}</div>
                        @if(count($s) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Specialization</th>
                        
                        <th>Level</th>
                        <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($s as $v)
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->name}}</td>
                   
                           <td> {{$v->level}}</td>
                      <td> <div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('editSpecialization',$v->id)}}">Edit</a></li>
     <li><a href="#">Delete</a></li>
    
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