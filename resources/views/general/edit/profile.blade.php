@extends('layouts.admin')
@section('title','Edit Profile')
@section('content')
@inject('r','App\R')

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
                Edit Student Profile 
            </h3>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Edit Student Profile 
                </li>
            </ol>
        </div>
    </div>
    <?php
    $department = $r->get_departmetname($u->department_id);

    $fos_name = $r-> get_fos($u->fos_id);
    ?>

    <div class="row">
    <div class="col-sm-12">	
            <div class="col-sm-12">	
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_profile') }}" data-parsley-validate> 
        {{ csrf_field() }}  
        
        <div class="form-group">
         <h5 class="alert alert-success">{{$u->surname }} {{$u->firstname }} {{$u->othername }}</h5>
         <br/>
    
        <h5><b>Department :</b> {{$department}}</h5>
        <h5><b>Field Of Study :</b> {{$fos_name}}</h5>
        <br/>
        
        <input type="hidden" class="form-control" name="id" value="{{$u->id}}">

     <div class="col-sm-4">
     <label for="surname">Surname</label>
         <input  type="text" class="form-control" name="surname" value="{{$u->surname}}" required>
        </div>

        <div class="col-sm-4">
     <label for="matric_number">First Name</label>
         <input id="matric_number" type="text" class="form-control" name="firstname" value="{{$u->firstname}}" required>

         @if ($errors->has('firstname'))
             <span class="help-block">
                 <strong>{{ $errors->first('firstname') }}</strong>
             </span>
         @endif
     </div>
     <div class="col-sm-4">
        <label for="matric_number">Other Name</label>
            <input id="matric_number" type="text" class="form-control" name="othername" value="{{$u->othername}}" required>
   
            @if ($errors->has('othername'))
                <span class="help-block">
                    <strong>{{ $errors->first('othername') }}</strong>
                </span>
            @endif
        </div>
     </div>
    
     <div class="form-group">
        <div class="col-sm-4">
            <label for="matric_number">Phone</label>
                <input id="matric_number" type="text" class="form-control" name="phone" value="{{$u->phone}}" required>
       
                @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-sm-4">
                <label for="email">Email</label>
                    <input  type="text" class="form-control" name="email" value="{{$u->email}}" required>
           
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
             
     </div>
         <input type="submit" name="" value="submit" class="btn btn-success">
     </div>
     </div>
 </form>
    </div>
    </div>
</div>
@endsection 
@section('script')
<script src="{{URL::to('js/main.js')}}"></script>

@endsection
