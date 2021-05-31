@extends('layouts.admin')
@section('title','View Registered student')
@section('content')
@inject('r','App\R')
        <!-- Page Heading -->
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
            <div class="panel-heading">Update Result &nbsp;&nbsp;&nbsp; {{$level}}00 LEVEL
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {{$session}} Session 
            </div>
            <div class="panel-body">
                <p><b>Names : </b>{{strtoupper($u->surname." ".$u->firstname." ".$u->othername)}} 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{$u->matric_number}}</p>
                    <p><b>Field Of Study : </b>{{$fosName}}</p>
                    <h4 class='text-danger'><strong>NB</strong> Total grade should not be 0. <span class="text-success">Update will only take effect if the total score differ from the original score.</span> </h4>
                @if($s->count() == 0)
                <h4 class="text-danger text-center">All result have been entered for these candidate for the level and session</h4>

                @else
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('postResult') }}" data-parsley-validate>
                                        {{ csrf_field() }}
                                <div class="modal-content">
                                 
                                    <div class="modal-body">
                                        <div class="col-md-12" style="margin-bottom: 5px;">
                                        
                                        <div class="col-sm-2 text-center" ><b>Code</b></div>
                                        <div class="col-sm-1 text-center" ><b>Status</b></div>
                                        <div class="col-sm-1 text-center" ><b>Unit</b></div>
                                        <div class="col-sm-2 text-center" ><b>Script No</b></div>
                                        <div class="col-sm-2 text-center" ><b>CA</b></div>
                                        <div class="col-sm-2 text-center" ><b>Exams</b></div>
                                        <div class="col-sm-2 text-center" ><b>Total</b></div>
                                         <input type="hidden" name="fos_id" value="{{$u->fos_id}}"/>
                                            <input type="hidden" name="user_id" value="{{$u->id}}"/>
                                            <input type="hidden" name="matric_number" value="{{$u->matric_number}}"/>
                                            <input type="hidden" name="session_id" value="{{$session}}"/>
                                            <input type="hidden" name="level_id" value="{{$level}}"/>
                                            <input type="hidden" name="season" value="{{$season}}"/>
                                              <input type="hidden" name="entry_year" value="{{$u->entry_year}}"/>
                                            
                                        @foreach($s as $k => $item)
                                        
                                       
                                        <div class="col-sm-12 " >
                                            
                                        
                                        @if($k == 1)
                                        <h4><strong>FIRST SEMESTER</strong></h4>
                                        <hr/>
                                        <input type="hidden" name="Firstsemeter" value="{{$k}}">
                                        @elseif($k== 2)
                                        <input type="hidden" name="Secondsemeter" value="{{$k}}">
                                        <hr/>
                                       <h4><strong>SECOND SEMESTER</strong></h4> 
                                       <hr/>
                                        @endif 
                                    </div>
                                        
                                        @foreach($item as  $v)
                                        <input type="hidden" name="semester_id[{{$v->id}}]" value="{{$v->semester_id}}">
                                            <div class="col-sm-12" style="margin-bottom: 9px;">
                                           
                                            <div class="col-sm-2 text-center text-success" ><b>{{$v->course_code}}</b> </div>
                                            <div class="col-sm-1 text-center text-info" ><b>{{$v->course_status}}</b></div>
                                            <div class="col-sm-1 text-center text-info" ><b>{{$v->course_unit}}</b></div>
                                          
                                           
                                              <div class="col-sm-2 text-center text-danger">
 <input type="text" class="form-control"  name="scriptNo[{{$v->r}}]"  value="{{$v->scriptNo}} " />
</div>
<div class="col-sm-2 text-center text-danger">
    <input type="text" class="form-control"  name="ca[{{$v->r}}]" onKeyUp="CA(this,'exam{{$v->r}}', 'd{{$v->r}}')"  value="{{$v->ca}}" id="ca{{$v->r}}"/>
   </div>
  <div class="col-sm-2 text-center text-danger">
  <input type="text"  class="form-control"  name="exam[{{$v->r}}]"  onKeyUp="updA(this,'ca{{$v->r}}','d{{$v->r}}')" value="{{$v->exam}} " id="exam{{$v->r}}" />

  </div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="total[{{$v->r.'~'.$v->id.'~'.$v->course_id.'~'.$v->course_unit}}]" value="{{$v->total}}" id="d{{$v->r}}" readonly />
</div>
                                           

                                               

                                                
                                                </div>
                                                <div class="clearfix"></div>

                                                @endforeach
                                            @endforeach



                                    </div>
                                    <div class="modal-footer">
                                            
                                        <button type="submit" class="btn btn-warning">Update Result</button>
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

@section('script')

  <script >


      function updA(e,c,d){
var c=document.getElementById(c);
var t=document.getElementById(d);

 if(e.value > 70){alert('Exam scores can not be more than 70');e.value='';

var ca =c.value;
var ex =e.value;
var total =Number(ca) + Number(ex);
  t.value = total;}
else{
 
if(e.value < 71){
var ca =c.value;
var ex =e.value;
var total =Number(ca) + Number(ex);
if(total >100)
{
  alert('Total scores can not be more than 100');total='';e.value='';
}

  t.value = total;
}
  
}

}


 function CA(c,e,d)
 {

  var e=document.getElementById(e); 
  var t=document.getElementById(d); 
  
  if(c.value > 40)
    {alert('CA scores can not be more than 40');
  c.value='';
e.value='';

t.value = '';

}
else{
 
if(c.value < 41){
var ca =c.value;
var ex =e.value;
var total =Number(ca) + Number(ex);
if(total >100)
{
  alert('Total scores can not be more than 100');total='';c.value='';e.value='';
}

  t.value = total;
  }
}
}

  </script>

@endsection
               
              