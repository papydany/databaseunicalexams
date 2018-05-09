<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Auth;
use App\Role;
use App\Faculty;
use App\Department;
use App\Programme;
use App\Fos;
use App\Level;
use App\Semester;
use App\StudentResult;
use App\StudentReg;
use DB;
use App\User;
use App\Course;
use App\RegisterCourse;
use App\AssignCourse;
use App\CourseReg;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\MyTrait;
class DeskController extends Controller
{
    //
    use MyTrait;
Const LECTURER = 5;
Const FIRST = 1;
Const SECOND = 2;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {
     
  return view('desk.index');
    }

   //======================================== Lecturer =====================================
    
    public function new_lecturer()
    {

      return view('desk.new_lecturer');
    }

  //======================================== post lecturer =====================================
    function post_new_lecturer(Request $request)
    {
    	  $variable = $request->input('username');
    	foreach ($variable as $key => $value) {
    	if(!empty($value)) {
    	$clean_list[$value] =array('title'=>$request->title[$key],'name'=>$request->name[$key],'password'=>$request->password[$key],'username'=>$value);
    	}
    	}

 foreach($clean_list as $kk=>$vv ){
$username[] = $vv['username'];
}

$check =User::whereIn('username',$username)->get();
if(count($check) > 0)
{
foreach ($check as $key => $value) {
	unset($clean_list[$value->username]);
}
		
}

	
	if(count($clean_list) != 0)
	{
		
 foreach($clean_list as $k=>$v ){
	
$user =DB::table('users')->insertGetId(['title'=> $clean_list[$k]['title'],'name' => $clean_list[$k]['name'], 'username' =>$clean_list[$k]['username'],'password'=>bcrypt($clean_list[$k]['password']),'plain_password'=>$clean_list[$k]['password'],'faculty_id'=>Auth::user()->faculty_id,'department_id'=>Auth::user()->department_id,'programme_id'=>0,'fos_id'=>0,'edit_right'=>0]);

$role =Role::find(5);
$user_role =DB::table('user_roles')->insert(['user_id' => $user, 'role_id' => $role->id]);

	}
	Session::flash('success',"SUCCESSFULL.");
return redirect()->action('DeskController@new_lecturer');
}


}

public function view_lecturer()
{
	  $user = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id',self::LECTURER)
            ->where([['users.faculty_id',Auth::user()->faculty_id],['users.department_id',Auth::user()->department_id]])
            ->orderBy('users.name','ASC')
            ->select('users.*')
            ->paginate(50);
	
	return view('desk.view_lecturer')->withL($user);
}
//=============================== print lecturer ===================================
public function print_lecturer()
{
      $user = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id',self::LECTURER)
            ->where([['users.faculty_id',Auth::user()->faculty_id],['users.department_id',Auth::user()->department_id]])
            ->orderBy('users.name','ASC')
            ->select('users.*')
            ->get();
    
    return view('desk.print_lecturer')->withL($user);
}
//---------------------------Edit Lecturer ---------------------------------------------------

public function edit_lecturer($id)
{
$lecturer = User::find($id);

    return view('desk.edit_lecturer')->withL($lecturer);
}

public function post_edit_lecturer(Request $request,$id)
{

$lecturer = User::find($id);
$lecturer->title =$request->title;
$lecturer->name =$request->name;

$lecturer->password =bcrypt($request->password);
$lecturer->plain_password =$request->password;
$lecturer->save();
   return redirect()->action('DeskController@view_lecturer');
}
//-------------------------------------new courses ----------------------------------------------
public function new_course()
{
	$level =Level::where('programme_id',Auth::user()->programme_id)->get();
	$semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
	return view('desk.new_course')->withL($level)->withS($semester);
}
//-------------------------------------new courses ----------------------------------------------
    function post_new_course(Request $request)
    {
    	$this->validate($request,array('level'=>'required','semester'=>'required',));
    	$semester = $request->input('semester');
         $level =$request->input('level');
    	$month =$request->input('month');
    	  $variable = $request->input('course_code');
    	  $title = $request->input('course_title');
    	  $unit = $request->input('course_unit');
    	  $status = $request->input('status');
    if($variable == null)
{
	Session::flash('warning',"course Code is empty");
    return back();
}
    	foreach ($variable as $key => $value) {
    	if(!empty($value)) {
    		$cc =strtoupper(str_ireplace(" ","",$value));

    	$clean_list[$cc] =array('course_title'=>$title[$key],'course_unit'=>$unit[$key],'course_code'=>$cc ,'status'=>$status[$key]);
    	}
    	}

 foreach($clean_list as $kk=>$vv ){
$course_code[] = $vv['course_code'];

}

$check =Course::whereIn('course_code',$course_code)
->where([['department_id',Auth::user()->department_id],['level',$level],['month',$month],['semester',$semester]])->get();
if(count($check) > 0)
{
foreach ($check as $key => $value) {
	unset($clean_list[$value->course_code]);
}
		
}
	
	if(count($clean_list) != 0)
	{
		
 foreach($clean_list as $k=>$v ){
	
$data[] =['course_title' => $clean_list[$k]['course_title'], 'course_code' =>$clean_list[$k]['course_code'],'course_unit'=>$clean_list[$k]['course_unit'],'status'=>$clean_list[$k]['status'],'level'=>$level,'department_id'=>Auth::user()->department_id,'semester'=>$semester];

}
DB::table('courses')->insert($data);
	Session::flash('success',"SUCCESSFULL.");
return redirect()->action('DeskController@new_course');
}


}
//-------------------------------------view courses ----------------------------------------------

public function view_course()
{
	$level =Level::where('programme_id',Auth::user()->programme_id)->get();
	$semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
	return view('desk.view_course')->withL($level)->withS($semester);
}

public function get_view_course(request $request)
{
	$l =Level::where('programme_id',Auth::user()->programme_id)->get();
	$this->validate($request,array('level'=>'required',));
    	
    	$level =$request->level;
        $month =$request->month;
        if($month != null)
        {
     $course =Course::where([['department_id',Auth::user()->department_id],['level',$level],['month',$month]])
        ->orderBy('semester','ASC')->orderBy('status','ASC')->orderBy('course_code','ASC')->get();
        }else{
          $course =Course::where([['department_id',Auth::user()->department_id],['level',$level]])
        ->orderBy('semester','ASC')->orderBy('status','ASC')->orderBy('course_code','ASC')->get();  
        }
    	
    	return view('desk.view_course')->withCourse($course)->withL($l);
}
//---------------------------Edit Lecturer ---------------------------------------------------

public function edit_course($id)
{
    if(Auth::user()->edit_right == 0)
    {
        Session::flash('danger',"You need edit right to edit course. contact the system admin.");
   return redirect()->action('DeskController@view_course');
    }
$course = Course::find($id);

    return view('desk.edit_course')->withC($course);
}

public function post_edit_course(Request $request,$id)
{

$c = Course::find($id);
$c->course_title =strtoupper($request->course_title);
$c->course_code =strtoupper($request->course_code);
$c->course_unit =$request->course_unit;
$c->status =$request->status;
$c->save();
Session::flash('success',"SUCCESSFULL.");
   return redirect()->action('DeskController@view_course');
}

//----------------------- delete course ------------------------------------------------------
public function delete_course($id)
{
    if(Auth::user()->edit_right == 0)
    {
        Session::flash('danger',"You need edit right to delete course. contact the system admin.");
   return redirect()->action('DeskController@view_course');
    }
$course = Course::destroy($id);
 Session::flash('success',"SUCCESSFULL.");
   return redirect()->action('DeskController@view_course');
}

public function delete_multiple_course(Request $request)
{
     if(Auth::user()->edit_right == 0)
    {
        Session::flash('danger',"You need edit right to delete course. contact the system admin.");
   return redirect()->action('DeskController@view_course');
    }
     $variable = $request->input('id');
     if($variable == null)
{
    return back();
}

$course = Course::destroy($variable);
 Session::flash('success',"SUCCESSFULL.");
   return redirect()->action('DeskController@view_course');
}
//------------------------------------------ register course --------------------------------------------

public function register_course()
{
	$level =Level::where('programme_id',Auth::user()->programme_id)->get();
	$semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
	return view('desk.register_course')->withL($level)->withS($semester);
}

//------------------------------------------------------------------------------
public function get_register_course(request $request)
{
	$l =Level::where('programme_id',Auth::user()->programme_id)->get();
	$s=Semester::where('programme_id',Auth::user()->programme_id)->get();
	$this->validate($request,array('level'=>'required','semester'=>'required'));
    	$semester =$request->semester;
    	$level =$request->level;
        $month =$request->month;
            // get fos
        $fos=$this->get_fos();
        if($month != null)
        {
$course =Course::where([['department_id',Auth::user()->department_id],['level',$level],['semester',$semester],['month',$month]])
        ->orderBy('course_code','ASC')->get();
        return view('desk.register_course')->withCourse($course)->withL($l)->withS($s)->withF($fos)->withM($month);
        }
        else{
          $course =Course::where([['department_id',Auth::user()->department_id],['level',$level],['semester',$semester]])
        ->orderBy('course_code','ASC')->get(); 
         return view('desk.register_course')->withCourse($course)->withL($l)->withS($s)->withF($fos);
        }
    
}
//-------------------------------------------------------------------------------------------------
public function post_register_course(Request $request)
{
	$this->validate($request,array('fos'=>'required','session_id'=>'required'));
	$session =$request->input('session_id');
    $month =$request->input('month');
    	$fos =$request->input('fos');
    	$p =Auth::user()->programme_id;
    	$d =Auth::user()->department_id;
    	$f =Auth::user()->faculty_id;
	 $variable = $request->input('id');
	 if($variable == null)
{
    return back();
}
$course =Course::whereIn('id',$variable)->get();
foreach ($course as $key => $value) {
	$data[$value->id] =['course_id'=>$value->id,'programme_id'=>$p,'department_id'=>$d,'faculty_id'=>$f,'fos_id'=>$fos,'level_id'=>$value->level,'semester_id'=>$value->semester,'reg_course_title'=>$value->course_title,'reg_course_code'=>$value->course_code,'reg_course_unit'=>$value->course_unit,'reg_course_status'=>$value->status,'session'=>$session,'month'=>$month];

    $check_data[] =$value->id;
    $check_level[] =$value->level;
}
// check if course exist already on the register course table
$check =RegisterCourse::whereIn('course_id',$check_data)
->whereIn('level_id',$check_level)
->where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos],['session',$session]])
->get();
if(count($check) > 0)
{
  foreach ($check as $key => $value) {

    unset($data[$value->course_id]);
}
}

