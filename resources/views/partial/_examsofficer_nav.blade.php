<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
       @inject('r','App\R')
         <?php $dept= $r->get_departmetname(Auth::user()->department_id) ?>
           <p class="navbar-brand" style="color:#fff;">DEPARTMENT OF <strong >{{ $dept}}</strong></p>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        @if (!Auth::guest())

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  {{ Auth::user()->name }} <b class="caret"></b></a>
            <ul class="dropdown-menu">

                <li class="divider"></li>
                 <li>
                 <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
             
            </ul>
        </li>
        @endif
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
         @inject('r','App\R')

  <?php $result= $r->getrolename(Auth::user()->id) ?>
  @if($result =="examsofficer")
 <li class="active">
                <a href="{{url('Deskofficer')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
          
             

  <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo5"><i class="fa fa-fw fa-edit"></i>Result<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo5" class="collapse">
                   <li>
                        <a href="{{url('examsofficer')}}">Enter result</a>
                    </li>
                    <li>
                        <a href="{{url('v_result')}}">View  result</a>
                    </li>
                </ul>
            </li>
  @elseif($result =="lecturer")

   <li class="active">
                <a href="{{url('lecturer')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
          
             

  <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo5"><i class="fa fa-fw fa-edit"></i>Result<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo5" class="collapse">
                     <li>
                        <a href="{{url('lecturer')}}">Enter result</a>
                    </li>
                    <li>
                        <a href="{{url('v_result')}}">View result</a>
                    </li>
                </ul>
            </li>

      @elseif($result =="pds")

   <li class="active">
                <a href="{{url('pds')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
          
   <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo5"><i class="fa fa-fw fa-edit"></i>Student<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo5" class="collapse">
                    <li>
                        <a href="{{url('pds_student')}}">View Student</a>
                    </li>
                    <li>
                        <a href="{{url('pds_registered')}}">View Registred</a>
                    </li>
                </ul>
            </li>          

  <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo6"><i class="fa fa-fw fa-edit"></i>Result<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo6" class="collapse">
                    <li>
                        <a href="{{url('pds_enter_result')}}">Enter result</a>
                    </li>
                    <li>
                        <a href="{{url('pds_view_result')}}">View result by semesters</a>
                    </li>
                     <li>
                        <a href="{{url('pds_view_course_result')}}">View result by course</a>
                    </li>
                    <li>
                        <a href="{{url('pds_view_final_result')}}">View Final result</a>
                    </li>
                </ul>
            </li>

  @endif        



           
            
         
          
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>