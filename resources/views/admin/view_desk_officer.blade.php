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
                <div class="col-sm-6">    

                    <form method="POST" action="{{url('search')}}">
          
<div class="form-group col-sm-8">    
 <input type="text" placeholder="Search By Department"  name="search_code" class="typeahead form-control" autofocus="">
</div>
<div class="form-group col-sm-2"> 
    <input type="submit" value="Continue" class="btn btn-danger">
  
   </div> 
 </form>
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
                        
                         <th>Email</th>
                        
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
                        @if($v->status)
                        <tr style="background-color: red;color: white;">

                        @else
                        <tr>

                        @endif
                       
                       <td>{{++$c}}</td>
                       <td>{{$v->name}}</td>
                        <td>{{$prog}}</td>
                       <td>{{$dept}}</td>
                       <td>{{$v->username}}</td>
                      <td>{{$v->email}}</td>
                       <td>
                       
                       {{! $fos_d = DB::table('fos')
            ->join('deskoffice_fos', 'fos.id', '=', 'deskoffice_fos.fos_id')
            ->where('deskoffice_fos.user_id',$v->id)
            ->where('deskoffice_fos.status',1)
            ->select('fos.fos_name')
            ->get()}}
             @if(isset($fos_d))
             @if(count($fos_d) > 0)
             <table class="table table-striped">
          @foreach($fos_d as $value)
         <tr><td>
         {{ $value->fos_name}}
       </td>
         </tr>
           @endforeach
</table>
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
    @if($v->status ==1)
 <li><a href="{{url('activate',[$v->id,0])}}">Activate</a></li>
    @else
<li><a href="{{url('/edit_right',[$v->id,0])}}">0</a></li>
    
    <li><a href="{{url('/edit_right',[$v->id,10])}}">10</a></li>
    
 <li><a href="{{url('/edit_right',[$v->id,15])}}">15</a></li>
  <li><a href="{{url('/edit_right',[$v->id,20])}}">20</a></li>
     <li class="divider"></li>
     <li><a href="{{url('activate',[$v->id,1])}}">Deactivate</a></li>
     @if($v->department_id != 0)
       <li class="divider"></li>
     <li><a href="{{url('suspend',[$v->id])}}">Suspend Account</a></li>
     @endif
    @endif

    
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

  <script type="text/javascript">
    var path = "{{ route('autocomplete_department') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
</script>                      

  @endsection                      