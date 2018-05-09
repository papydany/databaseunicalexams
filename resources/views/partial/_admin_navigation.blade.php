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
        @if(Auth::user()->programme_id == 0 && Auth::user()->department_id == 0)
        <a class="navbar-brand" href="{{url('/admin')}}"><img id="logo" src="{{asset('logo.png')}}" alt="Logo"></a>
        @elseif(Auth::user()->programme_id == 1)
<a class="navbar-brand" style="color:#fff;" href="{{url('/')}}"><strong>PDS</strong></a>
        @else

        <?php $dept= $r->get_departmetname(Auth::user()->department_id) ?>
          <a class="navbar-brand" style="color:#fff;" href="{{url('/Deskofficer')}}"><strong>{{ $dept}}</strong></a>
          @endif
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
                                    </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    
                                            
                                        </form>
                                
             
            </ul>
        </li>
        @endif
    </ul>
    
       

  <?php $result= $r->getrolename(Auth::user()->id) ?>
  

    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
             <li class="active">
                <a href="{{url('/')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
@if($result =="admin" || $result =="support")
           
             <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-fw fa-bar-chart-o"></i> FACULTY<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo1" class="collapse">
                  <li>
                        <a href="{{url('new_faculty')}}">New Faculty</a>
                    </li>
                    <li>
                        <a href="{{url('view_faculty')}}">View Faculty</a>
                    </li>
                   
                </ul>
            </li>
                <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo2"><i class="fa fa-fw fa-table"></i>Department<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo2" class="collapse">
                    <li>
                        <a href="{{url('new_department')}}">New Department</a>
                    </li>
                    <li>
                        <a href="{{url('view_department')}}">View Department</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo3"><i class="fa fa-fw fa-edit"></i>Programme<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo3" class="collapse">
                    <li>
                        <a href="{{url('new_programme')}}">New Programme </a>
                    </li>
                    <li>
                        <a href="{{url('view_programme')}}">View Programme</a>
                    </li>
                </ul>
            </li>

             <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo4"><i class="fa fa-fw fa-edit"></i>Field Of Study<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo4" class="collapse">
                    <li>
                        <a href="{{url('new_fos')}}">New FOS </a>
                    </li>
                    <li>
                        <a href="{{url('view_fos')}}">View FOS</a>
                    </li>

                    <li>
                        <a href="{{url('assign_fos')}}">Assign FOS</a>
                    </li>
                </ul>
            </li>
             

  <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo5"><i class="fa fa-fw fa-edit"></i>Desk Officer<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo5" class="collapse">
                    <li>
                        <a href="{{url('new_desk_officer')}}">New Desk Officer</a>
                    </li>
                    <li>
                        <a href="{{url('view_desk_officer')}}">View Desk Officer</a>
                    </li>
                </ul>
            </li>
            
         <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo6"><i class="fa fa-fw fa-edit"></i>PDS<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo6" class="collapse">
                    <li>
                        <a href="{{url('pds_new_desk_officer')}}">New Desk Officer</a>
                    </li>
                    <li>
                        <a href="{{url('pds_view_desk_officer')}}">View Desk Officer</a>
                    </li>
                   <!--  <li>
                        <a href="{{url('pds_create_course')}}">New course Science</a>
                    </li>-->
                    <li>
                        <a href="{{url('pds_view_course')}}">View course Science</a>
                    </li>
                    <!--   <li>
                        <a href="{{url('pds_create_course')}}">New course Modern language</a>
                    </li>-->
                    <li>
                        <a href="{{url('modern_view_course')}}">View course Modern language</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo7"><i class="fa fa-fw fa-edit"></i>Set Course Unit<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo7" class="collapse">
                    <li>
                        <a href="{{url('create_course_unit')}}">Create</a>
                    </li>
                    <li>
                        <a href="{{url('view_course_unit')}}">View </a>
                    </li>
                     
                    
                </ul>
            </li>
<li>
                        <a href="{{url('adminreg_course')}}">View Registered Courses</a>
                    </li>
   


             <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo12"><i class="fa fa-fw fa-bar-chart-o"></i> PIN<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo12" class="collapse">
                  @if($result =="support")  
                  <li>
                        <a href="{{url('create_pin')}}">Create Pin</a>
                    </li>
                     <li>
                        <a href="{{url('export_pin')}}">Export Pin</a>
                    </li>
                     <li>
                        <a href="{{url('view_unused_pin')}}">View Unused Pin</a>
                    </li>
                     <li>
                        <a href="{{url('convert_pin')}}">Convert Pin</a>
                    </li>
                    @endif 
                   
                    <li>
                        <a href="{{url('view_used_pin')}}">View Used Pin</a>
                    </li>
                    
                </ul>
            </li>
             
                       
@elseif($result =="Deskofficer")
 
             <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-fw fa-bar-chart-o"></i> Lecturer<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo1" class="collapse">
                  <li>
                        <a href="{{url('new_lecturer')}}">New Lecturer</a>
                    </li>
                    <li>
                        <a href="{{url('view_lecturer')}}">View Lecturer</a>
                    </li>
                   <li>
                        <a href="{{url('print_lecturer')}}" target="_blank">Print Lecturer</a>
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
                        <a href="{{url('view_register_course')}}">View Registered Courses</a>
                    </li>
                    <li>
                        <a href="{{url('delete_register_course')}}">Delete Registered Courses</a>
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
                        <a href="{{url('view_assign_course')}}">View Assigned Courses</a>
                    </li>
                     <li>
                        <a href="{{url('print_assign_course')}}">Print Assigned Courses</a>
                    </li>

                    <li>
                        <a href="{{url('assign_course_other')}}">Assign Courses(Other Lecturer)</a>
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
                        <a href="{{url('register_student')}}">Registered Student</a>
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
                        <a href="{{url('view_result')}}">View result</a>
                    </li>
                     <li>
                        <a href="{{url('delete_result')}}">Delete result</a>
                    </li>
                </ul>
            </li>
            

  <li>
                <a href="{{url('report')}}"><i class="fa fa-fw fa-edit"></i>Report</a>
               
            </li>

@elseif($result =="examsofficer")

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
            <li>
                        <a href="{{url('r_student')}}">Registered Student</a>
                    </li>
    <li>
                <a href="{{url('report')}}"><i class="fa fa-fw fa-edit"></i>Report</a>
               
            </li>                
@elseif($result =="lecturer")
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
             <li>
                        <a href="{{url('r_student')}}">Registered Student</a>
                    </li>
@elseif($result =="science")
<li>
<a href="{{url('pds_student')}}">View Student</a>
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

@elseif($result =="modern_language")

<li>
<a href="{{url('pds_student')}}">View Student</a>
</li>
<li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo6"><i class="fa fa-fw fa-edit"></i>Result<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo6" class="collapse">
                    <li>
                        <a href="{{url('pds_enter_result')}}">Enter result</a>
                    </li>
                    <li>
                        <a href="{{url('pds_view_result')}}">View result</a>
                    </li>
                     
                </ul>
            </li>

            @endif
             <li>
                <a href="{{url('changepassword')}}"><i class="fa fa-fw fa-edit"></i>Change Password<i class="fa fa-fw fa-caret-down"></i></a>
                </li>
 <li>
                                              <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        </li>
               
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                           
                                        </form>
                                    





    <!--===============================================-->
          
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>