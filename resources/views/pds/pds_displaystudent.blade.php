 @extends('layouts.display')
@section('title','Registered Student')
@section('content')
@inject('r','App\R')

             
                  <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
      @if(isset($u))
       @if(count($u) > 0)
     <?php $role =$r->getrolename(Auth::user()->id); ?>
                   
                   {{!$next = $s + 1}}
                 
                           
<table  class="table table-bordered">
<tr><td>
<p class="text-center" style="font-size:18px; font-weight:700;">UNIVERSITY OF CALABAR</p>
    <p class="text-center" style="font-size:16px; font-weight:700;">CALABAR</p>
    <p class="text-center" style="font-size:14px; font-weight:700;">REGISTERED STUDENTS</p>
    <div class="col-sm-9 www">
  

   
      <p>PROGRAMME: Pre Degree In {{$role}}</p>
 <p>LECTURER:  {{Auth::user()->title.'&nbsp;&nbsp;'.Auth::user()->name}}</p>
      </div>
  <div class="col-sm-3 ww">
    
      <p><strong>Session : </strong>{{$s.' / '.$next}}</p>
  
    

    </div>

    </td></tr>
 
  
  
</table>

            
                       
                 <table class="table table-bordered table-striped">
                 <tr>
                     
                        <th width="3%">S/N</th>
                        <th width="12%">Martic Number</th>
                        <th>Names</th>
                        <th width="15%">Profile Pic</th>
                        
                        <th width="15%">Signature</th>
                          </tr>
                            {{!!$c = 0}}
                      @foreach($u as $v)
                 
                      {{!$c = ++$c}}
                      <tr>
                      
                      <td>{{$c}}</td>
                       <td>{{$v->matric_number}}</td>

                        <td>{{strtoupper($v->surname." ".$v->firstname." ".$v->othername)}}</td>
                         <!--<td><img src="{{asset('img/student/'.$v->image_url)}}"></td>-->
                         <td><img src="https://unicalexams.edu.ng/assets/images/slides/cal2.jpg" width="100%"></td>
                   
                     <td></td>
                       
                      </tr>
                     
                      @endforeach
                  </table>


                       @else
                        <p class="alert alert-warning">No Register students  is avalable</p>
                        @endif
                        
  @endif
                  </div>
                    </div>
                    </div>
                    </div>
                    </div>
  @endsection 
             
