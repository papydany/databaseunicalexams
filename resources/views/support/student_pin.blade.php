@extends('layouts.admin')
@section('title','Student Pin')
@section('content')
@inject('R','App\R')
<?php $result= $R->getrolename(Auth::user()->id) ?>
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
<div class="panel-heading">Students</div>
<div class="panel-body">
<form class="form-horizontal" role="form" method="GET" action="{{ url('/get_student_pin') }}" data-parsley-validate>
{{ csrf_field() }}
<div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
<div class="col-sm-2">
<label for="session" class=" control-label">Session</label>
<select class="form-control" name="session" required>
      <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                              <!--<div class="col-sm-2">
                              <label for="session" class=" control-label">Level</label>
                              <select class="form-control" name="level" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($l=1; $l <= 7; $l++)
                                
                                  <option value="{{$l}}">{{$l}}00</option>
                                  @endfor
                                
                              </select>
                             
                            </div>-->

                            @if($result =="support" || $result =="admin")
                              <div class="col-sm-3">
                              <label for="session" class="control-label">Department</label>
                              <select class="form-control" name="department" id="department_id" required>
                              <option value=""> - - Select - -</option>
                               
                                  @foreach ($d as $v)
                                 
                                  <option value="{{$v->id}}">{{$v->department_name}}</option>
                                  @endforeach
                                
                              </select>
                             
                            </div>
                            <div class="col-sm-3">
                              <label for="fos" class="control-label">Field Of Study</label>
                              <select class="form-control" name="fos" id="fos_id" required>
                            
                                
                              </select>
                             
                            </div>
                            @else
                              <div class="col-sm-3">
                                <input type="hidden" name="department" value="{{$ud->department_id}}">
                            <label for="fos" class=" control-label">Field Of Study</label>
                            <select class="form-control" name="fos" required>
                                <option value=""> - - Select - -</option>

                                @foreach($f as $v)
                                    <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                @endforeach

                            </select>

                        </div>

                            @endif

                            <div class="col-sm-4">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" required>
                              <option value=""> - - Select - -</option>
                               
                                 
                                  <option value="1">100</option>
                                  <option value="2">200</option>
                                  <option value="3">300</option>
                                  <option value="4">400</option>
                                  <option value="5">500</option>
                                  <option value="6">600</option>
                                  <option value="7">700</option>
                                  <option value="8">800</option>
                                
                              </select>
                             
                            </div>


                      
                          
                            

                            <div class="col-md-2">
                            <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>

                        </div>

                        </form>
                        </div>
                        </div>
                        </div>
                        </div>
  
          <div class="col-sm-12">
@if(isset($u))
                        @if(count($u) > 0)
       <?php  $department = $R->get_departmetname($di);
 
        $fos =$R->get_fos($fos);    


     ?>
     <table  class="table table-bordered">
<tr><td>

      <p class="text-center" style="font-size:14px; font-weight:700;">Students</p>
    <div class="col-sm-6 www">
   <p>DEPARTMENT: {{$department}} ( {{$fos}})</p>
     </div>
     <div class="col-sm-2 www">
   <p>Level : {{$level}}00</p>
     </div>
  <div class="col-sm-4 ww">
   {{!$next = $g_s + 1}}
      <p>  <strong>Session : </strong>{{$g_s.' / '.$next}}</p>
    </div>

    </td></tr>
 
  
  
</table>
   
<table class="table table-bordered table-striped">
<tr>
<th>S/N</th>
<th>Matric Number</th>
<th>Names</th>
<th>serial - Pin</th>

</tr>
{{!!$c = 0}}
@foreach($u as $v)
<?php  //$depart = $R->get_departmetname($v->department_id); 
$pin = $R->get_pin_year($v->id,$v->matric_number,$g_s);?>
<tr>
                      
                       <td>{{++$c}}</td>
                       <td>{{$v->matric_number}}</td>
                       <td>{{$v->surname .' '.$v->firstname.' '.$v->othername}}</td>
                       <td>@foreach($pin as $vs)
                  <p>  {{$vs->id."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$vs->pin}}</p>
                   
                  

                @endforeach</td>
                   
                       

                       
                       </tr>
                       @endforeach
                     
                        </table>
                      </form>

                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                        @endif
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