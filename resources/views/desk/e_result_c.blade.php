@extends('layouts.admin')
@section('title','Enter Result')
@section('content')
 <!-- Page Heading -->
 <style type="text/css">
 .fc {padding:0px;text-align: center;font-weight: bolder;font-size: 14px;}
 .table>tbody>tr>td{padding:4px;}
 .cc {width:6%;}
        </style>
                <div class="row">
                @inject('r','App\R')
                <?php $fos= $r->get_fos($c->fos_id) ?>
                    <div class="col-lg-12">
                       
                        <ol class="breadcrumb">
                            <li class="active" style="font-weight: bolder;">
                            @if(Auth::user()->faculty_id == $med)
                            Course  : {{$c->reg_course_title}}
                            @else
                               Course Code : {{$c->reg_course_code}}
                               &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                               Course Unit : {{$c->reg_course_unit}}
                               &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                               @endif
                               <?php $next = $c->session + 1;?>
                             Session: {{$c->session.' / '.$next}}
                              &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                              Level: {{$c->level_id}}00
                                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                Field Of Study :{{$fos}}
                            </li>
                        </ol>
                    </div>
                </div>
                  <div class="row" style="min-height: 520px;">
       
            <div class="panel panel-default">
                <div class="panel-heading">Enter Result 
                  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                  <span class="text-center text-success"><strong>Result Type :</strong>&nbsp;{{$rt}}</span></div>
                <div class="panel-body">
             
                 @if(count($u) > 0)
                   
                      <form class="form-horizontal" role="form" method="POST" action="{{ url('/insert_result') }}" data-parsley-validate>
                   
                        {{ csrf_field() }}
                        @if($rt =='Correctional')
                        <input type="text" class='form-control' name="reason" value="" placeholder="Enter Reason for correction" required>
                        <br/>
                        @endif
                        <input type="hidden" name="flag" value="{{$rt}}">
                 <table class="table table-bordered table-striped">
                 <tr>
                        <th width="3%" class="text-center"></th>
                        <th width="3%" class="text-center">S/N</th>
                        <th class="text-center">MATRIC NUMBERS</th>
                        <th class="text-center">NAMES</th>
                    
                        <th class="cc text-center">CA</th> 
                        <th class="cc text-center">EXAMS</th>
                        <th class="cc text-center">TOTAL</th>
                      
                          </tr>
                            {{!!$c = 0}}
                      @foreach($u as $v)
                      {{!$c = ++$c}}
                    

                      <tr>
                      <td>
                      <input type="checkbox" class="checkbox" name="id[{{$c}}]" id="check[{{$c}}]" value="{{$c}}">
                      <input type="hidden" name="coursereg_id[{{$c}}]" value="{{$v->id}}">
                      <input type="hidden" name="user_id[{{$c}}]" value="{{$v->user_id}}">
                       <input type="hidden" name="matric_number[{{$c}}]" value="{{$v->matric_number}}">
                        <input type="hidden" name="course_id[{{$c}}]" value="{{$v->course_id}}">
                      <input type="hidden" name="cu[{{$c}}]" value="{{$v->course_unit}}">
                       <input type="hidden" name="session[{{$c}}]" value="{{$v->session}}">
                        <input type="hidden" name="semester[{{$c}}]" value="{{$v->semester_id}}">
                      <input type="hidden" name="level_id[{{$c}}]" value="{{$v->level_id}}">
                       <input type="hidden" name="season[{{$c}}]" value="{{$v->period}}">
                       <input type="hidden" name="entry_year[{{$c}}]" value="{{$v->entry_year}}">

                      </td>
                      <td>{{$c}}</td>
                       <td>{{$v->matric_number}}</td>
                        <td>{{strtoupper($v->surname." ".$v->firstname." ".$v->othername)}}</td>
                        
                        
                     
                     <?php 
                     if($rt == 'Correctional')
                     {
$result =DB::connection('mysql2')->table('student_results')
->where([['coursereg_id',$v->id],['approved',1]])->first();

                     }else{
$result =DB::connection('mysql2')->table('student_results')->where('coursereg_id',$v->id)->first();
                     }
                     
                     ?>

                         @if($result != null)
   
