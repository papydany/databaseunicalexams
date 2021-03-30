@extends('layouts.admin')
@section('title','View Registered student')
@section('content')
@inject('r','App\R')
        <!-- Page Heading -->
<?php 
 use Illuminate\Support\Facades\Auth;
$result= $r->getrolename(Auth::user()->id) ?>
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
                <form class="form-horizontal" role="form" method="GET" action="{{ url('post_register_student_ii') }}" data-parsley-validate >
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
                                    <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                @endfor

                            </select>

                        </div>
                        @if($result =="examsofficer")
        
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
                        <div class="col-sm-3 col-md-2">
                            <label for="level" class=" control-label">Season</label>
                            <select class="form-control" name="season">
                                <option value=""> - - Select - -</option>
                                <option value="NORMAL">NORMAL</option>
                                 @if(Auth::user()->programme_id == 2)
                                <option value="RESIT">RESIT</option>
                                @else
                                <option value="VACATION">VACATION</option>

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
                    <span><strong>Session : </strong>{{$ss." / ".$next}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span><strong>Level : </strong>{{$l_id}}00</span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span><strong>Season : </strong>{{$season}}</span>&nbsp;&nbsp;&nbsp;&nbsp;  
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
                           
                            <td>{{$v->matric_number}}</td>
                            <td>{{$v->surname." ".$v->firstname." ".$v->othername}}</td>
                            
                         <td>
                                <a href="{{url('registered_student_detail',[$v->id,$l_id,$ss,$season])}}" type="button" class="btn btn-primary btn-xs" target="_blank">Details</a>
                        </td>
                        </tr>
                        @endforeach
                </table>

  @else
                    <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
                        No Student  is avalable!!!
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