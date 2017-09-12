@extends('layouts.admin')
@section('title','Create Course Unit')
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

    <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">View Course Unit </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/view_course_unit') }}" data-parsley-validate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                        
                               <div class="col-sm-4">
                              <label for="session" class=" control-label">Session</label>
                              <select class="form-control" name="session" required>
                              <option value=""> - - Select - -</option>
                               
                                  @for ($year = (date('Y')); $year >= 2016; $year--)
                                  {{!$yearnext =$year+1}}
                                  <option value="{{$year}}">{{$year.'/'.$yearnext}}</option>
                                  @endfor
                                
                              </select>
                             
                            </div>
                            
                         

                      

                            

                            <div class="col-md-2">
                            <br/>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Create
                                </button>
                            </div>

                        </div>

                        </form>

                        @if(isset($c))
                        <table class="table table-bordered table-stripe">
                        <tr>
                          <th>Sn</th>
                           <th>Level</th>
                           <th>Field of Study</th>
                          <th>Min</th>
                            <th>Max</th>
                             <th>Action</th>
                        </tr>
                        {{!!$i = 0}}
                        @foreach($c as $v)
<tr>
                          <td>{{++$i}}</td>
                             <td></td>
                           <td></td>
                          <td>{{$v->min}}</td>
                            <td>{{$v->max}}</td>
                             <td><div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{url('edit_course_unit',$v->id)}}">Edit</a></li>
    
  </ul>
</div></td>
                        </tr>
                        @endforeach
                          
                        </table>



                        @endif
                        </div>
                        </div>
                        </div>
                        </div>
@endsection  


                      