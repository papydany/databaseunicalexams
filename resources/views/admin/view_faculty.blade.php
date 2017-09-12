@extends('layouts.admin')
@section('title','View Faculty')
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
                <div class="panel-heading">View Faculty</div>
                <div class="panel-body">
                 

                        @if(isset($f))
                        @if(count($f) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Faculty</th>
                        <th>Action</th>
                       </tr>
                       {{!!$c = 0}}
                       @foreach($f as $v)
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->faculty_name}}</td>
                       <td><div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('edit_faculty',$v->id)}}">Edit</a></li>
    
  </ul>
</div></td>
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