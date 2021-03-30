@extends('layouts.admin')
@section('title','Generate Result')
@section('content')
@inject('r','App\R')
<?php $result= $r->getrolename(Auth::user()->id); ?>
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
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Generate Result</div>
                        <form class="form-horizontal" role="form"method="GET" action="{{ url('getreport') }}" target="_blank" data-parsley-validate>
                        {{ csrf_field() }}
                        <input type="hidden" name="duration" value="{{$duration}}">
                        <input type="hidden" name="final" value="{{$final}}">
                        @if($result =="admin" || $result =="support")
                        <input type="hidden" name="admin" value="1">
                        <input type="hidden" name="department_id" value="{{$d}}">
          <input type="hidden" name="faculty_id" value="{{$f}}">
                        @endif
                        <input type="hidden" name="session" value="{{$s}}">
                        <input type="hidden" name="level" value="{{$l}}">
          <input type="hidden" name="fos" value="{{$fos}}">
          <input type="hidden" name="selected" value="6">
          <div class="col-md-4 form-group">
                              <label  class=" control-label">Result Type</label>
                              
                              
        <select class="form-control" name="result_type" required>
                                  <option value=""> - - Select - -</option>
    <option value="1">Sessional Result</option>
     <option value="2">Omited Result </option>
    <!-- <option value="3">Probational Result </option>-->
     <option value="4">Correctional Result </option>
     <option value="5">Long Vacation Result </option>
    <!--<option value="7">Mid-Year Summer Result </option>-->
                                 
                              </select>
                              
                            </div>

                            <div class="col-sm-3">
                              <label for="session" class=" control-label">Pagination</label>
                              <select class="form-control" name="page_number" required>
                              <option value=""> - - Select - -</option>
                              <option value="5">5 per page </option>
                              <option value="6">6 per page</option>
                              <option value="8">8 per page</option>
                              <option value="10">10 per page</option>
                              <option value="12"> 12 per page</option>
                              <option value="14"> 14 per page</option>
                              <option value="15"> 15 per page</option>
                              
                              </select>
                             
                            </div>
                            <div class="col-md-4">
                            <?php $faculty =$r->get_facultymetname($f);
                            $fos =$r->get_fos($fos);
                            $department =$r->get_departmetname($d)?>
                            <p><b>Faculty : </b>{{$faculty}}</p>
                            <p><b>Department : </b>{{$department}} </p>
                            <p><b>Field Of Study : </b>{{$fos}}</p>
                            </div>
          
                            <div class="col- md-4">
                            <p>Level : {{$l}} 00</p>
                            <p>Session : {{$s}} / {{$s+1}}</p>
                            </div>
          <table class="table table-bordered table-striped">
                        <tr>
                          <th></th>
                        <th class="text-center">S/N</th>
                        <th class="text-center">matric Number</th>
                        <th class="text-center">Name</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($users as $v)
                       <?php $name = $v->surname.' '.$v->firstname.' '.$v->othername;?>
                       <tr>
                         <td>
                        
                           <input type="checkbox" name="ids[]" value="{{$v->id}}">
                           
                      
                         </td>
                       <td class="text-center">{{++$c}}</td>
                       <td>{{$v->matric_number}}</td>
                       <td>{{$name}}</td>
                       </tr>
                       @endforeach
          </table>
          <div class="col-sm-2">
                                 <br/>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>
          </div> 

                        </form>
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

                      
 