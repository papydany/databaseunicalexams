<?php
namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Collection;
//use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use App\Role;
use App\Faculty;
use App\Department;
//use App\Programme;
use App\Fos;
use App\Level;
use App\Semester;
use App\StudentResult;
use App\StudentResultBackup;
use App\Specialization;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Pin;
use App\Course;
use App\RegisterCourse;
use App\AssignCourse;
use App\CourseReg;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\MyTrait;

class DeskController extends Controller
{
use MyTrait;
Const EXAMSOFFICER = 4;
Const LECTURER = 5;
Const HOD = 7;
Const FIRST = 1;
Const SECOND = 2;
Const MEDICINE = 14;
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
    	$clean_list[$value] =array('title'=>$request->title[$key],'name'=>$request->name[$key],'email'=>$request->email[$key],'password'=>$request->password[$key],'username'=>$value);
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
	
$user =DB::table('users')->insertGetId(['title'=> $clean_list[$k]['title'],'name' => $clean_list[$k]['name'], 'username' =>$clean_list[$k]['username'],'password'=>bcrypt($clean_list[$k]['password']),'email'=>$clean_list[$k]['email'],'plain_password'=>$clean_list[$k]['password'],'faculty_id'=>Auth::user()->faculty_id,'department_id'=>Auth::user()->department_id,'programme_id'=>0,'fos_id'=>0,'edit_right'=>0]);

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
            ->whereIn('user_roles.role_id',[self::LECTURER,self::HOD,self::EXAMSOFFICER])
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
            ->whereIn('user_roles.role_id',[self::LECTURER,self::HOD,self::EXAMSOFFICER])
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
$lecturer->email =$request->email;
/*$lecturer->password =bcrypt($request->password);
$lecturer->plain_password =$request->password;*/
$lecturer->save();
   return redirect()->action('DeskController@view_lecturer');
}
//-------------------------------------new courses ----------------------------------------------
public function new_course()
{
	$level =Level::where('programme_id',Auth::user()->programme_id)->get();
	$semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
	return view('desk.new_course')->withL($level)->withS($semester)->withmed(self::MEDICINE);
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
  /*  if(Auth::user()->edit_right == 0)
    {
        Session::flash('danger',"You need edit right to edit course. contact the system admin.");
   return redirect()->action('DeskController@view_course');
    }*/
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
$c->semester =$request->semester;
$c->save();
Session::flash('success',"SUCCESSFULL.");
   return redirect()->action('DeskController@view_course');
}

//----------------------- delete course ------------------------------------------------------
public function delete_course($id)
{
  /*  if(Auth::user()->edit_right == 0)
    {
        Session::flash('danger',"You need edit right to delete course. contact the system admin.");
   return redirect()->action('DeskController@view_course');
    }*/
$course = Course::destroy($id);
 Session::flash('success',"SUCCESSFULL.");
   return redirect()->action('DeskController@view_course');
}

public function delete_multiple_course(Request $request)
{
   /*  if(Auth::user()->edit_right == 0)
    {
        Session::flash('danger',"You need edit right to delete course. contact the system admin.");
   return redirect()->action('DeskController@view_course');
    }*/
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
	return view('desk.register_course')->withL($level)->withS($semester)->withMed(self::MEDICINE);
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
        if($fos == null)
        {
          Session::flash('waring',"Contact the system Admin. your account is not assign to field od study.");
          return back();
        }
        if($month != null)
        {
$course =Course::where([['department_id',Auth::user()->department_id],['level',$level],['semester',$semester],['month',$month]])
        ->orderBy('course_code','ASC')->get();
        return view('desk.register_course')->withCourse($course)->withL($l)->withLevel($level)->withS($s)->withF($fos)->withM($month)->withMed(self::MEDICINE);
        }
        else{
          $course =Course::where([['department_id',Auth::user()->department_id],['level',$level],['semester',$semester]])
        ->orderBy('course_code','ASC')->get(); 
         return view('desk.register_course')->withCourse($course)->withL($l)->withLevel($level)->withS($s)->withF($fos)->withMed(self::MEDICINE);
        }
    
}
//-------------------------------------------------------------------------------------------------
public function post_register_course(Request $request)
{
	$this->validate($request,array('fos'=>'required','session_id'=>'required'));
	$session =$request->input('session_id');
    $month =$request->input('month');
    	$fos =$request->input('fos');
      $sfos =$request->input('sfos');
      $level =$request->input('level');
    	$p =Auth::user()->programme_id;
    	$d =Auth::user()->department_id;
    	$f =Auth::user()->faculty_id;
	 $variable = $request->input('id');
	 if($variable == null)
{
  Session::flash('warning',"select course to register.");
    return back();
}
// check for specialization
$checkSpecialization =Specialization::where([['fos_id',$fos],['level','>=',$level]])->get();
if($checkSpecialization->count() != 0)
{
  $specId =array();

  foreach ($variable as $key => $value) {
    $specId [] =$value->id;
  }
  if(!in_array($specId,$sfos))
  {
    Session::flash('warning',"select specialization.");
    return back();
  }
}
dd('yes');
$course =Course::whereIn('id',$variable)->get();
foreach ($course as $key => $value) {
	$data[$value->id] =['course_id'=>$value->id,'programme_id'=>$p,'department_id'=>$d,'faculty_id'=>$f,'fos_id'=>$fos,'level_id'=>$value->level,'semester_id'=>$value->semester,'reg_course_title'=>$value->course_title,'reg_course_code'=>$value->course_code,'reg_course_unit'=>$value->course_unit,'reg_course_status'=>$value->status,'session'=>$session,'month'=>$month];

    $check_data[] =$value->id;
    $check_level[] =$value->level;
}
// check if course exist already on the register course table
$check =RegisterCourse::whereIn('course_id',$check_data)
->whereIn('level_id',$check_level)
->where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos],['session',$session]
,['reg_course_status','!=','G']])
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
    return view('desk.view_register_course')->withL($level)->withF($fos)->withMed(self::MEDICINE);
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
//--------------------------------- registered course ----------------------------------------------
function registeredcourse()
{
    $level =Level::where('programme_id',Auth::user()->programme_id)->get();
   // $semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
    // get fos
$fos =$this->get_fos();
    return view('desk.registeredcourse')->withL($level)->withF($fos)->withMed(self::MEDICINE);
}

//----------------------------------------------------------------------------------------------------
function post_registeredcourse(request $request)
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
        $fos_name =Fos::find($fos);