<!-- ===========================check if it has edit right ================================-->
   {{-- @if(Auth::user()->edit_right > 0) --}}
     <input type="hidden" class="form-control fc" name="result_id[{{$c}}]" value="{{$result->id}}" >
  <td>
  <input type="" class="form-control fc " name="ca[{{$c}}]" id='ca{{$c}}'  onKeyUp="CA(this,'exam{{$c}}','d{{$c}}','check[{{$c}}]')" value="{{$result->ca}}" />
  </td>
  <td>
  <input type="" class="form-control fc " name="exams[{{$c}}]" id='exam{{$c}}'   onKeyUp="updA(this,'ca{{$c}}','d{{$c}}','check[{{$c}}]')" value="{{$result->exam}}" />
  </td>
  <td>
  <input type="" class="form-control fc " name="total[{{$c}}]"  value="{{$result->total}}" id='d{{$c}}' readonly='true' onChange="if (this.value!='') document.getElementById('check[{{$c}}]').checked=true"  />
   </td>
  {{-- @else
   <input type="hidden" class="form-control fc" name="result_id[{{$c}}]" value="" >
  <td>

  <input type="" class="form-control fc " name="ca[{{$c}}]" id='ca{{$c}}'  onKeyUp="CA(this,'exam{{$c}}','d{{$c}}','check[{{$c}}]')" value="{{$result->ca}}" readonly />
 </td>
  <td>
  <input type="" class="form-control fc " name="exams[{{$c}}]" id='exam{{$c}}'   onKeyUp="updA(this,'ca{{$c}}','d{{$c}}','check[{{$c}}]')" value="{{$result->exam}}" readonly />
  </td>
  <td>
  <input type="" class="form-control fc " name="total[{{$c}}]"  value="{{$result->total}}" id='d{{$c}}' readonly='true' onChange="if (this.value!='') document.getElementById('check[{{$c}}]').checked=true"  />
  </td>
   @endif--}}
 @else
 
 <input type="hidden" class="form-control fc" name="result_id[{{$c}}]" value="" >
   <td>
  <input type="" class="form-control fc " name="ca[{{$c}}]" id='ca{{$c}}'  onKeyUp="CA(this,'exam{{$c}}','d{{$c}}','check[{{$c}}]')" value="" />
  </td>
  <td>
 <input type="" class="form-control fc " name="exams[{{$c}}]" id='exam{{$c}}'   onKeyUp="updA(this,'ca{{$c}}','d{{$c}}','check[{{$c}}]')" value="" />
 </td>
 <td>
<input type="" class="form-control fc " name="total[{{$c}}]"  value="" id='d{{$c}}' readonly='true' onChange="if (this.value!='') document.getElementById('check[{{$c}}]').checked=true"  />
</td>

@endif
</tr>

@endforeach

<tr>
<td colspan="4"></td>
<td colspan="3" style="padding-top: 18px;padding-bottom:10px;">
<input type="hidden" name="url" value="{{$url}}">
<button type="submit" class="btn btn-danger btn-block ">
<i class="fa fa-btn fa-user"></i> Submit Result</button>
</td>
</tr>
</table>                            
</form>
{{$u->setPath($url)->render()}}
 @else
<p class="alert alert-warning">No Students  is avalable</p>
 @endif
 </div>
</div>
</div>
</div>
  @endsection 

  @section('script')

  <script >


      function updA(e,c,d,h){
var c=document.getElementById(c);
var t=document.getElementById(d);
var chk=document.getElementById(h);
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
if(t.value!=''){
  chk.checked=true;
}else{
  chk.checked=false;
}
}


 function CA(c,e,d,h)
 {

  var e=document.getElementById(e); 
  var t=document.getElementById(d); 
  var chk=document.getElementById(h);
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
if(t.value!=''){chk.checked=true;}else{chk.checked=false;}}

  </script>

<!--https://mediacity.co.in/quickquiz/public/admin

  https://www.laravel-vuejs.com/quick-quiz-laravel-quiz-and-exam-system/
-->
@endsection              