@extends('layouts.admin')
@section('title','Suspend Desk Officer')
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
                <div class="panel-heading">Suspend Desk Officer</div>
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
                      
          

<td><div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
   
 <li><a href="{{url('assign_deskofficer',$v->id)}}">Assign </a></li>
    

    
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