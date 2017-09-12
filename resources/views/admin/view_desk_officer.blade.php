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

    <div class="row" style="min-height: 520px;"">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">View Desk Officer</div>
                <div class="panel-body">
                   
                        @if(isset($u))
                        @if(count($u) > 0)
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Programme</th>
                         <th>Department</th>
                         <th>Username</th>
                        <th>Password</th>
                  
                         <th>Assignd Fos</th>
                         <td>Edit Status</td>
                         <td>Enable Edit</td>
                       </tr>
                        @inject('r','App\R')
         
                       {{!!$c = 0}}
                       @foreach($u as $v)
                       <?php $dept= $r->get_departmetname($v->department_id);
                         $prog= $r->get_programmename($v->programme_id);

                        ?>
                       <tr>
                       <td>{{++$c}}</td>
                       <td>{{$v->name}}</td>
                        <td>{{$prog}}</td>
                       <td>{{$dept}}</td>
                       <td>{{$v->username}}</td>
                       <td>{{$v->plain_password}}</td>
                       <td>
                       
                       {{! $fos_d = DB::table('fos')
            ->join('deskoffice_fos', 'fos.id', '=', 'deskoffice_fos.fos_id')
            ->where('deskoffice_fos.user_id',$v->id)
            ->where('deskoffice_fos.status',1)
            ->select('fos.fos_name')
            ->get()}}
             @if(isset($fos_d))
             @if(count($fos_d) > 0)
          @foreach($fos_d as $value)
          <div class="col-sm-4">
         {{ $value->fos_name}}
         </div>
           @endforeach

           @else
 <span class="text-danger"> No field of study assign</span>
              @endif
              @endif
</td>
<td>{{$v->edit_right}}</td>
<td><div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('/edit_right',[$v->id,6])}}">6</a></li>
    <li><a href="{{url('/edit_right',[$v->id,8])}}">8</a></li>
    <li><a href="{{url('/edit_right',[$v->id,10])}}">10</a></li>
    <li><a href="{{url('/edit_right',[$v->id,12])}}">12</a></li>

  </ul>
</div></td>

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