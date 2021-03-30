@extends('layouts.admin')
@section('title','Delete Result')
@section('content')
@inject('r','App\R')

             
                  <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
      @if(isset($u))
       @if(count($u) > 0)
     <?php  $fos =$r->get_fos($fos_id);?>
                   
                   {{!$next = $s + 1}}
                  {{! $semester =DB::table('semesters')
                  ->where('semester_id',$sm)->first()}}
                           
<table  class="table table-bordered">
<tr><td>

  
    <div class="col-sm-9 www">
  
    
      <p>PROGRAMME:  {{$fos}}</p>
  <p> <strong>Level : </strong>{{$l}}00 </p>
      <p><strong>Session : </strong>{{$s.' / '.$next}}</p>
      </div>
  <div class="col-sm-3 ww">
     
       <p><strong>Semester : </strong>{{$semester->semester_name}} </p>
        <p><strong>Course  : </strong>{{$course_code}}</p>
        <p><strong>Result Type  : </strong>{{$result_type}}</p>
    </div>

    </td></tr>
 
  
  
</table>
 <form class="form-horizontal" role="form" method="POST" action="{{ url('/delete_desk_multiple_result') }}" data-parsley-validate>
                        {{ csrf_field() }}
            
                       
                 <table class="table table-bordered table-striped">
                 <tr>
                     <th>ALL <input type="checkbox" id="all_ids" name="" value=""></th>
                        <th class="text-center">S/N</th>
                        <th class="text-center">MATRIC NUMBERS</th>
                        <th class="text-center">NAMES</th>
                        <th class="text-center">CA</th>
                        <th class="text-center">EXAMS</th>
                        <th class="text-center">TOTAL</th>
                        <th class="text-center">ACTION</th>
                          </tr>
                            {{!!$c = 0}}
                      @foreach($u as $v)
                    <?php 
                   // $result= $r->getresultWithResultType($v->id,$result_type) ?>
                      {{!$c = ++$c}}
                      
                      <tr>
                        
                       <td>
                        @if(isset($v->id))
                        <input type="checkbox" class="ids" name="id[]" value="{{$v->id}}">
                       @endif
                        </td>
                      
                        

                      <td>{{$c}}</td>
                       <td>{{$v->matric_number}}</td>

                        <td>{{strtoupper($v->surname." ".$v->firstname." ".$v->othername)}}</td>
                         <td>{{isset($v->ca) ?$v->ca : ''}}</td>
                       <td>{{isset($v->exam) ? $v->exam: ''}}</td>
                     <td>{{isset($v->total) ? $v->total: ''}}</td>
                        <td class="text-center">
      @if(isset($v->id))                                         
<div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
  <li><a href="{{url('delete_desk_result',$v->id)}}">Delete</a></li>
  </ul>
</div>
@endif
                      </td>
                      </tr>
                     
                      @endforeach
                       <tr><td colspan="8"><input type="submit" value="Delete selected row" class="btn btn-danger"></td></tr>
                  </table>
                </form>


                       @else
                        <p class="alert alert-warning">No  students records is avalable for {{$result_type}} Result type</p>
                        @endif
                        
  @endif
                  </div>
                    </div>
                    </div>
                    </div>
                    </div>
  @endsection 
  @section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection
             