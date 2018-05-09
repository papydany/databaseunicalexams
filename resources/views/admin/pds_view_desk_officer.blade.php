@extends('layouts.admin')
@section('title','View Desk Officer')
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

    <div class="row">
        <div class="col-sm-12" style="min-height: 520px;">
            <div class="panel panel-default">
                <div class="panel-heading">View PDS Desk Officer</div>
                <div class="panel-body">
                   
                        @if(isset($u))
                        @if(count($u) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Name</th>
                          <th>Type</th>
                         <th>Username</th>
                        <th>Password</th>
                  
                    
                       </tr>
                       {{!!$c = 0}}
                       @foreach($u as $v)
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->name}}</td>
                       <td>@if($v->role_id == 6)
                        Science

                        @elseif($v->role_id == 7)
Modern Language
                        @endif
                      </td>
                       <td>{{$v->username}}</td>
                       <td>{{$v->plain_password}}</td>
                      

                       </tr>
                       @endforeach
                     
                        </table>
  {{ $u->links() }}

                        @endif
                        @endif
                        </div>
                        </div>
                        </div>
                        </div>

  @endsection                      