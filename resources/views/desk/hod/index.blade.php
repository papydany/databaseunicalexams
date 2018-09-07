@extends('layouts.admin')
@section('title','Generate Result')
@section('content')
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
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('getreport') }}" target="_blank" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="form-group">
 <div class="col-sm-4">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session"  required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                             <div class="col-sm-4">
                              <label for="fos" class=" control-label">Programme</label>
                              <select class="form-control" name="p" id="p_id" required>
                               <option value=""> - - Select - -</option>
                                 
                                  @foreach($p as $v)
                                  <option value="{{$v->id}}">{{$v->programme_name}}</option>
                                  @endforeach
                                  
                              </select>
                             
                            </div>
 <div class="col-sm-4">
                              <label for="fos" class=" control-label">Field Of Study</label>
                              <select class="form-control" name="fos" id="fos_id" required>
                               <option value=""> - - Select - -</option>
                                 
                                 
                                  <option value=""></option>
                               
                                  
                              </select>
                             
                            </div>

                     <div class="col-sm-4">
                              <label for="level" class=" control-label">Level</label>
                              <select class="form-control" name="level" id="level_id" required>
                                  <option value=""> - - Select - -</option>
                                 
                              </select>
                             
                            </div>

                         
                            

                              
                          <div class="col-sm-4">
                              <label for="semester" class=" control-label">Result Type</label>
                              <select class="form-control" name="result_type" id="result_type"  required>
                                  <option value=""> - - Select - -</option>
                                 
                              </select>
                             
                            </div>
                            <input type="hidden" name="duration" id="duration" value="">
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

                      
 