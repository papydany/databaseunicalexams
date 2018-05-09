@extends('layouts.admin')
@section('title','Register Students')
@section('content')
<style type="text/css">
  .fc { width: 80%;margin: auto;height: 30px;}
</style>
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
                <div class="panel-heading">View Student</div>
                <div class="panel-body">
               


                         @if(isset($u))

                        @if(count($u) > 0)
                         <h4>@if($s == 1)
            First Semester
               @elseif($s== 2)
Second Semester
               @endif
               &nbsp; &nbsp; &nbsp;&nbsp; Session {{$ss}} &nbsp; &nbsp; &nbsp;&nbsp;
               @if($role == 1)
    {{strtoupper($cn->course_title)}}
               @elseif($role == 2)
{{strtoupper($cn->title)}}
               @endif

               
               </h4>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/pds_enter_result1') }}" data-parsley-validate>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="semester" value="{{$s}}">
                                        <input type="hidden" name="session" value="{{$ss}}">
                                        <input type="hidden" name="course" value="{{$course}}">
                                        <input type="hidden" name="url" value="{{$url}}">   
                        <table class="table table-bordered table-striped">
                        <tr><th></th>
                        <th>S/N</th>
                        <th>Surname</th>
                        <th>Firstname</th>
                        <th>Othername</th>
                        <th>Matric Number</th>
                        <th width='8%'>CA</th>
                       <th width='8%'>Exams</th>
                        <th width='8%'>Total</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($u as $v)
                       {{!++$c}}

                         @inject('r','App\R')
                         <?php $result= $r->pds_getresult($v->id,$v->matric_number,$course,$s,$ss) ?>
                         @if(count($result) > 0)

 <tr>
                       <td><input type="checkbox"  name="check[{{$c}}]" id="check[{{$c}}]" value="{{$c}}" \> </td>
                       <td>{{$c}}</td>
                       <td>{{strtoupper($v->surname)}}</td>
                        <td>{{strtoupper($v->firstname)}}</td>
                         <td>{{strtoupper($v->othername)}}</td>
                       <td>{{$v->matric_number}}
                       <input type='hidden' name='pdg_user[{{$c}}]' value="{{$v->id}}">
                       <input type='hidden' name='matric_number[{{$c}}]' value="{{$v->matric_number}}">
                       </td>
                       <td>
                       <input type="" class="form-control fc " name="ca[{{$c}}]" id='ca{{$c}}'  onKeyUp="CA(this,'exam{{$c}}','d{{$c}}','check[{{$c}}]')" value="{{$result->ca}}" />
                       </td>
                      
                       <td>
                       <input type="" class="form-control fc " name="exams[{{$c}}]" id='exam{{$c}}'   onKeyUp="updA(this,'ca{{$c}}','d{{$c}}','check[{{$c}}]')" value="{{$result->exam}}" />
                       </td>
                         <td>
                         <input type="" class="form-control fc " name="total[{{$c}}]"  value="{{$result->total}}" id='d{{$c}}' readonly='true' onChange="if (this.value!='') document.getElementById('check[{{$c}}]').checked=true"  />
                         </td>
                       </tr>


                         @else

 <tr>
                       <td><input type="checkbox"  name="check[{{$c}}]" id="check[{{$c}}]" value="{{$c}}" \> </td>
                       <td>{{$c}}</td>
                       <td>{{strtoupper($v->surname)}}</td>
                        <td>{{strtoupper($v->firstname)}}</td>
                         <td>{{strtoupper($v->othername)}}</td>
                       <td>{{$v->matric_number}}
                       <input type='hidden' name='pdg_user[{{$c}}]' value="{{$v->id}}">
                       <input type='hidden' name='matric_number[{{$c}}]' value="{{$v->matric_number}}">
                       </td>
                       <td>
                       <input type="" class="form-control fc " name="ca[{{$c}}]" id='ca{{$c}}'  onKeyUp="CA(this,'exam{{$c}}','d{{$c}}','check[{{$c}}]')" value="" />
                       </td>
                      
                       <td>
                       <input type="" class="form-control fc " name="exams[{{$c}}]" id='exam{{$c}}'   onKeyUp="updA(this,'ca{{$c}}','d{{$c}}','check[{{$c}}]')" value="" />
                       </td>
                         <td>
                         <input type="" class="form-control fc " name="total[{{$c}}]"  value="" id='d{{$c}}' readonly='true' onChange="if (this.value!='') document.getElementById('check[{{$c}}]').checked=true"  />
                         </td>
                       </tr>
                         @endif

                      
                       @endforeach
                        </table>
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </form>
{{$u->setPath($url)->render()}}
                        @else
 <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
    No Records!!!
    </div>

                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

@endsection

     <script type="text/javascript">
      function updA(e,c,d,h){if(e.value > 70){alert('Exam scores can not be more than 70');e.value='';}
else{var c=document.getElementById(c); var t=document.getElementById(d); var chk=document.getElementById(h);
 
if(e.value < 71){
var ca =c.value;
var ex =e.value;
var total =Number(ca) + Number(ex);
  t.value = total;
  
}
if(t.value!=''){chk.checked=true;}else{chk.checked=false;}}}


 function CA(e,c,d,h){if(e.value > 30){alert('CA scores can not be more than 30');e.value='';}
else{var c=document.getElementById(c); var t=document.getElementById(d); var chk=document.getElementById(h);
 
if(e.value < 31){
var ca =c.value;
var ex =e.value;
var total =Number(ca) + Number(ex);
  t.value = total;
  
}
if(t.value!=''){chk.checked=true;}else{chk.checked=false;}}}




       </script>