@extends('layouts.admin')
@section('title','Assign HOD Role')
@section('content')
@inject('r','App\R')
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
        <div class="col-sm-12" style="min-height: 520px;">
          
                        <div class="col-sm-12"> 
                           @if(isset($u))
                        @if(count($u) > 0)
                      
                        <table class="table table-bordered table-striped">
                        <tr>
                       
                        <th>S/N</th>
                          <th>Title</th>
                        <th>Name</th>
                         <th>Username</th>
                       
                        <th>Department</th>
                  
                        <th>Edit Status</th>
                       <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($u as $v)
                       <?php $department =$r->get_departmetname($v->department_id); ?>
                       <tr>
                        
                       <td>{{++$c}}</td>
                         <td>{{$v->title}}</td>
                       <td>{{$v->name}}</td>
                       <td>{{$v->username}}</td>
                      <!-- <td>{{$v->plain_password}}</td>-->
                       <td>{{$department}}</td>
                       
<td>{{$v->edit_right}}</td>
<td><div class="btn-group">
  <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('remove_hod',$v->id)}}" class="text-danger">Remove HOD</a></li>
    <li class="divider"></li>
     <li><a href="#" class="text-success">Edit Right</a></li>
      <li class="divider"></li>
    <li><a href="{{url('/edit_right',[$v->id,0])}}">0</a></li>
    <li><a href="{{url('/edit_right',[$v->id,6])}}">6</a></li>
    <li><a href="{{url('/edit_right',[$v->id,8])}}">8</a></li>
    <li><a href="{{url('/edit_right',[$v->id,10])}}">10</a></li>
    <li><a href="{{url('/edit_right',[$v->id,12])}}">12</a></li>

  </ul>
</div></td>
       

                       </tr>
                       @endforeach
                     
                        </table>
                      </form>


                        @endif
                        @endif

                        </div>
                        </div>
                        </div>

                           
@endsection  
     