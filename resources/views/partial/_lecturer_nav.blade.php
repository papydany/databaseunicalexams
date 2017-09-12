<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{url('/')}}">HOME</a>
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
            <li class="active">
                <a href="{{url('Deskofficer')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
             <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-fw fa-bar-chart-o"></i> Lecturer<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo1" class="collapse">
                  <li>
                        <a href="{{url('new_lecturer')}}">New Lecturer</a>
                    </li>
                    <li>
                        <a href="{{url('view_lecturer')}}">View Lecturer</a>
                    </li>
                   
                </ul>
            </li>
                <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo2"><i class="fa fa-fw fa-table"></i>Courses<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo2" class="collapse">
                    <li>
                        <a href="{{url('new_course')}}">New Courses</a>
                    </li>
                    <li>
                        <a href="{{url('view_course')}}">View Courses</a>
                    </li>
                   
                    <li>
                        <a href="{{url('register_course')}}">Register Courses</a>
                    </li>
                    <li>
                        <a href="{{url('view_register_course')}}">View Register Courses</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo3"><i class="fa fa-fw fa-edit"></i>Assign Courses<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo3" class="collapse">
                   <li>
                        <a href="{{url('assign_course')}}">Assign Courses</a>
                    </li>
                    <li>
                        <a href="{{url('view_assign_course')}}">View Assign Courses</a>
                    </li>
                </ul>
            </li>

             <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo4"><i class="fa fa-fw fa-edit"></i>Student<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo4" class="collapse">
                    <li>
                        <a href="{{url('view_student')}}">Veiw Student </a>
                    </li>
                    <li>
                        <a href="{{url('register_student')}}">Register Student</a>
                    </li>

                   
                </ul>
            </li>
             

  <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo5"><i class="fa fa-fw fa-edit"></i>Result<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo5" class="collapse">
                    <li>
                        <a href="{{url('e_result')}}">Enter result</a>
                    </li>
                    <li>
                        <a href="{{url('v_result')}}">View result</a>
                    </li>
                </ul>
            </li>
            
         
          
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>