@extends('layouts.admin')
@section('title','Edit Matric Number')
@section('content')
@inject('r','App\R')

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
                Edit Matric Number 
            </h3>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Edit Matric Number 
                </li>
            </ol>
        </div>
    </div>
    <?php
    $department = $r->get_departmetname($u->department_id);

    $fos_name = $r-> get_fos($u->fos_id);
    ?>

    <div class="row">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_matric_number') }}" data-parsley-validate> 
        {{ csrf_field() }}  	
     <div class="col-xs-12">	
         <h5 class="alert alert-success">{{$u->surname }} {{$u->firstname }} {{$u->othername }}</h5>
         <br/>
    
        <h5><b>Department :</b> {{$department}}</h5>
        <h5><b>Field Of Study :</b> {{$fos_name}}</h5>
        <br/>
        
   

     <div class="col-sm-4">
     <label for="matric_number">Old Matric_Number</label>
         <input id="matric_number" type="text" class="form-control" name="oldmatric_number" value="{{$u->matric_number}}" disabled>
         <input type="hidden" class="form-control" name="old_matric_number" value="{{$u->matric_number}}">
         <input type="hidden" class="form-control" name="id" value="{{$u->id}}">

        
     </div>

        <div class="col-sm-4">
     <label for="matric_number">Enter New Matric Number</label>
         <input id="matric_number" type="text" class="form-control" name="matric_number" value="" required>

         @if ($errors->has('matric_number'))
             <span class="help-block">
                 <strong>{{ $errors->first('matric_number') }}</strong>
             </span>
         @endif
     </div>
<br/>
         <input type="submit" name="" value="submit" class="btn btn-success">
     </div>
     </div>
 </form>
    </div>
@endsection 
@section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection
