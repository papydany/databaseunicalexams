@extends('layouts.admin')
@section('title','Edit lecturer')
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
                <div class="panel-heading">Edit Lecturer</div>
                <div class="panel-body">
                   
                        @if(isset($l))
                        <form method="POST" action="{{url('edit_lecturer',$l->id)}}" data-parsley-validate>
                        {{ csrf_field() }}
                        <table class="table table-bordered table-striped">
                        <tr>
                   
                          <th>Title</th>
                        <th>Name</th>
                        
                        <th>Password</th>
                        <th>Action</th>
                  
                       </tr>
                       
                       <tr>
                     
                         <td>   <select class="form-control" name="title" class="form-control" required>
                               <option value="">Select</option>
                                   <option value="Mr">Mr</option>
                                   <option value="Mrs">Mrs</option>
                                   <option value="Miss">Miss</option>
                                   <option value="Dr">Dr</option>
                                     <option value="Dr(Mrs)">Dr(Mrs)</option>
                                   <option value="Prof">Prof</option>
                                  <option value="Prof(Mrs)">Prof(Mrs)</option>
                                  <option value="Assoc Prof">Assoc Prof</option>
                                   <option value="Rev(Dr)">Rev(Dr)</option>
                                   <option value="Rev(Sis)">Rev(Sis)</option>
                                   <option value="Rev(prof)">Rev(Prof)</option>
                                   <option value="Barr">Barr</option>
                                   <option value="Barr Mrs">Barr Mrs</option>
                             
                               </select></td>
                       <td><input type="text" class="form-control" name="name" value="{{$l->name}}" required></td>
                
                      <!-- <td><input type="text" class="form-control" name="password" value="" required></td>-->
                       <td><input type="submit" value="submit" class="btn btn-success"></td>
                      
       

                       </tr>
                   
                     
                        </table>
 
</form>
                    
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      