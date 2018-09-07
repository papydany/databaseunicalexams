@extends('layouts.admin')
@section('title','students')
@section('content')
@inject('R','App\R')
 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>students</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                <div class="col-md-12"> 
                @if($u)

                @if(count($u) > 0)
                <table class="table table-bordered table-striped">
                <tr>
                <th>S/N</th>
                  <th>Matric Number</th>
                 <th>Name</th>
                 <th>Department</th>
                 <th>Date Reg</th>
                 <th>Pin</th>
               
                </tr>
                {{!!$c = 0}}
                @foreach($u as $v)
               <?php  $depart = $R->get_departmetname($v->department_id); 
                     $pin = $R->get_pin_year($v->matric_number,$v->entry_year);

               ?>
                <tr>
                <td>{{++$c }}</td>
                <td>{{$v->matric_number}}</td>
                <td>{{$v->surname .' '.$v->firstname.' '.$v->othername}}</td>
                <td>{{$depart}}</td>
                <td>{{date('F j , Y - h:i:sa',strtotime($v->created_at))}}</td>
                <td>@foreach($pin as $vs)
                    {{$vs->id."--".$vs->pin}}

                @endforeach
            </td>
                </tr>
                


                @endforeach
               
              
             


                </table>
 <p> {{ $u->links() }}   </p>

                @endif
                @endif
                </div>
                </div>
                

@endsection               