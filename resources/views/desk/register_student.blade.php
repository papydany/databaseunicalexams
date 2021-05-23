@extends('layouts.admin')
@section('title','View Registered student')
@section('content')
@inject('r','App\R')
        <!-- Page Heading -->
<?php $result= $r->getrolename(Auth::user()->id);

$role =$r->getroleId(Auth::user()->id); 

$acct =$r->getResultActivation($role); ?>
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
            <div class="panel-heading">View Registered Student</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="GET" action="{{ url('post_register_student') }}" data-parsley-validate >
                    {{ csrf_field() }}
                    <div class="form-group">



                        <div class="col-sm-3 col-md-2">
                            <label for="fos" class=" control-label">Field Of Study</label>
                            <select class="form-control" name="fos_id" required>
                                <option value=""> - - Select - -</option>

                                @foreach($f as $v)
                                    <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-sm-3 col-md-2">
                            <label for="session" class=" control-label">Session</label>
                            <select class="form-control" name="session_id" required>
                                <option value=""> - - Select - -</option>

                                @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                   @if($acct != null)
                                   @if($acct == $year )
                                   <option value="">Session Deactivated</option>
                                   
                                   @else
                                   <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                   @endif

                                   @else
                                   <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                   @endif
                                  
                                  @endfor

                            </select>

                        </div>
                        @if($result =="examsofficer")
                       
                        <div class="col-sm-3 col-md-2">
                                <label for="semester" class=" control-label">Semester</label>
                                <select class="form-control" name="semester_id">
                                    <option value=""> - - Select - -</option>
                                    <option value="1">First Semester</option>
                                    <option value="2">Second Semester</option> 
                                </select>
    
                            </div>
                            <div class="col-sm-3 col-md-2">
                                <label for="level" class=" control-label">Level</label>
                                <select class="form-control" name="level">
                                    <option value=""> - - Select - -</option>
                            <option value="1">100</option>
                            <option value="2">200</option>
                            <option value="3">300</option>
                            <option value="4">400</option>
                            <option value="5">500</option>
                            <option value="6">600</option>
                            <option value="7">700</option>
                           
                                       
                                </select>
    
                            </div>
                        
                            @else
                            @if(Auth::user()->faculty_id == $med)
                        <div class="col-sm-3">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level">
                               <option value=""> - - Select - -</option>
                               <option value="1">100</option>
                            <option value="2">200</option>
                            <option value="3">Part I</option>
                            <option value="4">Part II</option>
                            <option value="5">Part III</option>
                            <option value="6">Part IV</option>
                          
                                
                              </select>
                             
                            </div>
                             <div class="col-sm-3 col-md-2">
                                <label for="semester" class=" control-label">Semester</label>
                                <select class="form-control" name="semester_id">
                                    <option value=""> - - Select - -</option>
                                    <option value="1">First Semester</option>
                                    <option value="2">Second Semester</option> 
                                </select>
    
                            </div>

                        @else
                        <div class="col-sm-3 col-md-2">
                            <label for="semester" class=" control-label">Semester</label>
                            <select class="form-control" name="semester_id">
                                <option value=""> - - Select - -</option>
                                @if(isset($s))
                                    @foreach($s as $v)
                                        <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="col-sm-3 col-md-2">
                            <label for="level" class=" control-label">Level</label>
                            <select class="form-control" name="level">
                                <option value=""> - - Select - -</option>
                                @if(isset($l))
                                    @foreach($l as $v)
                                        <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        @endif
                        @endif
                        <div class="col-sm-3 col-md-2">
                            <label for="level" class=" control-label">Season</label>
                            <select class="form-control" name="season">
                                <option value=""> - - Select - -</option>
                                <option value="NORMAL">NORMAL</option>
                                 @if(Auth::user()->programme_id == 2)
                                <option value="RESIT">RESIT</option>
                                @else
                                @if(Auth::user()->faculty_id == $med)
                                <option value="VACATION">RESIT</option>
                                @else
                                <option value="VACATION">VACATION</option>
                                @endif

                                @endif

                            </select>

                        </div>

                        <div class="col-sm-3 col-md-2">
                            <br/>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fa fa-btn fa-user"></i> View Student
                            </button>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>
    @if(isset($u))
        @if(count($u) > 0)
            {{!$next = $ss+1}}
            <div class="col-sm-12">


                <p>
                    <span><strong>Entry Year : </strong>{{$ss." / ".$next}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span><strong>Level : </strong>{{$l_id}}00</span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span><strong>Semester : </strong>
                    @if(Auth::user()->programme_id == 4)

                    @else
                        @if($s_id == 1)
                         First
                        @else
                       Second
                        @endif
                  </span>
                     @endif
                </p>

                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">S/N</th>
                       <!-- <th>Select</th>-->
                        <th class="text-center">MATRIC NUMBERS</th>
                        <th class="text-center">NAMES</th>
                      <th class="text-center">ACTION</th>

                    </tr>
                    {{!!$c = 0}}
                    @foreach($u as $v)
                        <tr>
                            <td>{{++$c}}</td>
                            <!--<td><input type="checkbox" value="{{$v->id}}" name="id[]"> </td>-->
                            <td>{{$v->matric_number}}</td>
                            <td>{{$v->surname." ".$v->firstname." ".$v->othername}}</td>
                            
                         <td>
                                <button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal{{$v->id}}">Enter Result</button>
                              &nbsp; &nbsp;
                             <!--  <a href="{{url('deleteRegistration',$v->id)}}" class="btn btn-danger ">Delete</a>-->
                            </td>
                        </tr>
<!-- ======== =============== for student course reg ========================================-->
                        
                        {{! $course =DB::connection('mysql2')->table('course_regs')
                         ->where('studentreg_id',$v->id)
                         ->orderBy('course_code','ASC')
                        ->get()
                         }}
@if(isset($course))
@if(count($course) > 0)


                                <div id="myModal{{$v->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/entering_result') }}" data-parsley-validate>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="faculty_id" value="{{$ff}}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title text-center text-danger">{{strtoupper($v->surname." ".$v->firstname." ".$v->othername)}}</h4>
                                        <h4 class="modal-title text-center text-success">{{$v->matric_number}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-sm-offset-1 col-sm-10" style="margin-bottom: 5px;">
                                        <div class="col-sm-1 text-center" >
                                         
                                        </div>
                                        <div class="col-sm-3 text-center" >Code</div>
                                        <div class="col-sm-2 text-center" >Unit</div>
                                        <div class="col-sm-2 text-center" >CA</div>
                                        <div class="col-sm-2 text-center" >Exams</div>
                                        <div class="col-sm-2 text-center" >Total</div>
                                         <input type="hidden" name="fos_id" value="{{$v->fos_id}}"/>
                                            <input type="hidden" name="user_id" value="{{$v->user_id}}"/>
                                            <input type="hidden" name="matric_number" value="{{$v->matric_number}}"/>
                                            <input type="hidden" name="session_id" value="{{$v->session}}"/>
                                            <input type="hidden" name="semester_id" value="{{$v->semester}}"/>
                                            <input type="hidden" name="level_id" value="{{$v->level_id}}"/>
                                            <input type="hidden" name="season" value="{{$v->season}}"/>
                                              <input type="hidden" name="entry_year" value="{{$v->entry_year}}"/>
                                            </div>
                                        @foreach($course as $vv)
<!-- ================================== for student result ========================================-->
                        {{! $result =DB::connection('mysql2')->table('student_results')
                         ->where('coursereg_id',$vv->id)
                         ->get()
                         }}        
                                            <div class="col-sm-offset-1 col-sm-10" style="margin-bottom: 9px;">
                                            <div class="col-sm-1" > <input type="checkbox" name="chk[]" value="{{$vv->id}}"/></div>
                                            <div class="col-sm-3 text-center text-success" > {{$vv->course_code}}</div>
                                            <div class="col-sm-2 text-center text-info" >{{$vv->course_unit}}</div>
                                          
                                            @if(count($result) > 0)
                                            @foreach($result as $rv)
                                              <div class="col-sm-2 text-center text-danger">
 <input type="text" class="form-control" name="ca[{{$rv->id}}]" onKeyUp="CA(this,'exam{{$rv->id}}','d{{$rv->id}}')" value="{{$rv->ca}}" id="ca{{$rv->id}}"/>
</div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="exam[{{$rv->id}}]"  onKeyUp="updA(this,'ca{{$rv->id}}','d{{$rv->id}}')" value="{{$rv->exam}}" id="exam{{$rv->id}}" />
</div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="total[{{$rv->id.'~'.$vv->id.'~'.$vv->course_id.'~'.$vv->course_unit}}]" value="{{$rv->total}}" id="d{{$rv->id}}" readonly />
</div>
                                            @endforeach
                                            @else
    <div class="col-sm-2 text-center text-danger">                                          
 <input type="text"  class="form-control" name="ca[{{$vv->id}}]" onKeyUp="CA(this,'exam{{$vv->id}}','d{{$vv->id}}')" value="" id="ca{{$vv->id}}"/>
</div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="exam[{{$vv->id}}]" onKeyUp="updA(this,'ca{{$vv->id}}','d{{$vv->id}}')" value="" id="exam{{$vv->id}}"/>
</div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="total[{{$vv->id.'~'.$vv->course_id.'~'.$vv->course_unit}}]" value="" id="d{{$vv->id}}"  readonly/>
</div>
                                            @endif
                                               

                                                
                                                </div>
                                                <div class="clearfix"></div>


                                            @endforeach



                                    </div>
                                    <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger" name="delete" value="delete">Delete</button>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                        

                            </div>
                        </div>
                            @endif
                        @endif
</form>
                    @endforeach
                </table>
                 <!--<button type="submit" class="btn btn-danger">Submit</button>-->
                </form>
                {{$u->setPath($url)->render()}}
                @else
                    <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
                        No Student is avalable!!!
                    </div>

                @endif
                @endif
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