@extends('layouts.admin')
@section('title','Enter Result')
@section('content')
@inject('r','App\R')
<?php $role =$r->getroleId(Auth::user()->id); 

$acct =$r->getResultActivation($role); ?>
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

    <div class="row" style="min-height: 420px;">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Enter Result</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/e_result') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
                        @if(Auth::user()->faculty_id == $med)
                        <div class="col-sm-3">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" id="level_id" required>
                               <option value=""> - - Select - -</option>
                        {{$i = 1}}
                                @foreach($l as $k => $v)
                               
                                @if($v->level_id < 3)

                                <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                              
                                @else
                                <option value="{{$v->level_id}}">PART {{$i++}}</option>
                              
                                @endif
                                 @if($v->level_id == 6)
                                   @break;
                                   @endif
                              
                                @endforeach
                                
                              </select>
                             
                            </div>
                            <input type="hidden" name="semester" value="1"/>
                        @else
                     <div class="col-sm-2">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" id="level_id" required>
                                  <option value=""> - - Select - -</option>
                                  @if(isset($l))
                                  @foreach($l as $v)
                                  <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>
                            @endif

                         
                             <div class="col-sm-3">
                              <label for="fos" class=" control-label">Field Of Study</label>
                              <select class="form-control" name="fos" id="fos_id" required>
                               <option value=""> - - Select - -</option>
                                 
                                  @foreach($f as $v)
                                  <option value="{{$v->id}}">{{$v->fos_name}}</option>
                                  @endforeach
                                  
                              </select>
                             
                            </div>

                               <div class="col-sm-2">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session"  required>
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
                            @if(Auth::user()->faculty_id != $med)
                          <div class="col-sm-3">
                              <label for="semester" class=" control-label">Semester</label>
                              <select class="form-control" name="semester"  required>
                                  <option value=""> - - Select - -</option>
                                  @if(isset($s))
                                  @foreach($s as $v)
                                  <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>
                                  @endforeach
                                  @endif
                              </select>
                             
                            </div>
                            @endif
                              <div class="col-sm-2">
                                 <br/>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-user"></i> Continue
                                </button>
                            </div>
                        
                            </div>
                           
                              </form>  </div>
                        </div>
                        </div>
                        </div>


  @endsection 
                      
 