DB::table('register_courses')->insert($data);
Session::flash('success',"SUCCESSFULL.");
return redirect()->action('DeskController@register_course');
}
//-------------------------------view register --------------------------------------
function view_register_course()
{
    $level =Level::where('programme_id',Auth::user()->programme_id)->get();
   // $semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
    // get fos
$fos =$this->get_fos();
    return view('desk.view_register_course')->withL($level)->withF($fos);
}
//----------------------------------------------------------------------------------------------------
function post_view_register_course(request $request)
{
     $level =Level::where('programme_id',Auth::user()->programme_id)->get();
    $semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
    // get fos
$fos_id =$this->get_fos();
   
$this->validate($request,array('fos'=>'required','session_id'=>'required','level'=>'required'));
$session =$request->session_id;
        $fos =$request->fos;

        $l =$request->level;
        $p =Auth::user()->programme_id;
        $d =Auth::user()->department_id;
        $f =Auth::user()->faculty_id;

$register_course =RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos],['level_id',$l],['session',$session]])->orderBy('semester_id','ASC')->orderBy('reg_course_status','ASC')->get();
return view('desk.display_register_course')->withL($level)->withS($semester)->withF($fos_id)->withR($register_course)->withG_s($session)->withG_l($l)->withFos($fos);
}
//---------------------------------deleted registered course ----------------------------------------------
function delete_register_course()
{
    $level =Level::where('programme_id',Auth::user()->programme_id)->get();
   // $semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
    // get fos
$fos =$this->get_fos();
    return view('desk.delete_register_course')->withL($level)->withF($fos);
}

