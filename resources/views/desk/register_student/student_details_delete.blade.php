@extends('layouts.admin')
@section('title','View Registered student')
@section('content')
@inject('r','App\R')
        <!-- Page Heading -->
        <style>
hr{margin-top: 10px !important;
margin-bottom: 10px !important;
border-top: 1px solid #000; !important;
} 

.hr1{margin-top: 10px !important;
margin-bottom: 10px !important;
border-top: 1px solid #000; !important;
} 
        </style>
<?php 
 use Illuminate\Support\Facades\Auth;
$result= $r->getrolename(Auth::user()->id);
$fosName =$r->get_fos($u->fos_id) ?>
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
            <div class="panel-heading">Delete Result
            </div>
            <div class="panel-body">
                <p><b>Names : </b>{{strtoupper($u->surname." ".$u->firstname." ".$u->othername)}} 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{$u->matric_number}}</p>
                    <p><b>Field Of Study : </b>{{$fosName}}</p>
                   
                @if($s->count() == 0)
                <h4 class="text-danger text-center">no records</h4>

                @else
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('postResult') }}" data-parsley-validate>
                                        {{ csrf_field() }}
                                <div class="modal-content">
                                 
                                    <div class="modal-body">
                                        <div class="col-md-12" style="margin-bottom: 5px;">
                                        
                                         <input type="hidden" name="fos_id" value="{{$u->fos_id}}"/>
                                            <input type="hidden" name="user_id" value="{{$u->id}}"/>
                                            <input type="hidden" name="matric_number" value="{{$u->matric_number}}"/>
                                            <input type="hidden" name="session_id" value="{{$session}}"/>
                                            <input type="hidden" name="level_id" value="{{$level}}"/>
                                            <input type="hidden" name="season" value="{{$season}}"/>
                                              <input type="hidden" name="entry_year" value="{{$u->entry_year}}"/>
                                            
                                        @foreach($s as $k => $item1)
                                        
                                       <?php $collection =$item1->groupBy('semester_id')->toArray(); ?>
                                        <div class="col-sm-12 " >
                                            
                                        <h3><strong>Session : {{$k}}</strong></h3>
                                        <hr/>
                                       
                                    </div>
                                    @foreach ($collection as $kk => $item)
                                        
                                    <div class="col-sm-12 " >
                                            
                                        
                                        @if($kk == 1)
                                        <h4><strong>FIRST SEMESTER</strong></h4>
                                        
                                        <div class="col-sm-1 text-center" ><b>Select</b></div>
                                        <div class="col-sm-2 text-center" ><b>Code</b></div>
                                        <div class="col-sm-1 text-center" ><b>Level</b></div>
                                        <div class="col-sm-1 text-center" ><b>Status</b></div>
                                        <div class="col-sm-1 text-center" ><b>Unit</b></div>
                                        
                                        <div class="col-sm-1 text-center" ><b>CA</b></div>
                                        <div class="col-sm-1 text-center" ><b>Exams</b></div>
                                        <div class="col-sm-2 text-center" ><b>Total</b></div>
                                        <div class="clearfix"></div>
                                    <hr/>
                                       
                                        @elseif($kk== 2)
                                       
                                        <hr class="hr1"/>
                                       <h4><strong>SECOND SEMESTER</strong></h4> 
                                       <div class="col-sm-1 text-center" ><b>Select</b></div>
                                        <div class="col-sm-2 text-center" ><b>Code</b></div>
                                        <div class="col-sm-1 text-center" ><b>Level</b></div>
                                        <div class="col-sm-1 text-center" ><b>Status</b></div>
                                        <div class="col-sm-1 text-center" ><b>Unit</b></div>
                                        
                                        <div class="col-sm-1 text-center" ><b>CA</b></div>
                                        <div class="col-sm-1 text-center" ><b>Exams</b></div>
                                        <div class="col-sm-2 text-center" ><b>Total</b></div>
                                        <div class="clearfix"></div>
                                        <hr/>
                                       
                                        @endif 
                                    </div>
                                        
                                        @foreach($item as  $v)
                                        {{! $result =DB::connection('mysql2')->table('student_results')
                         ->where('coursereg_id',$v->id)
                         ->get()
                         }}
                                        
                                            <div class="col-sm-12" style="margin-bottom: 9px;">
                                            <div class="col-sm-1" > <input type="checkbox" name="chk[]" value="{{$v->id}}"/></div>
                                            <div class="col-sm-2 text-center text-success" ><b>{{$v->course_code}}</b> </div>
                                            <div class="col-sm-1 text-center text-success" ><b>{{$v->level_id}}</b> </div>
                                            <div class="col-sm-1 text-center text-info" ><b>{{$v->course_status}}</b></div>
                                            <div class="col-sm-1 text-center text-info" ><b>{{$v->course_unit}}</b></div>
                                          
                                            @if(count($result) > 0)
                                            @foreach($result as $rv)
                                              <div class="col-sm-1 text-center text-danger">
{{$rv->ca}}
</div>
  <div class="col-sm-1 text-center text-danger">
{{$rv->exam}}
</div>
  <div class="col-sm-2 text-center text-danger">
 {{$rv->total}}
</div>
<div class="clearfix"></div>
<hr/>
                                            @endforeach
                                            @else
 
<div class="col-sm-1 text-center text-danger">
-
   </div>
  <div class="col-sm-1 text-center text-danger">
 -
  </div>
  <div class="col-sm-2 text-center text-danger">
      -
</div>
<div class="clearfix"></div>
<hr/>
@endif        

                                               

                                                
                                                </div>
                                                <div class="clearfix"></div>

                                                @endforeach
                                            @endforeach
                                            @endforeach



                                    </div>
                                    <div class="modal-footer">
                                            
                                        <button type="submit" name="delete"  value="delete" class="btn btn-danger">delete Result</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
                                    
                                </div>
                                </div>
                                </form>
                                @endif
                            </div>
                            </div>
                        </div>
                      

    </div>
</div>
@endsection 


              