$register_course =RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos],['level_id',$l],['session',$session]])->orderBy('semester_id','ASC')->orderBy('reg_course_status','ASC')->get();
return view('desk.registeredcourse')->withL($level)->withS($semester)->withF($fos_id)->withR($register_course)->withG_s($session)->withG_l($l)->withFos($fos)->withFn($fos_name);
}
//----------------------------------------assign courses ---------------------------------------------------
public function assign_course()
{
  $level =$this->get_level();
 $semester =$this->get_semester();
    // get fos
$fos =$this->get_fos();
$p =$this->getp();
$f =$this->get_faculty();
    return view('desk.assigncourse.index')->withL($level)->withS($semester)->withF($fos)->withP($p)->withFc($f);

  
}
function delete_desk_course($id,$s)
{

  $check = CourseReg::where([['registercourse_id',$id],['session',$s]])->first();
if($check != null)
{
  Session::flash('warning',"The courses selected has been registered by students.so u can not delete it. contact admin");

  return back();
}
$reg =RegisterCourse::destroy($id);
$assign_course =AssignCourse::where('registercourse_id',$id)->first();
if($assign_course != null)
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
//=========================================================================================================
//--------------------------------------------------------------------------------------------------------
function get_assign_course(request $request)
{
    $this->validate($request,array('fos'=>'required','session_id'=>'required','level'=>'required','semester'=>'required'));
   $semester_id =$request->semester;
    $session =$request->session_id;
    $fos_id =$request->fos;
    $l =$request->level;
    //dd($request->admin);
if(isset($request->admin))
{
$p =$request->programme_id;
    $f =$request->faculty_id;
    $d =$request->department_id;
}else
{
 $p =$this->p();
    $f =$this->f();
    $d =$this->d();
}
    
    $level =$this->get_level();
    $semester =$this->get_semester();
    $fos =$this->get_fos();
    $pp =$this->getp();
$fc =$this->get_faculty();
   
     $lecturer = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->whereIn('user_roles.role_id',[self::LECTURER,self::HOD])
            ->where([['users.faculty_id',$f],['users.department_id',$d]])
            ->orderBy('users.name','ASC')
            ->select('users.*')
            ->get(); 

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


  return view('desk.assigncourse.index')->withL($level)->withS($semester)->withF($fos)->withRs($register_course)->withLec($lecturer)->withG_s($session)->withG_l($l)->withP($pp)->withFc($fc)->withF_id($f)->withD_id($d);           
}

//--------------------------assign courses other-----------------------------------
public function assign_course_other()
{
  $level =$this->get_level();
 $semester =$this->get_semester();
    // get fos
$fos =$this->get_fos();
$p =$this->getp();
$f =$this->get_faculty();
return view('desk.assigncourse.assign_courses_other')->withL($level)->withS($semester)->withF($fos)->withP($p)->withFc($f); 
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
    if(isset($request->admin))
{
$p =$request->programme_id;
    $f =$request->faculty_id;
    $d =$request->department_id;
}else
{
 $p =$this->p();
    $f =$this->f();
    $d =$this->d();
}
  $pp =$this->getp();
$fc =$this->get_faculty();
  
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



  return view('desk.assigncourse.assign_courses_other')->withL($level)->withS($semester)->withF($fos)->withRs($register_course)->withDepart($department)->withG_s($session)->withG_l($l)->withP($pp)->withFc($fc)->withF_id($f)->withD_id($d);           
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
    if(isset($request->admin))
{

    $f =$request->faculty_id;
    $d =$request->department_id;
}else
{
 
    $f =$this->f();
    $d =$this->d();
}


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
 $f =$request->f_id;
$d =$request->d_id;
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
    $p =$this->getp();
$f =$this->get_faculty();


    return view('desk.assigncourse.view')->withL($level)->withS($semester)->withF($fos)->withFc($f)->withP($p);
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
      $pp =$this->getp();
$fc =$this->get_faculty();
if(isset($request->admin))
{
$p =$request->programme_id;
    $f =$request->faculty_id;
    $d =$request->department_id;
}else
{
 $p =$this->p();
    $f =$this->f();
    $d =$this->d();
}
    
   

    $assign_course =AssignCourse::where([['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['level_id',$l],['session',$session],['semester_id',$semester_id]])->orderBy('semester_id','ASC')->get();

    return view('desk.assigncourse.view')->withL($level)->withS($semester)->withF($fos)->withAc($assign_course)->withG_s($session)->withG_l($l)->withS_id($semester_id)->withFc($fc)->withP($pp)->withF_id($f)->withD_id($d); 
}
public function remove_assign_course($id)
{
    $r =AssignCourse::find($id);
    $r->delete();
    Session::flash('success',"SUCCESSFULL.");
    return redirect()->action('DeskController@view_assign_course');
}
public function remove_multiple_assign_course(Request $request)
{
  $id =$request->id;
 
    $r =AssignCourse::destroy($id);
    Session::flash('success',"SUCCESSFULL.");
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
       $user = DB::connection('mysql2')->table('users')->where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos_id],['entry_year',$session],['entry_month',$entry_month]])->orderBy('matric_number','ASC')->get();

        return view('desk.view_student')->withF($fos)->withU($user)->withS($session);
    }
// view student details
    public function view_student_detail(Request $request,$id)
    {
      $fos = $this->get_fos();
      $users = DB::connection('mysql2')->table('users')
      ->where([['id',$id],['department_id',$this->d()]])
      ->first();
      if($users !=  null )
      {
      $stdReg = DB::connection('mysql2')->table('student_regs')->where('user_id',$users->id)->get();
      $f =Faculty::get();
return view('desk.view_student_detail')->withU($users)->withSr($stdReg)->withF($fos)->withFc($f);
      }
       
      $request->session()->flash('warning', 'Students  does not exist');
      return back();
    }

    // update students entry year

    public function update_entry_year(Request $request)
    {
      $entry_year =$request->input('session');
      $id =$request->input('user_id');
      $present_entry_year =$request->input('present_entry_year');
      $matric_number =$request->input('matric_number');

      $stdReg = DB::connection('mysql2')->table('student_regs')->where('user_id',$id)->count();
      if($stdReg == 0)
      {
        $users = DB::connection('mysql2')->table('users')
        ->where([['id',$id],['department_id',$this->d()]])
        ->update(['entry_year'=>$entry_year]);
        $pin=Pin::where([['student_id',$id],['matric_number',$matric_number],['session',$present_entry_year]])
        ->update(['session'=>$entry_year]);
        
        $request->session()->flash('success', 'Successfull.');
     return back();
     
      }else
      {
        $request->session()->flash('warning', 'students registration of courses must be delete
         before you can update entry year.');
      return back();
      }

    }

    //======================================== register student =====================================

    public function register_student()
    {
        $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
        return view('desk.register_student')->withF($fos)->withL($l)->withS($semester)->withMed(self::MEDICINE);
    }
    // ===========================post view student ==========================================
    public function post_register_student(Request $request,$fos_id =null,$level=null,$semester_id=null,$session=null,$season=null)
    {
      
        $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
        if(isset($fos_id) && isset($level) && isset($semester_id) && isset($session) && isset($season))
     {
      $season =$season;
      $semester_id =$semester_id;
      $fos_id =$fos_id;
       $l_id =$level;
       $session =$session;
     }else{
      $season =$request->input('season');
      $semester_id =$request->input('semester_id');
      $fos_id = $request->input('fos_id');
      $l_id =$request->input('level');
      $session =$request->input('session_id');
     }
     //dd($level); 
        $p =$this->p();
        if($p == 0)
        {
          $foses =Fos::find($fos_id);
          $p =$foses->programme_id;
        }
        $f =$this->f();
        $d =$this->d();
        $prob_user_id = $this->getprobationStudents($p,$d,$f,$l_id,$session);
        $all_user= array();
        $studentreg_id =array();
//dd($semester_id);
        $user = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'student_regs.user_id', '=', 'users.id')
            ->where('users.fos_id',$fos_id)
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['student_regs.season',$season],
                ['student_regs.session',$session],['student_regs.semester',$semester_id],['student_regs.level_id',$l_id]])
            ->whereNotIn('users.id',$prob_user_id)
            ->orderBy('users.matric_number','ASC')
            ->select('student_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.fos_id','users.entry_year')
            ->get();

          //Get current page form url e.g. &page=6
        $url =url()->full();
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($user);

        //Define how many items we want to be visible in each page
       $perPage =20;
       //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage- 1) * $perPage, $perPage)->all();
      //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
       return view('desk.register_student')->withU($paginatedSearchResults)->withSs($session)->withF($fos)->withL($l)->withS($semester)
            ->withL_id($l_id)->withS_id($semester_id)->withUrl($url)->withMed(self::MEDICINE)->withFf($f);
    }


    //================================= registered students II============================
    public function register_student_ii()
    {
        $fos = $this->get_fos();
        $l = $this->get_level();
        return view('desk.register_student.ii')->withF($fos)->withL($l);
    }
    // ===========================post view student ==========================================
    public function post_register_student_ii(Request $request,$fos_id =null,$level=null,$session=null,$season=null)
    {
      $fos = $this->get_fos();
      $l = $this->get_level();
      
        if(isset($fos_id) && isset($level) && isset($session) && isset($season))
     {
      $season =$season;
      $fos_id =$fos_id;
       $l_id =$level;
       $session =$session;
     }else{
      $season =$request->input('season');
      $fos_id = $request->input('fos_id');
      $l_id =$request->input('level');
      $session =$request->input('session_id');
     }
     //dd($level); 
        $p =$this->p();
        if($p == 0)
        {
          $foses =Fos::find($fos_id);
          $p =$foses->programme_id;
        }
        $f =$this->f();
        $d =$this->d();
        $prob_user_id = $this->getprobationStudents($p,$d,$f,$l_id,$session);
        $all_user= array();
        $studentreg_id =array();
//dd($semester_id);
        $user = DB::connection('mysql2')->table('student_regs')
        ->distinct('student_regs.matric_number')
            ->join('users', 'student_regs.user_id', '=', 'users.id')
            ->where('users.fos_id',$fos_id)
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['student_regs.season',$season],
                ['student_regs.session',$session],['student_regs.level_id',$l_id]])
            ->whereNotIn('users.id',$prob_user_id)
            ->orderBy('users.matric_number','ASC')
            ->select('users.id','users.firstname', 'users.surname','users.othername','users.matric_number','users.fos_id','users.entry_year')
            
            ->get();
          
 return view('desk.register_student.ii')->withSs($session)->withF($fos)->withL($l)->withL_id($l_id)->withU($user)->withSeason($season)->withMed(self::MEDICINE);
    }

  //============================= registered_student_detail========================
  public function registered_student_detail(Request $request,$user_id =null,$level=null,$session=null,$season=null){
   
    if(isset($user_id) && isset($level) && isset($session) && isset($season))
    {
     $season =$season;
     $user_id =$user_id;
     $level =$level;
    $session =$session;
    $studentDetails =array();
    $u =User::find($user_id);
    $user = DB::connection('mysql2')->table('student_regs')
    ->join('course_regs', 'course_regs.studentreg_id', '=', 'student_regs.id')
    ->where([['student_regs.level_id',$level],['student_regs.session',$session],['student_regs.season',$season],
    ['student_regs.user_id',$user_id]])
    ->where([['course_regs.user_id',$user_id],['course_regs.level_id',$level],['course_regs.session',$session],['course_regs.period',$season]])
    ->orderBy('course_regs.semester_id','ASC')
    ->select('course_regs.*')
    ->get();
//dd($user);
    foreach($user as $v){
      $r =$this->getResult($v->id);
      $studentDetails []=['id'=>$v->id,'course_id'=>$v->course_id,'code'=>$v->course_code,'unit'=>$v->course_unit,'r'=>$r->id ? $r->id :'','ca'=>$r->ca ? $r->ca : '',
      'exam'=>$r->exam ?$r->exam : '','total'=>$r->total ? $r->total : ''];
    }
    //dd($studentDetails);
    return view('desk.register_student.student_details')->withS($studentDetails)->withSession($session)
    ->withLevel($level)->withU($u)->withSeason($season);;
    }else{
      dd('something went wrong. contact system admin.');
    }
  }
    //================================= Entering Result =====================================================
    public function enter_result(Request $request)
    {
      $url = url()->previous();
      if($request->input('delete') =='delete'){
        $ch =$request->input('chk');
        if($ch == null)
        {
          Session::flash('warning',"you did not select any course to delete.");
          return back();
        }else{
        foreach($ch as $v)
        {
          $cr =CourseReg::destroy($v);
          $sr =StudentResult::where('coursereg_id',$v)->delete();
          $srb =StudentResultBackup::where('coursereg_id',$v)->delete();
        }
        Session::flash('success',"SUCCESSFULL.");
      }
      
      return redirect($url);
        }
       
        $fos = $this->get_fos();
        $l = $this->get_level();
        $semester = $this->get_semester();
        $faculty_id = $request->input('faculty_id');
        $fos_id = $request->input('fos_id');
        $semester_id = $request->input('semester_id');
        $season = $request->input('season');
        $entry_year= $request->input('entry_year');
        $l_id = $request->input('level_id');
        $session = $request->input('session_id');
        $user_id = $request->input('user_id');
        $mat_no = $request->input('matric_number');

        $variable = $request->input('total');

        $flag = "Sessional";
        $date = date("Y/m/d H:i:s");
     
        foreach ($variable as $k => $v) {

            $xc = explode('~', $k);
            $v = strtoupper($v);
            if (!empty($v)) {
              if($faculty_id == Self::MEDICINE){
              $grade_value =$this->get_grade_medicine($v,$season,$l);
              }else{
              $grade_value =$this->get_grade($v);
              }
              $grade = $grade_value['grade'];


                $size = count($xc);
                if (4 == $size) {
                    //UPDATE EXISTING RESULT
                    $result_id = $xc[0];
                    $coursereg_id = $xc[1];
                    $course_id = $xc[2];
                    $cu = $xc[3];
                    $x = $this->mm($grade,$cu,$entry_year);

                    $ca=$request->input('ca')[$result_id];

                    $exam =$request->input('exam')[$result_id];

                    $update = StudentResult::find($result_id);
                    if($update->total != $v) // only updates when the total is different
                    {
                    $update->ca =$ca;
                    $update->exam =$exam;
                    $update->total =$v;
                    $update->grade = $grade;
                    $update->cp = $x['cp'];
                    $update->examofficer=Auth::user()->id;
                    $update->post_date=$date;
                    $update->save();
                 }


                } else {
                    //INSERT FRESH RESULT
                    $coursereg_id = $xc[0];
                    $course_id = $xc[1];
                    $cu = $xc[2];
                    $x = $this->mm($grade, $cu,$entry_year);
                   
                    $ca=$request->input('ca')[$coursereg_id];
                    $exam =$request->input('exam')[$coursereg_id];
                    $cp = $x['cp'];

                    $check_result = StudentResult::where([['user_id',$user_id], ['level_id', $l_id], ['session', $session], ['course_id', $course_id], ['coursereg_id', $coursereg_id]])->first();
                    if ($check_result == null) {
                        $insert_data[] = ['user_id'=>$user_id,'matric_number'=>$mat_no,'course_id'=>$course_id,'coursereg_id'=>$coursereg_id,'ca'=>$ca,'exam'=>$exam,'total'=>$v,'grade'=>$grade,'cu'=>$cu,'cp'=>$x['cp'],'level_id'=>$l_id,'session'=>$session,'semester'=>$semester_id,'status'=>0,'season'=>$season,'flag'=>$flag,'examofficer'=>Auth::user()->id,'post_date'=>$date,'approved'=>0];
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
       return redirect($url);
       // return redirect()->action('DeskController@post_register_student',['fos_id'=>$fos_id,'level'=>$l_id,'semester_id'=>$semester_id,'session'=>$session,'season'=>$season]);
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
        $p =$this->p();
        if($p == 0)
        {
          $foses =Fos::find($fos_id);
          $p =$foses->programme_id;
        }
        $f =$this->f();
        $d =$this->d();
  $prob_user_id = $this->getprobationStudents($p,$d,$f,$l_id,$session);
         $user = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'student_regs.user_id', '=', 'users.id')
            ->where('users.fos_id',$fos_id)
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['student_regs.season',$season],
                ['student_regs.session',$session],['student_regs.semester',$semester_id],['student_regs.level_id',$l_id]])
            ->whereNotIn('users.id',$prob_user_id)
            ->select('student_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.fos_id','users.entry_year')
            ->orderBy('users.matric_number','ASC')
            ->get();
            
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
return view('desk.e_result')->withF($fos)->withL($l)->withS($semester)->withMed(self::MEDICINE);
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
     return view('desk.e_result_next')->withF($fos)->withL($l)->withS($semester)->withRc($rc)->withL_id($l_id)->withS_id($s_id)->withSm_id($semester_id)->withMed(self::MEDICINE);
    }  

 //================================== get student  by course =============================================
  public  function e_result_c(Request $request)
    {  
       $id =$request->input('id'); 
       $period =$request->input('period');
       $result_type =$request->input('result_type'); 
    $registercourse = RegisterCourse::find($id);
    $p =$registercourse->programme_id;
    $d =$registercourse->department_id;
    $f =$registercourse->faculty_id;
    $l =$registercourse->level_id;
    $s=$registercourse->session;
    $prob_user_id = $this->getprobationStudents($p,$d,$f,$l,$s);
    
    if($result_type == "Omitted")
    {
      $user_with_no_result =$this->student_with_no_result($id,$period);
     
      $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where('course_regs.registercourse_id',$id)
        ->where('course_regs.period',$period)
        ->whereIn('users.id',$user_with_no_result)
        ->whereNotIn('users.id',$prob_user_id)
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.entry_year')
        ->get();
      }elseif($result_type == "Correctional")
      {
        $user_with_no_result =$this->student_with_no_result($id,$period);
      /*  $result =DB::connection('mysql2')->table('student_results')
->where([['coursereg_id',$v->id],['approved',1]])->first();*/

        $user = DB::connection('mysql2')->table('users')
          ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
          ->join('student_results', 'course_regs.id', '=', 'student_results.coursereg_id')
          ->where('course_regs.registercourse_id',$id)
          ->where('course_regs.period',$period)
          ->where('student_results.approved',1)
          ->whereNotIn('users.id',$user_with_no_result)
          ->whereNotIn('users.id',$prob_user_id)
          ->orderBy('users.matric_number','ASC')
          ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.entry_year')
          ->get();
          
        }
      else{

      $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where('course_regs.registercourse_id',$id)
        ->where('course_regs.period',$period)
        ->whereNotIn('users.id',$prob_user_id)
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.entry_year')
        ->get();
      }
      //dd($user);
  //Get current page form url e.g. &page=6
        $url ="e_result_c?id=".$id.'&period='.$period.'&result_type='.$result_type;
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
       
    
      return view('desk.e_result_c')->withU($paginatedSearchResults)->withUrl($url)->withC($registercourse)->withRt($result_type)->withMed(self::MEDICINE)->withF($f);
    
    }  

//========================================== result insert for student percourse ==========================

    public function insert_result(Request $request)
    {
        $this->validate($request,array('id'=>'required',));
        $url =$request->input('url');
        $id =$request->input('id');

        if($request->input('delete') =='delete'){
      
          if($id == null)
          {
            Session::flash('warning',"you did not select any course to delete.");
            return back();
          }else{
            foreach ($id as $key => $value) {
              $v =$request->input('coursereg_id')[$value];
             // $user_id =$request->input('user_id')[$value];
            
            $sr =StudentResult::where('coursereg_id',$v)->delete();
           $srb =StudentResultBackup::where('coursereg_id',$v)->delete();
           $cr =CourseReg::destroy($v);
          }
        
          Session::flash('success',"Delete of courses successful.");
        }
        
        return redirect($url);
          }
        $flag = $request->input('flag');
        $faculty_id = $request->input('faculty_id');
        $date = date("Y/m/d H:i:s"); 
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
        $script =$request->input('scriptNo')[$value];
        $ca =$request->input('ca')[$value];
        $exam=$request->input('exams')[$value];
        //$total=$request->input('total')[$value];
        $total=$ca + $exam;
        $entry_year=$request->input('entry_year')[$value];
        if($faculty_id == Self::MEDICINE){
          $grade_value =$this->get_grade_medicine($total,$season,$l_id);
          }else{
        $grade_value =$this->get_grade($total,$entry_year);
          }
       
        $grade = $grade_value['grade'];
        $cp = $this->mm($grade,$cu,$entry_year);
      //  $result_id =$request->input('result_id')[$value];
        //if($request->has('result_id'.[$value])) {
      
$result_id =$request->input('result_id')[$value];

     //  }
     //check ca, exams, total
if($ca ==''){$ca=0;}
if($exam ==''){$exam=0;}
if($total ==''){$total=0;}

         if(!empty($result_id))
         {
  
$update = StudentResult::find($result_id);

//================ correctional result ==================
if($flag =='Correctional')
{
  $reason = $request->input('reason');
  // check these back up result, if scores exist already
  $check =StudentResultBackup::where([['level_id',$l_id],['session',$session],['course_id',$course_id],['coursereg_id',$coursereg_id],['user_id',$update->user_id]])
  ->first();

  // update back table if records exist
  if($check != null)
  {
    $check->grade = $update->grade;
    $check->cp = $update->cp;
    $check->reason = $update->reason;
    $check->save();
  }else
  {
    // insert if records doest not exist
    $srb =new StudentResultBackup;
    $srb->user_id =$update->user_id;
    $srb->matric_number =$update->matric_number;
    $srb->coursereg_id =$update->coursereg_id;
    $srb->course_id=$update->course_id;
   $srb->grade =$update->grade;
    $srb->cu =$update->cu;
    $srb->cp =$update->cp;
    $srb->session =$update->session;
    $srb->semester=$update->semester;
    $srb->level_id =$update->level_id;
    $srb->status =0;
    $srb->season =$update->season;
    $srb->reason =$update->reason;
  $srb->save();

  }

  
}// end of correctional result
         $update->scriptNo = $script;
           $update->ca = $ca;
            $update->exam = $exam;
            $update->total = $total;
            $update->grade = $grade;
            $update->flag =$flag;
            $update->cp = $cp['cp'];
            $update->save();
         }else{


               $check_result = StudentResult::where([['user_id',$user_id],['matric_number',$mat_no],['level_id', $l_id], ['session', $session], ['course_id', $course_id], ['coursereg_id', $coursereg_id]])->first();
                    if ($check_result == null) {
                        $insert_data[] = ['user_id'=>$user_id,'matric_number'=>$mat_no,'scriptNo'=>$script,'course_id'=>$course_id,'coursereg_id'=>$coursereg_id,'ca'=>$ca,'exam'=>$exam,'total'=>$total,'grade'=> $grade,'cu'=>$cu,'cp'=>$cp['cp'],'level_id'=>$l_id,
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
  $ResultType =$request->input('result_type');
 // $result =DB::connection('mysql2')->table('student_results');
 $user = DB::connection('mysql2')->table('users','student_results')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->join('student_results', 'student_results.user_id', '=', 'users.id')
        ->where([['student_results.level_id',$l],['student_results.semester',$sm],['student_results.session',$s],['student_results.course_id',$course_id],['student_results.season',$period],['student_results.flag',$ResultType]])
        ->where([['course_regs.registercourse_id',$reg_id],['course_regs.level_id',$l],['course_regs.semester_id',$sm],['course_regs.session',$s],['course_regs.course_id',$course_id],['course_regs.period',$period]])
        ->orderBy('users.matric_number','ASC')
        ->whereIn('course_regs.id', function($query) {
          $query->select('coursereg_id')->from('student_results');
      })
        ->select('course_regs.id as cosId','student_results.*','users.firstname', 'users.surname','users.othername','users.matric_number')
    
        ->get();
      // dd($user);
  return view('desk.delete_result_detail')->withU($user)->withSm($sm)->withS($s)->withL($l)->withFos_id($fos_id)->withCourse_code($course_code)->withResultType($ResultType);
 }

 //=============.=============== REPORT ==============================================================
//------------------------------ Report methods ------------------------------------------------------
  public function departmentreport()
 {
   $p =$this->getp();
 return view('desk.hod.index')->withP($p)->withMed(self::MEDICINE);
 }
 public function report()
 {
   $fos =$this->get_fos();
   $p =$this->getp();
   $f =$this->get_faculty();
   return view('desk.report.index')->withF($fos)->withFc($f)->withP($p);
 }

  public function post_report(Request $request)
 {
   if($request->input('result_type') == 0)
   {
    Session::flash('warning',"you did not select result type.");
    return back();
   }
  if(isset($request->admin))
  {
//$fos_id =$request->input('fos');
$d =$request->department_id;
$f =$request->faculty_id;
$foss =Fos::find($request->input('fos'));
$p =$foss->programme_id;

  }else
  {
$d =Auth::user()->department_id;
$f =Auth::user()->faculty_id;
$p =Auth::user()->programme_id;
  }

if($p == 0)
{
  $p =$request->p;
}
//$user_id = Auth::user()->id;
$flag ="Sessional";
$perPage =$request->input('page_number');
//dd($page_number);

$this->validate($request,array('fos'=>'required','session'=>'required','level'=>'required','result_type'=>'required',));
$regc1 ='';   
$reg2c ='';
$fos =$request->input('fos');

$s =$request->input('session');
$l =$request->input('level');
$final ='';
if($l != 1)
 {
  $sl = explode('~',$l);
  $l =$sl[0];
  if(isset($sl[1])){
  $final =$sl[1];
  }
 }
 
$result_type =$request->input('result_type');
$duration=$request->input('duration');
if($request->selected == 6)
{
  $final=$request->input('final');
}
// select student type report
if($result_type == 6)
{
  $users = $this->getRegisteredStudents($p,$d,$f,$fos,$l,$s);
  return view('desk.report.selectStudent')->withFinal($final)->withDuration($duration)->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withUsers($users)->withFlag($flag)->withF($f)->withD($d)->withFinal($final);
}

$regcourse1C =$this->getRegisteredCourses($p,$d,$f,$fos,$l,$s,1,'C');
// jumb register courses for second semester for medicine
if($f == self::MEDICINE && $l > 2){}else{
$regcourse2C =$this->getRegisteredCourses($p,$d,$f,$fos,$l,$s,2,'C');
}
// seasional result

if ($result_type == 12) {
  // resit students
 $users = $this->getResitRegisteredStudents($p,$d,$f,$fos,$l,$s,'RESIT');
}
elseif($result_type == 7){

  $title ="SUMMER VACATION";
  $season ="VACATION";
  $flag="Sessional";
  if($request->selected == 6)
  {
$selectedID =$request->ids;

$users =$this->SelectedResitRegisteredStudents($selectedID,$l,$s,$season);
  }else{
  
    $users = $this->getResitRegisteredStudents($p,$d,$f,$fos,$l,$s,$season);
  }
  }
elseif($result_type == 5){

  $title ="LONG VACATION";
  $season ="VACATION";
  $flag="Sessional";
  if($request->selected == 6)
  {
$selectedID =$request->ids;

$users =$this->SelectedResitRegisteredStudents($selectedID,$l,$s,$season);
  }else{
  
    $users = $this->getResitRegisteredStudents($p,$d,$f,$fos,$l,$s,$season);
  }
  }
elseif($result_type == 4){
  $title ="CORRECTIONAL";
  $season ="NORMAL";
  $flag="Correctional";
  if($request->selected == 6)
  {
$selectedID =$request->ids;
$users = $this->SelectedStudentsWithFlag($selectedID,$l,$s,$flag);
  }else{
  $users = $this->getRegisteredStudentsWithFlag($p,$d,$f,$fos,$l,$s,$flag);
  }
  }
elseif($result_type == 2){
  $flag="Omitted";
$title ="OMITTED";
$season ="NORMAL";
if($request->selected == 6)
{
$selectedID =$request->ids;
$users = $this->SelectedStudentsWithFlag($selectedID,$l,$s,$flag);
}else{
  $users = $this->getRegisteredStudentsWithFlag($p,$d,$f,$fos,$l,$s,$flag);
}
}elseif($result_type == 1)
{
 $title ="SESSIONAL";
 if($final != '')
 {
  $title ="DEGREE";
 }
$season ="NORMAL";
if($request->selected == 6)
{
$selectedID =$request->ids;
$users = $this->SelectedStudentsWithFlag($selectedID,$l,$s,$flag);
}else{
$users = $this->getRegisteredStudents($p,$d,$f,$fos,$l,$s);
}
}
elseif($result_type == 3)
{
 $title ="PROBATIONAL";
$season ="NORMAL";
$ps =$s-1;
$regcourse1C =$this->getRegisteredCourses($p,$d,$f,$fos,$l,$ps,1,'C');
$regcourse2C =$this->getRegisteredCourses($p,$d,$f,$fos,$l,$ps,2,'C');
$users =$this->getRegisteredProbationStudentsForReport($p,$d,$f,$fos,$l,$s);
}
else
{
  $users = $this->getRegisteredStudents($p,$d,$f,$fos,$l,$s);
}
//dd($users);

$course_id1 = array();
$course_id2 = array();
$regc1 =array();
$reg2c =array();
// medicine and level 3 above
if($f == self::MEDICINE && $l > 2)
{
  if(empty($regcourse1C)){
    echo'<h3>You have not registered  the courses for these session</h3>';
    dd();
  }
}else{
if(empty($regcourse1C && $regcourse2C)){
  echo'<h3>You have not registered  the courses for these session</h3>';
  dd();
}
}
// medicine and level 3 above
if($f == self::MEDICINE && $l > 2)
{
  foreach ($regcourse1C as $key => $value) {
    $regc1 [] =$value;
    $course_id1 [] =$value->course_id;
    }
$no1C = count($regcourse1C);
$no2C = 0;
}else{
foreach ($regcourse1C as $key => $value) {
$regc1 [] =$value;
$course_id1 [] =$value->course_id;
}

foreach ($regcourse2C as $key => $value) {
$reg2c [] =$value;
$course_id2 [] =$value->course_id;
}

$no1C = count($regcourse1C);
$no2C = count($regcourse2C);
}

//Get current page form url e.g. &page=6
        $url =url()->full();
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($users);

        //Define how many items we want to be visible in each page
      /*  if($l == 1){
        $perPage =50;
        }else{
          $perPage =50;
        }*/
        

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage- 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

 if($result_type == 11)
   {
    // ------- sessional
 $title ="SESSIONAL";
 $season ="NORMAL";
 
 return view('desk.report.sessional_diploma')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withCpage($currentPage);
   }
   
   elseif($result_type == 12)
   {
    // ------- sessional
 $title ="RESIT";
 $season ="RESIT";
 if($l != 1)
 {
  $sl = explode('~',$l);
  $l =$sl[0];
 }
 return view('desk.report.resit_diploma')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withCpage($currentPage)->withFinal($final);
   }
   elseif($result_type == 3)
   {
    return view('desk.report.probation_report')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withCpage($currentPage);
   }
   elseif($result_type == 5)
   {
    if($f == Self::MEDICINE && $l > 2){
      return view('desk.report.resit_clinical_report')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withFinal($final)->withCpage($currentPage);
      }
    return view('desk.report.long_vacation_report')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withCpage($currentPage)->withFinal($final);
   }
   elseif($result_type == 7)
   {
    return view('desk.report.summer_vacation_report')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withCpage($currentPage)->withFinal($final);
   }
   else{

    if($f == Self::MEDICINE && $l < 3)
    {
      return view('desk.report.pre_medical_report')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withFinal($final)->withCpage($currentPage);
   }elseif($f == Self::MEDICINE && $l > 2){
   return view('desk.report.clinical_report')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withFinal($final)->withCpage($currentPage);
   }
   return view('desk.report.display_report')->withFos($fos)->withL($l)->withS($s)->withDuration($duration)->withT($title)->withN1c($no1C)->withN2c($no2C)->withRegc1($regc1)->withRegc2($reg2c)->withUsers($users)->withFlag($flag)->withSeason($season)->withCourse_id1($course_id1)->withCourse_id2($course_id2)->withU($paginatedSearchResults)->withUrl($url)->withPage($perPage)->withPn($perPage)->withF($f)->withD($d)->withFinal($final)->withCpage($currentPage);
    
   }

}

 // ======================== probation result fuction ==================================

    public function enter_probation_result()
    {
        $fos = $this->get_fos();
        $p =$this->getp();
        $l = $this->get_level();
        return view('desk.result.probation.index')->withF($fos)->withL($l)->withP($p);
    }
 // ===========================enter_probation_result_next ==========================================
    public function enter_probation_result_next(Request $request)
    {
        $fos = $this->get_fos();
        $l = $this->get_level();
        $pp =$this->getp();
        $semester = $this->get_semester();
        $season =$request->input('season');
        $fos_id = $request->input('fos');
        $l_id =$request->input('level');
        $session =$request->input('session_id');
        $p =$request->input('p');
        if($p == null)
        {
          $p =$this->p();
        }
        
        
        $f =$this->f();
        $d =$this->d();
        $user =$this->getRegisteredProbationStudents($p,$d,$f,$fos_id,$l_id,$session,$season);
       
       return view('desk.result.probation.index')->withU($user)->withSs($session)->withF($fos)->withL($l)
            ->withL_id($l_id)->withP($pp);
    }

    //================================= probation Entering Result =====================================================
    public function probation_enter_result(Request $request)
    {
        $fos = $this->get_fos();
        $l = $this->get_level();
        $fos_id = $request->input('fos_id');
        $season = $request->input('season');
        $entry_year= $request->input('entry_year');
        $l_id = $request->input('level_id');
        $session = $request->input('session_id');
        $user_id = $request->input('user_id');
        $mat_no = $request->input('matric_number');
        $programme_id = $request->input('programme_id');

        $variable = $request->input('total');

        $flag = "Sessional";
        $date = date("Y/m/d H:i:s");
     
        foreach ($variable as $k => $v) {

            $xc = explode('~', $k);
            $v = strtoupper($v);
            if (!empty($v)) {
              $grade_value =$this->get_grade($v,$entry_year);
              $grade = $grade_value['grade'];
                $size = count($xc);
                if (4 == $size) {
                    //UPDATE EXISTING RESULT
                    $result_id = $xc[0];
                    $coursereg_id = $xc[1];
                    $course_id = $xc[2];
                    $cu = $xc[3];
                    $x = $this->mm($grade, $cu,$entry_year);

                    $ca=$request->input('ca')[$result_id];
                    $semester_id =$request->input('semester_id')[$result_id];

                    $exam =$request->input('exam')[$result_id];

                    $update = StudentResult::find($result_id);
                    if($update->total != $v) // only updates when the total is different
                    {
                   // $update->exam =$semester;
                    $update->ca =$ca;
                    $update->exam =$exam;
                    $update->total =$v;
                    $update->grade = $grade;
                    $update->cp = $x['cp'];
                    $update->examofficer=Auth::user()->id;
                    $update->post_date=$date;
                    $update->save();
                 }


                } else {
                    //INSERT FRESH RESULT
                    $coursereg_id = $xc[0];
                    $course_id = $xc[1];
                    $cu = $xc[2];
                    $x = $this->mm($grade, $cu,$entry_year);
                   $semester_id =$request->input('semester_id')[$coursereg_id];
                    $ca=$request->input('ca')[$coursereg_id];
                    $exam =$request->input('exam')[$coursereg_id];
                    $cp = $x['cp'];

                    $check_result = StudentResult::where([['user_id', $user_id], ['level_id', $l_id], ['session', $session], ['course_id', $course_id], ['coursereg_id', $coursereg_id]])->first();
                    if ($check_result == null) {
                        $insert_data[] = ['user_id'=>$user_id,'matric_number'=>$mat_no,'course_id'=>$course_id,'coursereg_id'=>$coursereg_id,'ca'=>$ca,'exam'=>$exam,'total'=>$v,'grade'=>$grade,'cu'=>$cu,'cp'=>$x['cp'],'level_id'=>$l_id,'session'=>$session,'semester'=>$semester_id,'status'=>0,'season'=>$season,'flag'=>$flag,'examofficer'=>Auth::user()->id,'post_date'=>$date,'approved'=>0];
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
        return redirect()->action('DeskController@get_register_probation_student',['programme_id'=>$programme_id,'fos_id'=>$fos_id,'l_id'=>$l_id,'session'=>$session,'season'=>$season]);
    }
 //================================= get Register Student=====================================================
    public function get_register_probation_student($programme_id=null,$fos_id =null,$l_id=null,$session=null,$season=null)
    {
     if(isset($fos_id) && isset($l_id)  && isset($session) && isset($season))
     {
        $fos = $this->get_fos();
        $l = $this->get_level();
        //$p =$this->p();
        $p =$this->getp();
        $f =$this->f();
        $d =$this->d();
        
  $user = $this->getRegisteredProbationStudents($programme_id,$d,$f,$fos_id,$l_id,$session,$season);
  
  return view('desk.result.probation.index')->withU($user)->withSs($session)->withF($fos)->withL($l)
            ->withL_id($l_id)->withP($p);

     }
    }


// ------------------------------      custom methods---------------------------------------------------
 public function getRegisteredCourses($p,$d,$f,$fos,$l,$s,$sm,$sts)
 {
   $reg =DB::table('register_courses')
   //$reg =RegisterCourse::
   ->where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos],['level_id',$l],['session',$s],['semester_id',$sm],['reg_course_status',$sts]])
   ->orderBy('reg_course_code','ASC')
   ->get();
   if(count($reg) > 0)
   {
    return $reg;
  }
  return '';
   
 }
 //---------------------------------------------------------------------------------------
// get registered students
  public function getRegisteredStudents($p,$d,$f,$fos,$l,$s)
 {
  // get student that did probation
$prob_user_id = array(); $omitted_array = array(); $corrected_array = array();
$prob_user_id = $this->getprobationStudents($p,$d,$f,$l,$s);
//$omitted =$this->getOmittedResultStudents($p,$d,$f,$fos,$l,$s);
$omitted = $this->getStudentsWithFlag($p,$d,$f,$fos,$l,$s,"Omitted");
$correctional =$this->getStudentsWithFlag($p,$d,$f,$fos,$l,$s,"Correctional");

if($omitted != null)
{
  foreach ($omitted as $key => $value) {
    $omitted_array [] = $value->id;
  }
}

if($correctional != null)
{
  foreach ($correctional as $key => $value) {
    $corrected_array [] = $value->id;
  }
}
  $users = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['users.fos_id',$fos],['student_regs.level_id',$l],['student_regs.session',$s]])
            ->whereNotIn('users.id',$prob_user_id)
            ->whereNotIn('users.id',$omitted_array)
            ->whereNotIn('users.id',$corrected_array)
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();
   
   return $users;
 }

  //---------------------------------------------------------------------------------------
// get registered omiited students
  public function getRegisteredOmittedStudents($p,$d,$f,$fos,$l,$s)
 {
  // get student that did probation
  
  $prob_user_id = array(); $omitted_array = array();

 $prob_user_id = $this->getprobationStudents($p,$d,$f,$l,$s);

$omitted =$this->getOmittedResultStudents($p,$d,$f,$fos,$l,$s);

if($omitted != null)
{
  foreach ($omitted as $key => $value) {
    $omitted_array [] = $value->id;
  }
}
  $users = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['users.fos_id',$fos],['student_regs.level_id',$l],['student_regs.session',$s]])
            ->whereNotIn('users.id',$prob_user_id)
            ->whereIn('users.id',$omitted_array)
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();
   
   return $users;
 }



 // -------------- get register probation students ----------------------------------------
 public function getRegisteredProbationStudents($p,$d,$f,$fos_id,$l,$s,$season)
 {
  $prob_user_id = $this->getprobationStudents($p,$d,$f,$l,$s);
    $user = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'student_regs.user_id', '=', 'users.id')
            ->where('users.fos_id',$fos_id)
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['student_regs.season',$season],
                ['student_regs.session',$s],['student_regs.level_id',$l],['student_regs.semester',1]])
            ->whereIn('users.id',$prob_user_id)
            ->orderBy('users.matric_number','ASC')
            ->select('student_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.fos_id','users.entry_year')
            ->get();

            return $user;
 }

 // -------------- get register probation students for report ----------------------------------------
 public function getRegisteredProbationStudentsForReport($p,$d,$f,$fos,$l,$s)
 {
  $prob_user_id = $this->getprobationStudents($p,$d,$f,$l,$s);
  $users = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['users.fos_id',$fos],['student_regs.level_id',$l],['student_regs.session',$s]])
            ->whereIn('users.id',$prob_user_id)
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();

            return $users;
 }
  //------------------------get resit registered students-----------------------------------------------

  public function getResitRegisteredStudents($p,$d,$f,$fos,$l,$s,$season)
 {
  $users = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
            ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['users.fos_id',$fos],['student_regs.level_id',$l],['student_regs.session',$s],['student_regs.season',$season]])
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();
   
   return $users;
 }

 public function SelectedResitRegisteredStudents($arrayId,$l,$s,$season)
 {
  $users = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
            ->where([['student_regs.level_id',$l],['student_regs.session',$s],['student_regs.season',$season]])
            ->whereIn('users.id',$arrayId)
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();
   
   return $users;
 }

 //------------------------------ get students who are on omitted result type ---------------------------
 public function getOmittedResultStudents($p,$d,$f,$fos,$l,$s)
 {
    $users = DB::connection('mysql2')->table('users')
            ->join('student_results', 'users.id', '=', 'student_results.user_id')
            ->where([['users.programme_id',$p],['users.department_id',$d],['users.faculty_id',$f],['users.fos_id',$fos],['student_results.level_id',$l],['student_results.session',$s],['student_results.flag','Omitted']])
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();
            return $users;
 }
 //============================================END OF REPORT=============================================