//----------------------------------------------------------------------------------------------------
function post_delete_register_course(request $request)
{
     $level =Level::where('programme_id',Auth::user()->programme_id)->get();
    $semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
    // get fos
$fos_id =$this->get_fos();
   
$this->validate($request,array('fos'=>'required','session_id'=>'required','level'=>'required'));
$session =$request->session_id;
        $fos =$request->fos;

        $l =$request->level;
        $p =Auth::user()->programme_id;
        $d =Auth::user()->department_id;
        $f =Auth::user()->faculty_id;

$register_course =RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos],['level_id',$l],['session',$session]])->orderBy('semester_id','ASC')->orderBy('reg_course_status','ASC')->get();
return view('desk.delete_register_course')->withL($level)->withS($semester)->withF($fos_id)->withR($register_course)->withG_s($session)->withG_l($l)->withFos($fos);
}
//----------------------------------------assign courses ---------------------------------------------------
public function assign_course()
{
  $level =$this->get_level();
 $semester =$this->get_semester();
    // get fos
$fos =$this->get_fos();
    return view('desk.assign_course')->withL($level)->withS($semester)->withF($fos);

  
}
function delete_desk_course($id,$s)
{

  $check = CourseReg::where([['registercourse_id',$id],['session',$s]])->first();
if(count($check) > 0)
{
  Session::flash('warning',"The courses selected has been registered by students.so u can not delete it. contact admin");

  return back();
}
$reg =RegisterCourse::destroy($id);
$assign_course =AssignCourse::where('registercourse_id',$id)->first();
if(count($assign_course) > 0 )
{
  $assign_course->delete();
}
Session::flash('success',"successfull.");
return back();
}

