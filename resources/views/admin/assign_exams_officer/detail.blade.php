@extends('layouts.admin')
@section('title','View Desk Officer')
@section('content')
 <!-- Page Heading -->
                <div class="row">
                    <div class="col-sm-6">
                       
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
     
                </div>

    <div class="row" style="min-height: 520px;"">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Detailed Exams Officer</div>
                <div class="panel-body">
                   
                        @if(isset($u))
                       
                        <table class="table table-bordered table-striped">
                        <tr>
                      
                        <th>Name</th>
                       <th>Department</th>
                        <th>Assignd Fos</th>
                         </tr>
                        @inject('r','App\R')
          <?php $dept= $r->get_departmetname($u->department_id); ?>
                    <tr><td>{{$u->name}}</td>
                        <td>{{$dept}}</td>
                     
                       <td>
                       
                       {{! $fos_d = DB::table('fos')
            ->join('deskoffice_fos', 'fos.id', '=', 'deskoffice_fos.fos_id')
            ->where('deskoffice_fos.user_id',$u->id)
           
            ->select('fos.fos_name','deskoffice_fos.id')
            ->get()}}
             @if(isset($fos_d))
             @if(count($fos_d) > 0)
             <table class="table table-striped">
          @foreach($fos_d as $value)
         <tr><td>
         {{ $value->fos_name}}
       </td>
       <td><a href="{{url('remove_fos',$value->id)}}"
         class="btn btn-danger btn-xs">Delete</a><td>
         </tr>
           @endforeach
</table>
           @else
 <span class="text-danger"> No field of study assign</span>
              @endif
              @endif
</td>


                       </tr>
                      
                     
                        </table>
 

                        @endif
                      
                        </div>
                        </div>
                        </div>
                        </div>

@endsection                      