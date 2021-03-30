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
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/entering_result') }}" data-parsley-validate>
                                        {{ csrf_field() }}
                                <div class="modal-content">
                                 
                                    <div class="modal-body">
                                        <div class="col-sm-offset-1 col-sm-10" style="margin-bottom: 5px;">
                                        <div class="col-sm-1 text-center" >
                                        <div class="col-sm-2 text-center" >Select</div>
                                        </div>
                                        <div class="col-sm-3 text-center" >Code</div>
                                        <div class="col-sm-2 text-center" >Unit</div>
                                        <div class="col-sm-2 text-center" >CA</div>
                                        <div class="col-sm-2 text-center" >Exams</div>
                                        <div class="col-sm-2 text-center" >Total</div>
                                         <input type="hidden" name="fos_id" value="{{$u->fos}}"/>
                                            <input type="hidden" name="user_id" value="{{$u->id}}"/>
                                            <input type="hidden" name="matric_number" value="{{$u->matric_number}}"/>
                                            <input type="hidden" name="session_id" value="{{$session}}"/>
                                            <input type="hidden" name="level_id" value="{{$level}}"/>
                                            <input type="hidden" name="season" value="{{$season}}"/>
                                              <input type="hidden" name="entry_year" value="{{$u->entry_year}}"/>
                                            </div>
                                        @foreach($s as $v)
                                        <?php $r =$v['r'];


?>
                                            <div class="col-sm-offset-1 col-sm-10" style="margin-bottom: 9px;">
                                            <div class="col-sm-1" > <input type="checkbox" name="chk[]" value="{{$v['id']}}"/></div>
                                            <div class="col-sm-3 text-center text-success" > {{$v['code']}}</div>
                                            <div class="col-sm-2 text-center text-info" >{{$v['unit']}}</div>
                                          
                                           
                                              <div class="col-sm-2 text-center text-danger">
 <input type="text" class="form-control" name="ca[{{$v['r']}}]" onKeyUp="CA(this,'exam{{$r}}', 'd{{$r}}')"  value="{{$v['ca']}}" id="ca{{$v['r']}}"/>
</div>
  <div class="col-sm-2 text-center text-danger">
  <input type="text"  class="form-control" name="exam[{{$v['r']}}]"  onKeyUp="updA(this,'ca{{$r}}','d{{$r}}')" value="{{$v['exam']}}" id="exam{{$v['r']}}" />

  </div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="total[{{$r.'~'.$v['id'].'~'.$v['course_id'].'~'.$v['unit']}}]" value="{{$v['total']}}" id="d{{$r}}" readonly />
</div>
                                           

                                               

                                                
                                                </div>
                                                <div class="clearfix"></div>


                                            @endforeach



                                    </div>
                                    <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger" name="delete" value="delete">Delete</button>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
                                    </div>
                                </div>
                                </form>

                            </div>
                        </div>
                      

    </div>
</div>

               
              