function delete_desk_multiple_course(Request $request)
{
       $variable = $request->input('id');
       $session = $request->input('session');
     if($variable == null)
{
    return back();
}
$check = CourseReg::whereIn('registercourse_id',$variable)->where('session',$session)->get();
if(count($check) > 0)
{
  Session::flash('warning',"Some of the courses selected has been registered by students.so u can not do mass deleting .delete one after the other.");

  return back();
}
$reg =RegisterCourse::destroy($variable);

$assign_course =AssignCourse::whereIn('registercourse_id',$variable)->get();


if(count($assign_course) > 0 )
{
 foreach ($assign_course as $key => $value) {
    $data [] =$value->id;
  }

 AssignCourse::destroy($data);
}
Session::flash('success',"successfull.");
return back();
}
//--------------------------------------------------------------------------------------------------------
function get_assign_course(request $request)
{
    $this->validate($request,array('fos'=>'required','session_id'=>'required','level'=>'required','semester'=>'required'));
   $semester_id =$request->semester;
    $session =$request->session_id;
    $fos_id =$request->fos;
    $l =$request->level;
    
    $level =$this->get_level();
    $semester =$this->get_semester();
    $fos =$this->get_fos();
    $p =$this->p();
    $f =$this->f();
    $d =$this->d();
     $lecturer = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id',self::LECTURER)
            ->where([['users.faculty_id',$f],['users.department_id',$d]])
            ->orderBy('users.name','ASC')
            ->select('users.*')
            ->get(); 
            //dd($lecturer);
$assign_course =AssignCourse::where([['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->select('registercourse_id')->get();
if(count($assign_course) > 0)
{
    foreach ($assign_course as $key => $value) {
        $register_course_id [] =$value->registercourse_id;
    }

   $register_course =RegisterCourse::whereNotIn('id',$register_course_id)
   ->where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->get();
  
}else{
 $register_course =RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->get();
}



  return view('desk.assign_course')->withL($level)->withS($semester)->withF($fos)->withRs($register_course)->withLec($lecturer)->withG_s($session)->withG_l($l);           
}

//--------------------------assign courses other-----------------------------------
public function assign_course_other()
{
  $level =$this->get_level();
 $semester =$this->get_semester();
    // get fos
$fos =$this->get_fos();
    return view('desk.assign_courses_other')->withL($level)->withS($semester)->withF($fos);

  
}

public function post_assign_course_other(Request $request)
{
  $this->validate($request,array('fos'=>'required','session_id'=>'required','level'=>'required','semester'=>'required'));
   $semester_id =$request->semester;
    $session =$request->session_id;
    $fos_id =$request->fos;
    $l =$request->level;
    
    $level =$this->get_level();
    $semester =$this->get_semester();
    $fos =$this->get_fos();
    $p =$this->p();
    $f =$this->f();
    $d =$this->d();
$department =Department::orderBy('department_name','ASC')->get();

 
$assign_course =AssignCourse::where([['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->select('registercourse_id')->get();
if(count($assign_course) > 0)
{
    foreach ($assign_course as $key => $value) {
        $register_course_id [] =$value->registercourse_id;
    }

   $register_course =RegisterCourse::whereNotIn('id',$register_course_id)
   ->where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->get();
  
}else{
 $register_course =RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->get();
}



  return view('desk.assign_courses_other')->withL($level)->withS($semester)->withF($fos)->withRs($register_course)->withDepart($department)->withG_s($session)->withG_l($l);           
}

//-------------------------------------------------------------------------------------
public function post_assign_course_o(Request $request)
{
    $id = $request->input('id');
$this->validate($request,array('Lecturer'=>'required',));
if($id == null)
{
    return back();
}
$lecturer =$request->input('Lecturer');
 $f =$this->f();
$d =$this->d();
// status 1 mean fos is assign and 0 mean not assigned
foreach ($id as $key => $value) {
  $v[] = ['registercourse_id'=>$value,'user_id'=>$lecturer,'department_id'=>$d,'faculty_id'=>$f,'fos_id'=>$request->input('fos_id')[$key],'level_id'=>$request->input('level')[$key],'session'=>$request->input('session')[$key],'semester_id'=>$request->input('semester_id')[$key]];

}

DB::table('assign_courses')->insert($v);
Session::flash('success',"SUCCESSFULL.");
return redirect()->action('DeskController@assign_course_other');

}

//-------------------------------------------------------------------------------------
public function post_assign_course(Request $request)
{
    $id = $request->input('id');
$this->validate($request,array('lecturer'=>'required',));
if($id == null)
{
    return back();
}
$lecturer =$request->input('lecturer');
 $f =$this->f();
$d =$this->d();
// status 1 mean fos is assign and 0 mean not assigned
foreach ($id as $key => $value) {
  $v[] = ['registercourse_id'=>$value,'user_id'=>$lecturer,'department_id'=>$d,'faculty_id'=>$f,'fos_id'=>$request->input('fos_id')[$key],'level_id'=>$request->input('level')[$key],'session'=>$request->input('session')[$key],'semester_id'=>$request->input('semester_id')[$key]];

}

DB::table('assign_courses')->insert($v);
Session::flash('success',"SUCCESSFULL.");
return redirect()->action('DeskController@assign_course');

}
//------------------------------------------------------------------------------------------------------
public function view_assign_course()
{
     $level =$this->get_level();
    $semester =$this->get_semester();
    $fos =$this->get_fos(); 
    return view('desk.view_assign_course')->withL($level)->withS($semester)->withF($fos);
}

public function get_view_assign_course(request $request)
{
$this->validate($request,array('fos'=>'required','session_id'=>'required','level'=>'required','semester'=>'required'));
   
   $semester_id =$request->semester;
    $session =$request->session_id;
    $fos_id =$request->fos;
    $l =$request->level;
    
    $level =$this->get_level();
    $semester =$this->get_semester();
    $fos =$this->get_fos();
    $p =$this->p();
    $f =$this->f();
    $d =$this->d();

    $assign_course =AssignCourse::where([['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->get();

    return view('desk.view_assign_course')->withL($level)->withS($semester)->withF($fos)->withAc($assign_course)->withG_s($session)->withG_l($l)->withS_id($semester_id); 
}
public function remove_assign_course($id)
{
    $r =AssignCourse::find($id);
    $r->delete();
    return redirect()->action('DeskController@view_assign_course');
}
public function remove_multiple_assign_course(Request $request)
{
  $id =$request->id;
 
    $r =AssignCourse::destroy($id);
   return redirect()->action('DeskController@view_assign_course');
}
//----------------------------------print assign course------------------------------------------------
public function print_assign_course()
{
     $level =$this->get_level();
    $semester =$this->get_semester();
    $fos =$this->get_fos(); 
    return view('desk.print_assign_courses')->withL($level)->withS($semester)->withF($fos);
}
//=================================print post assign =====================================
public function get_print_assign_course(request $request)
{
$this->validate($request,array('fos'=>'required','session_id'=>'required','level'=>'required','semester'=>'required'));
   
   $semester_id =$request->semester;
    $session =$request->session_id;
    $fos_id =$request->fos;
    $l =$request->level;
    $p =$this->p();
    $f =$this->f();
    $d =$this->d();

    $assign_course =AssignCourse::where([['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->get();

    return view('desk.display_assign_course')->withAc($assign_course)->withG_s($session)->withG_l($l)->withS_id($semester_id)->withFos($fos_id); 
}


    //======================================== student =====================================

    public function view_student()
    {
        $fos = $this->get_fos();
        return view('desk.view_student')->withF($fos);
    }
    // ===========================post view student ==========================================
    public function post_view_student(Request $request)
    {
        $fos = $this->get_fos();
        $fos_id = $request->input('fos_id');
        $session =$request->input('session_id');
        $entry_month =$request->input('entry_month');
        $p =$this->p();
        $f =$this->f();
        $d =$this->d();
       $user = DB::connection('mysql2')->table('users')->where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['entry_year',$session],['entry_month',$entry_month]])->get();

        return view('desk.view_student')->withF($fos)->withU($user)->withS($session);
    }

    //======================================== register student =====================================

    public function register_student()
    {
        $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
        return view('desk.register_student')->withF($fos)->withL($l)->withS($semester);
    }
    // ===========================post view student ==========================================
    public function post_register_student(Request $request)
    {
        $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
        $semester_id =$request->input('semester_id');
        $season =$request->input('season');
        $fos_id = $request->input('fos_id');
        $l_id =$request->input('level');
        $session =$request->input('session_id');
        $p =$this->p();
        $f =$this->f();
        $d =$this->d();

        $user = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'student_regs.user_id', '=', 'users.id')
            ->where('users.fos_id',$fos_id)
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['student_regs.season',$season],
                ['student_regs.session',$session],['student_regs.semester',$semester_id],['student_regs.level_id',$l_id]])
            ->select('student_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.fos_id')
            ->paginate(50);
        return view('desk.register_student')->withU($user)->withSs($session)->withF($fos)->withL($l)->withS($semester)
            ->withL_id($l_id)->withS_id($semester_id) ;
    }
    //================================= Entering Result =====================================================
    public function enter_result(Request $request)
    {
        $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
        $fos_id = $request->input('fos_id');
        $semester_id = $request->input('semester_id');
        $season = $request->input('season');
        $l_id = $request->input('level_id');
        $session = $request->input('session_id');
        $user_id = $request->input('user_id');
        $mat_no = $request->input('matric_number');
        $variable = $request->input('grade');
        $flag = "Sessional";
        $date = date("Y/m/d H:i:s");
     
        foreach ($variable as $k => $v) {
            $xc = explode('~', $k);
            $v = strtoupper($v);

            if (!in_array($v, array('A', 'B', 'C', 'D', 'E', 'F'))) {
                continue;
            }

            if (!empty($v)) {

                $size = count($xc);
                if (4 == $size) {
                    //UPDATE EXISTING RESULT
                    $result_id = $xc[0];
                    $coursereg_id = $xc[1];
                    $course_id = $xc[2];
                    $cu = $xc[3];

                    $x = $this->mm($v, $cu);

                    $update = StudentResult::find($result_id);
                    $update->grade = $v;
                    $update->cp = $x['cp'];
                    $update->save();


                } else {
                    //INSERT FRESH RESULT
                    $coursereg_id = $xc[0];
                    $course_id = $xc[1];
                    $cu = $xc[2];
                    $x = $this->mm($v, $cu);

                    $check_result = StudentResult::where([['user_id', $user_id], ['level_id', $l_id], ['session', $session], ['course_id', $course_id], ['coursereg_id', $coursereg_id]])->first();
                    if (count($check_result) == 0) {
                        $insert_data[] = ['user_id'=>$user_id,'matric_number'=>$mat_no,'course_id'=>$course_id,'coursereg_id'=>$coursereg_id,'grade'=> $v,'cu'=>$cu,'cp'=>$x['cp'],'level_id'=>$l_id,
                            'session'=>$session,'semester'=>$semester_id,'status'=>0,'season'=>$season,'flag'=>$flag,'examofficer'=>Auth::user()->id,'post_date'=>$date,'approved'=>0];
                    }
                  
                }

            }
        }
        if(isset($insert_data))
        {
        if(count($insert_data) > 0)
        {
         DB::connection('mysql2')->table('student_results')->insert($insert_data);
        }
    }
        Session::flash('success',"SUCCESSFULL.");
        return redirect()->action('DeskController@get_register_student',['fos_id'=>$fos_id,'l_id'=>$l_id,'semester_id'=>$semester_id,'session'=>$session,'season'=>$season]);
    }
 //================================= get Register Student=====================================================
    public function get_register_student($fos_id =null,$l_id=null,$semester_id=null,$session=null,$season=null)
    {
     if(isset($fos_id) && isset($l_id) && isset($semester_id) && isset($session) && isset($season))
     {
        $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
        $p =$this->p();
        $f =$this->f();
        $d =$this->d();

         $user = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'student_regs.user_id', '=', 'users.id')
            ->where('users.fos_id',$fos_id)
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['student_regs.season',$season],
                ['student_regs.session',$session],['student_regs.semester',$semester_id],['student_regs.level_id',$l_id]])
            ->select('student_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.fos_id')
            ->paginate(50);
        return view('desk.register_student')->withU($user)->withSs($session)->withF($fos)->withL($l)->withS($semester)
            ->withL_id($l_id)->withS_id($semester_id) ;

     }
    }
// ======================================more enter result =============================================
    public function more_result(Request $request)
    {
        $variable = $request->input('id');
        $user = DB::connection('mysql2')->table('users')
        ->join('student_regs', 'student_regs.user_id', '=', 'users.id')
        ->whereIn('student_regs.id',$variable)
        ->select('student_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.fos_id')
        ->get();
        return view('desk.more_result')->withU($user);
    }

 // ======================================more enter result =============================================
    public function post_more_result(Request $request)
    {
        $id = $request->input('id');
        $fos_id = $request->input('fos_id');
        $variable = $request->input('grade');
        $flag = "Sessional";
        $date = date("Y/m/d H:i:s");
     
        foreach ($variable as $k => $v) {
            $xc = explode('~', $k);
            $v = strtoupper($v);

            if (!in_array($v, array('A', 'B', 'C', 'D', 'E', 'F'))) {
                continue;
            }

            if (!empty($v)) {

                $size = count($xc);
                if (11 == $size) {
                    //UPDATE EXISTING RESULT
                    $result_id = $xc[0];
                    $coursereg_id = $xc[1];
                    $user_id =$xc[2];
                    $l_id=$xc[3];
                    $semester_id=$xc[4];
                    $session =$xc[5];
                    $season =$xc[6];
                    $course_id = $xc[7];
                    $cu = $xc[8];
                    $mat_no=$xc[9];
                    $studentreg_id[]=$xc[10];
                    $x = $this->mm($v, $cu);

                    $update = StudentResult::find($result_id);
                    $update->grade = $v;
                    $update->cp = $x['cp'];
                    $update->save();


                } else {
                    //INSERT FRESH RESULT
                   $coursereg_id = $xc[0];
                    $user_id =$xc[1];
                    $l_id=$xc[2];
                    $semester_id=$xc[3];
                    $session =$xc[4];
                    $season =$xc[5];
                    $course_id = $xc[6];
                    $cu = $xc[7];
                    $mat_no=$xc[8];
                    $studentreg_id[]=$xc[9];
                    $x = $this->mm($v, $cu);

                    $check_result = StudentResult::where([['user_id', $user_id], ['level_id', $l_id], ['session', $session], ['course_id', $course_id], ['coursereg_id', $coursereg_id]])->first();
                    if (count($check_result) == 0) {
                        $insert_data[] = ['user_id'=>$user_id,'matric_number'=>$mat_no,'course_id'=>$course_id,'coursereg_id'=>$coursereg_id,'grade'=> $v,'cu'=>$cu,'cp'=>$x['cp'],'level_id'=>$l_id,
                            'session'=>$session,'semester'=>$semester_id,'status'=>0,'season'=>$season,'flag'=>$flag,'examofficer'=>Auth::user()->id,'post_date'=>$date,'approved'=>0];
                    }
                  
                }

            }
        }
        
        if(isset($insert_data))
        {
        if(count($insert_data) > 0)
        {
         DB::connection('mysql2')->table('student_results')->insert($insert_data);
        }
    }
        Session::flash('success',"SUCCESSFULL.");

        $user = DB::connection('mysql2')->table('users')
        ->join('student_regs', 'student_regs.user_id', '=', 'users.id')
        ->whereIn('student_regs.id',$studentreg_id)
        ->select('student_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.fos_id')
        ->get();
        return view('desk.more_result')->withU($user);
    }   
//=========================== enter result by course ===============================================
   public  function e_result()
    {  $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
return view('desk.e_result')->withF($fos)->withL($l)->withS($semester);
    }

 //================================== post result by course =============================================
  public  function e_result_next(Request $request)
    {  $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
        $fos_id =$request->input('fos');
        $l_id =$request->input('level');
        $s_id =$request->input('session');
        $semester_id =$request->input('semester');
        $rc =RegisterCourse::where([['semester_id',$semester_id],['level_id',$l_id],['fos_id',$fos_id],['session',$s_id]])->get();
     return view('desk.e_result_next')->withF($fos)->withL($l)->withS($semester)->withRc($rc)->withL_id($l_id)->withS_id($s_id)->withSm_id($semester_id);
    }  

 //================================== get student  by course =============================================
  public  function e_result_c(Request $request)
    {  
       $id =$request->input('id'); 
        $period =$request->input('period'); 
    $registercourse = RegisterCourse::find($id);

      $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where('course_regs.registercourse_id',$id)
        ->where('course_regs.period',$period)
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number')
        ->get();
  //Get current page form url e.g. &page=6
        $url ="e_result_c?id=".$id.'&period='.$period;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($user);

        //Define how many items we want to be visible in each page
        $perPage =50;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage- 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

       // return view('search', ['results' => $paginatedSearchResults]);
    
      return view('desk.e_result_c')->withU($paginatedSearchResults)->withUrl($url)->withC($registercourse);
    }  

//========================================== result insert for student percourse ==========================

    public function insert_result(Request $request)
    {
        $this->validate($request,array('id'=>'required',));
        $flag = "Sessional";
        $date = date("Y/m/d H:i:s");
            $url =$request->input('url');
        $id =$request->input('id');
$result_id="";

        foreach ($id as $key => $value) {
        $coursereg_id =$request->input('coursereg_id')[$value];
        $user_id =$request->input('user_id')[$value];
        $mat_no =$request->input('matric_number')[$value];
        $course_id =$request->input('course_id')[$value];
        $cu =$request->input('cu')[$value];
        $session=$request->input('session')[$value];
        $semester =$request->input('semester')[$value];
        $l_id =$request->input('level_id')[$value];
        $season =$request->input('season')[$value];
        $ca =$request->input('ca')[$value];
        $exam=$request->input('exams')[$value];
        $total=$request->input('total')[$value];

        $grade_value =$this->get_grade($total);
        
        $grade = $grade_value['grade'];
        $cp = $this->mm($grade, $cu);
      //  $result_id =$request->input('result_id')[$value];
        //if($request->has('result_id'.[$value])) {
       
$result_id =$request->input('result_id')[$value];

     //  }

         if(!empty($result_id))
         {
$update = StudentResult::find($result_id);
           $update->ca = $ca;
            $update->exam = $exam;
            $update->total = $total;
                    $update->grade = $grade;
                    $update->cp = $cp['cp'];
                    $update->save();
         }else{


               $check_result = StudentResult::where([['level_id', $l_id], ['session', $session], ['course_id', $course_id], ['coursereg_id', $coursereg_id]])->first();
                    if (count($check_result) == 0) {
                        $insert_data[] = ['user_id'=>$user_id,'matric_number'=>$mat_no,'course_id'=>$course_id,'coursereg_id'=>$coursereg_id,'ca'=>$ca,'exam'=>$exam,'total'=>$total,'grade'=> $grade,'cu'=>$cu,'cp'=>$cp['cp'],'level_id'=>$l_id,
                            'session'=>$session,'semester'=>$semester,'status'=>0,'season'=>$season,'flag'=>$flag,'examofficer'=>Auth::user()->id,'post_date'=>$date,'approved'=>0];
                    }


                  
         }

        }

                  if(isset($insert_data))
        {
        if(count($insert_data) > 0)
        {
         DB::connection('mysql2')->table('student_results')->insert($insert_data);
        }
    }
        Session::flash('success',"SUCCESSFULL.");
         return back();
        //return redirect($url);
    }
 
//--------------------------------------------view result --------------------------------------------------
    public function view_result()
    {
      $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester(); 
 return view('desk.view_result')->withF($fos)->withL($l)->withS($semester);
    }

//----------------------------------------------------------------------------------

    public function post_view_result(Request $request)
    {

      $fos = $this->get_fos();
        $l_id = $this->get_level();
        $semester_id = $this->get_semester(); 
           
  $this->validate($request,array('fos'=>'required','session'=>'required','level'=>'required','semester'=>'required',));
  $f_id =$request->input('fos');
  $l =$request->input('level');
  $semester =$request->input('semester');
  $session =$request->input('session');
  $d =Auth::user()->department_id;
  $f =Auth::user()->faculty_id;
  $p =Auth::user()->programme_id;
 
  $course=RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$f_id],['level_id',$l],['semester_id',$semester],['session',$session]])->orderBy('reg_course_code','ASC')->get();

  return view('desk.view_result')->withC($course)->withSm($semester)->withSi($session)->withLi($l)->withF($fos)->withL($l_id)->withS($semester_id)->withF_id($f_id);

    }    


//-----------------------------------------display result ----------------------------------------------------
 
 public function view_result_detail(Request $request)
 {
   $id =$request->input('id');
   $xc = explode('~', $id);
    $reg_id = $xc[0];
    $course_id = $xc[1];
      $course_code = $xc[2];
  $fos_id =$request->input('fos_id');
  $l =$request->input('level');
  $sm =$request->input('semester');
  $s =$request->input('session');
  $period =$request->input('period');

 $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where([['course_regs.registercourse_id',$reg_id],['level_id',$l],['semester_id',$sm],['session',$s],['course_id',$course_id],['period',$period]])
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number')
        ->get();
       
  return view('desk.view_result_detail')->withU($user)->withSm($sm)->withS($s)->withL($l)->withFos_id($fos_id)->withCourse_code($course_code);
 }

 //--------------------------------------------delete result --------------------------------------------------
    public function delete_result()
    {
      $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester(); 
 return view('desk.delete_result')->withF($fos)->withL($l)->withS($semester);
    }

//----------------------------------------------------------------------------------

    public function post_delete_result(Request $request)
    {

      $fos = $this->get_fos();
        $l_id = $this->get_level();
        $semester_id = $this->get_semester(); 
           
  $this->validate($request,array('fos'=>'required','session'=>'required','level'=>'required','semester'=>'required',));
  $f_id =$request->input('fos');
  $l =$request->input('level');
  $semester =$request->input('semester');
  $session =$request->input('session');
  $d =Auth::user()->department_id;
  $f =Auth::user()->faculty_id;
  $p =Auth::user()->programme_id;
 
  $course=RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$f_id],['level_id',$l],['semester_id',$semester],['session',$session]])->orderBy('reg_course_code','ASC')->get();

  return view('desk.delete_result')->withC($course)->withSm($semester)->withSi($session)->withLi($l)->withF($fos)->withL($l_id)->withS($semester_id)->withF_id($f_id);

    }    

