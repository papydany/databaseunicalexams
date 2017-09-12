@extends('layouts.admin')
@section('title','View Used Pin')
@section('content')

 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Used pin</small>
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
                @if($used_pin)

                @if(count($used_pin) < 0)
                <table class="table table-bordered table-striped">
                <tr>
                <th>S/N</th>
                 <th>Pin</th>
                </tr>
               {{!!$c = 0}}
                @foreach($unused_pin as $v)
                <tr>
                <td>{{++$c }}</td>
                <td>{{$v->pin}}</td>
                </tr>
                


                @endforeach 	


                </table>
 <p> {{ $used_pin->links() }}   </p>
                @endif
                @endif
                </div>

@endsection                