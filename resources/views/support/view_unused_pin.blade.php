@extends('layouts.admin')
@section('title','View Unused Pin')
@section('content')

 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Unused pin</small>
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
                <div class="col-md-10 col-md-offset-1"> 
                @if($unused_pin)

                @if(count($unused_pin) > 0)
                <table class="table table-bordered table-striped">
                <tr>
                <th>S/N</th>
                  <th>Serial Number</th>
                 <th>Pin</th>
                </tr>
                {{!!$c = 0}}
                @foreach($unused_pin as $v)
                <tr>
                <td>{{++$c }}</td>
                <td>{{$v->id}}</td>
                <td>{{$v->pin}}</td>
                </tr>
                


                @endforeach
               
              
             


                </table>
 <p> {{ $unused_pin->links() }}   </p>

                @endif
                @endif
                </div>
                </div>
                

@endsection               