function delete_desk_result($id)
{


$reg =StudentResult::destroy($id);

Session::flash('success',"successfull.");
return redirect()->action('DeskController@delete_result');
}

function delete_desk_multiple_result(Request $request)
{
 $variable = $request->input('id');
  if($variable == null)
{Session::flash('warning',"you have not select any result.");
   return redirect()->action('DeskController@delete_result');
}

$reg =StudentResult::destroy($variable);

Session::flash('success',"successfull.");
return redirect()->action('DeskController@delete_result');
}
//-----------------------------------------display result ----------------------------------------------------
 
 public function delete_result_detail(Request $request)
 {
   $id =$request->input('id');
   $xc = explode('~', $id);
    $reg_id = $xc[0];
    $course_id = $xc[1];
      $course_code = $xc[2];
  $fos_id =$request->input('fos_id');
  $l =$request->input('level');
  $sm =$request->input('semester');
  $s =$request->input('session');
  $period =$request->input('period');

 $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where([['course_regs.registercourse_id',$reg_id],['level_id',$l],['semester_id',$sm],['session',$s],['course_id',$course_id],['period',$period]])
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number')
        ->get();
       
  return view('desk.delete_result_detail')->withU($user)->withSm($sm)->withS($s)->withL($l)->withFos_id($fos_id)->withCourse_code($course_code);
 }
 //=============.=============== REPORT ==============================================================
