@extends('layouts.admin')
@section('title','View Programme')
@section('content')
 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">View Programme</div>
                <div class="panel-body">
                 

                        @if(isset($p))
                        @if(count($p) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Programme</th>
                       
                       </tr>
                       {{!!$c = 0}}
                       @foreach($p as $v)
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->programme_name}}</td>
                       
                       </tr>
                       @endforeach
                        </table>


                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      