//================================== custom function =========================================================

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
    $d =DB::table('register_courses')
    ->where([['semester_id',$id],['level_id',$l],['fos_id',$f],['session',$s]])->get();
    return response()->json($d); 
}

 public function getFosPara($id)
    {
     $d =DB::table('fos')->find($id);
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
//========================== get result ======================
    private function getResult($id){
      $result =DB::connection('mysql2')->table('student_results')
                       ->where('coursereg_id',$id)
                       ->first();
                     return $result;
     
 }

 //========================= student management====================

 public function studentManagement(){
  return view('desk.studentManagement.index');
 }

 public function studentManagementAddCourses()
 {
  $level =Level::where('programme_id',Auth::user()->programme_id)->get();
  $fos =$this->get_fos();
  return view('desk.studentManagement.addCourse')->withL($level)->withF($fos);
 }

 public function getStudentManagementAddCourse(Request $request)
 {
  $level =Level::where('programme_id',Auth::user()->programme_id)->get();
  $semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
  $fos_id =$this->get_fos();
 
$this->validate($request,array('fos'=>'required','session_id'=>'required','level'=>'required'));
$session =$request->session_id;
$fos =$request->fos;
$l =$request->level;
$season =$request->season;
$p =Auth::user()->programme_id;
$d =Auth::user()->department_id;
$f =Auth::user()->faculty_id;
$fos_name =Fos::find($fos);

$prob_user_id = $this->getprobationStudents($p,$d,$f,$l,$session);
$registeStudent =$this->registerdStudents($fos,$p,$d,$f,$season,$session,$l,$prob_user_id);
$register_course =RegisterCourse::where([['programme_id',$p],['department_id',$d],['faculty_id',$f],['fos_id',$fos],['level_id',$l],['session',$session]])->orderBy('semester_id','ASC')->orderBy('reg_course_status','ASC')->get();
return view('desk.studentManagement.addCourse')->withL($level)->withS($semester)->withF($fos_id)->withR($register_course)->withG_s($session)->withG_l($l)->withFos($fos)->withFn($fos_name)->withRs($registeStudent)->withSeason($season);
 }

public function postStudentManagementAddCourse(request $request)
{
$studentsId =$request->ids;
$regCourseId =$request->idc;
$level =$request->level_id;
$season =$request->season;
$session =$request->session;
$fos =$request->fos_id;
$code = $request->input('code');
$status = $request->input('status');
$semester = $request->input('semester');
$title = $request->input('title');
$courseId = $request->input('course_id');
$unit = $request->input('unit');

if($regCourseId == null)
{
  Session::flash('warning',"courses was not selected");
  return back();
}
if($studentsId == null)
{
  Session::flash('warning',"students was not selected");
  return back();
}
$data =array();
foreach($studentsId as $v)
{
 
 $course_unit = $this->getTotalCourseunit($fos,$session,$level);
 
 $newCourseRegTotal = 0;
  $courseRegTotalFirstSemester =$this->getTotalCourseUnitPerSemster($v,$session,1,$level,$season);
  $courseRegTotalSecondSemester =$this->getTotalCourseUnitPerSemster($v,$session,2,$level,$season);

 foreach($regCourseId as $vc)
 {
  $checkCourse = DB::connection('mysql2')->table('course_regs')
  ->where([['user_id',$v],['level_id',$level],['session',$session],
  ['period',$season],['registercourse_id',$vc],['course_id',$courseId[$vc]]])
  ->first();
  if($checkCourse == null)
  {
    $status_code =$status[$vc];
    if($status[$vc] == 'G')
    {
      $courseReg =DB::connection('mysql2')->table('course_regs')
      ->where([['user_id',$v],['course_id',$courseId[$vc]],['level_id','<',$level]])
      ->first();
      if($courseReg == null)
      {
     $status_code ='D';
      }else{
     $status_code='R';
      }
    }
     // check for the total unit  

    //get student reg
    $studentReg = DB::connection('mysql2')->table('student_regs')
  ->where([['user_id',$v],['level_id',$level],['session',$session],
  ['season',$season],['semester',$semester[$vc]]])
  ->first();
if($semester[$vc] == 1)
{
  // first semster
  $courseRegTotalFirstSemester += $unit[$vc];
  //check if its drop or repeat

  
 //echo $courseRegTotalFirstSemester.'-'.$v.'='.$vc.'='.$semester[$vc].'<br/>';
 if($courseRegTotalSecondSemester <= $course_unit->max)
 {
    $data [] =['studentreg_id'=>$studentReg->id,'registercourse_id'=>$vc,'user_id'=>$v,
    'level_id'=>$level,'semester_id'=>$semester[$vc],'session'=>$session,'period'=>$season,
    'course_id'=>$courseId[$vc],'course_title'=>$title[$vc],'course_code'=>$code[$vc],
    'course_unit'=>$unit[$vc],'course_status'=>$status_code];
 }
 
}elseif($semester[$vc] == 2)
{// second semester
   $courseRegTotalSecondSemester += $unit[$vc];
  
 // echo $courseRegTotalSecondSemester.'-'.$v.'='.$vc.'='.$semester[$vc].'<br/>';
  if($courseRegTotalSecondSemester <= $course_unit->max)
  {
     $data [] =['studentreg_id'=>$studentReg->id,'registercourse_id'=>$vc,'user_id'=>$v,
     'level_id'=>$level,'semester_id'=>$semester[$vc],'session'=>$session,'period'=>$season,
     'course_id'=>$courseId[$vc],'course_title'=>$title[$vc],'course_code'=>$code[$vc],
     'course_unit'=>$unit[$vc],'course_status'=>$status_code];
  }
}
 

  }
 }
}

if(count($data) != 0)
{
  DB::connection('mysql2')->table('course_regs')->insert($data);
  Session::flash('success',"successful");
  return back();

}
Session::flash('warning',"courses is not added.Check the students total credit, you can not register more than its required unit");
  return back();

}
}