//------------------------------ Report methods ------------------------------------------------------
 public function report()
 {
   $fos =$this->get_fos();
  return view('desk.report')->withF($fos);
 }
  public function post_report(Request $request)
 {
$d =Auth::user()->department_id;
$f =Auth::user()->faculty_id;
$p =Auth::user()->programme_id;
$user_id = Auth::user()->id;
$season ="NORMAL";
$flag ="Sessional";

$this->validate($request,array('fos'=>'required','session'=>'required','level'=>'required','result_type'=>'required',));
$regc1 ='';   
$reg2c ='';
$fos =$request->input('fos');

$s =$request->input('session');
$l =$request->input('level');
$result_type =$request->input('result_type');
$duration=$request->input('duration');

$regcourse1C =$this->getRegisteredCourses($p,$d,$f,$fos,$l,$s,1,'C');
$regcourse2C =$this->getRegisteredCourses($p,$d,$f,$fos,$l,$s,2,'C');
$users = $this->getRegisteredStudents($p,$d,$f,$fos,$l,$s);

$course_id1 = array();
$course_id2 = array();
foreach ($regcourse1C as $key => $value) {
$regc1 [] =$value;
$course_id1 [] =$value->course_id;
}

foreach ($regcourse2C as $key => $value) {
$reg2c [] =$value;
$course_id2 [] =$value->course_id;
}
//dd($regc1);
$no1C = count($regcourse1C);
$no2C = count($regcourse2C);

   if( $result_type == 1)
   {
    // ------- sessional
 $title ="SESSIONAL";
   }
   elseif($result_type == 2)
   {
 // ------- omitted
    $title ="OMITTED";
   }
 elseif($result_type == 3)
   { // ------- correctional
    $title ="CORRECTIONAL";
   }

  return view('desk.display_report')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2);
 }
// ------------------------------      custom methods---------------------------------------------------
 public function getRegisteredCourses($p,$d,$f,$fos,$l,$s,$sm,$sts)
 {
   $reg =RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos],['level_id',$l],['session',$s],['semester_id',$sm],['reg_course_status',$sts]])->orderBy('reg_course_code','ASC')->get();
   return $reg;
 }
 //---------------------------------------------------------------------------------------
// get registered students
  public function getRegisteredStudents($p,$d,$f,$fos,$l,$s)
 {
  // get student that did probation
  $s1 = $s-1;
  $prob_user_id = array();
$prob_Student_reg = StudentReg::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['level_id',$l],['session',$s1]])->get();
foreach ($prob_Student_reg as $key => $value) {
 $prob_user_id [] = $value->user_id;
}
  $users = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['users.fos_id',$fos],['student_regs.level_id',$l],['student_regs.session',$s]])
            ->whereNotIn('users.user_id',$prob_user_id)
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();
   
   return $users;
 }

 //----------------------------------------------------------------------------------------------------


 //============================================END OF REPORT=============================================
//================================== custom function =========================================================
protected function get_fos()
{
    $fos= DB::connection('mysql')->table('fos')
            ->join('deskoffice_fos', 'fos.id', '=', 'deskoffice_fos.fos_id')
            ->where('deskoffice_fos.user_id',Auth::user()->id)
             ->where('deskoffice_fos.status',1)
            ->orderBy('fos_name','ASC')
            ->select('fos.*')
            ->get();
            return $fos;
}

protected function get_level()
{
$level =Level::where('programme_id',Auth::user()->programme_id)->get();
return $level;
}
protected function get_semester()
{
   $semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
   return $semester;
}  
protected function p()
{$p =Auth::user()->programme_id;
return $p;
}
protected function d()
{
    $d =Auth::user()->department_id;
    return $d;
}

protected function f()
{
    $f =Auth::user()->faculty_id;
    return $f; 
}
  

public function getcourse($id,$l,$f,$s)
{
    $d =RegisterCourse::where([['semester_id',$id],['level_id',$l],['fos_id',$f],['session',$s]])->get();
    return response()->json($d); 
}

 public function getFosPara($id)
    {
     $d =Fos::find($id);
    return response()->json($d);
    }

    public function getLecturer($id)
    { 
      $l = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id',self::LECTURER)
            ->where('users.department_id',$id)
            ->orderBy('users.name','ASC')
            ->select('users.*')
            ->get();
            
   return response()->json($l); 
    }
}
