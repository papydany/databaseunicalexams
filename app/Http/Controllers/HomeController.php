<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Faculty;
use App\Department;
use App\Programme;
use App\Fos;
use DB;
use App\User;
use App\Semester;
use App\PdsCourse;
use App\CourseUnit;
use Auth;
use bcrypt;
use Illuminate\Support\Facades\Session;
class HomeController extends Controller
{
    Const DESKOFFICER =3;
    Const PDS =6;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
       $user = DB::table('roles')
            ->join('user_roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_roles.user_id',Auth::user()->id)
            ->first();
            if($user->name =="admin")
            {
              return view('admin.index');
            }
            return redirect($user->name);
    
       
 
 
    }
    //======================================== faculty =====================================
    public function new_faculty()
    {
      return view('admin.new_faculty');
    }

  //======================================== post faculty =====================================
    function post_new_faculty(Request $request)
    {
    $this->validate($request,array('faculty_name'=>'required',));
   
    $check = Faculty::where('faculty_name',strtoupper($request->faculty_name))->first();
    if(count($check) == 1)
    {
    Session::flash('warning',"faculty exist already.");
    return view('admin.new_faculty'); 
    exit();  
    }
    $faculty=new Faculty; 

    $faculty->faculty_name = strtoupper($request->faculty_name);

    $faculty->save();

    Session::flash('success',"SUCCESSFULL.");
    return view('admin.new_faculty'); 
}

//=================================view faculty =====================================
public function view_faculty()
{
    $f = Faculty::all();
     return view('admin.view_faculty')->withF($f); 
}
//==============================edit faculty=================================
public function edit_faculty($id)
{
    $f = Faculty::find($id);
    return view('admin.edit_faculty')->withF($f);
}

//==============================updatefaculty=================================
public function post_edit_faculty(Request $request)
{
  $id = $request->id;
 $f = Faculty::find($id);
  $f->faculty_name = strtoupper($request->faculty_name);
  $f->save();
   Session::flash('success',"SUCCESSFULL.");
    return redirect()->action('HomeController@view_faculty');
}

//======================================== Department =====================================
    public function new_department()
    {
        $f = Faculty::all();
      return view('admin.new_department')->withF($f);
    }

  //======================================== post department =====================================
    function post_new_department(Request $request)
    {
    $this->validate($request,array('faculty_id'=>'required','department_name'=>'required',));

    $faculty_id = $request->faculty_id;
    $department = strtoupper($request->department_name);
   
    $check = Department::where([['faculty_id',$faculty_id],['department_name',$department]])->first();
    if(count($check) == 1)
    {
    Session::flash('warning',"Department exist already.please");
    return $this->new_department();
    exit();  
    }
    $d =new Department; 

    $d->faculty_id = $faculty_id;
    $d->department_name = $department;
    $d->save();

    Session::flash('success',"SUCCESSFULL.");
    return   $this->new_department();
}
//========================================== view department=======================================

public function view_department()
{
    $f = Faculty::all();
    return view('admin.view_department')->withF($f);
}

public function post_view_department(Request $request)
{
     $f = Faculty::all();
     $this->validate($request,array('faculty_id'=>'required',));
     $id =$request->faculty_id;
     $d = Department::where('faculty_id',$id)->get();
     return view('admin.view_department')->withF($f)->withD($d);
}
//==============================edit department=================================
public function edit_department($id)
{
    $d = Department::find($id);
    return view('admin.edit_department')->withD($d);
}

//==============================updatedepartment=================================
public function post_edit_department(Request $request)
{
    $id = $request->id;
  $d = Department::find($id);
  $d->department_name = strtoupper($request->department_name);
  $d->save();
   Session::flash('success',"SUCCESSFULL.");
    return redirect()->action('HomeController@view_department');
}

//======================================== Programme =====================================
    public function new_programme()
    {
      return view('admin.new_programme');
    }

  //======================================== post programme =====================================
    function post_new_programme(Request $request)
    {
    $this->validate($request,array('programme_name'=>'required',));

    $p = strtoupper($request->programme_name);
   
    $check = Programme::where('programme_name',$p)->first();
    if(count($check) == 1)
    {
    Session::flash('warning',"Programme exist already.please");
    return $this->new_programme();
    exit();  
    }
    $pg =new Programme; 
   $pg->programme_name = $p;
    $pg->save();
    Session::flash('success',"SUCCESSFULL.");
    return  $this->new_programme();
}
//========================================== view programme=======================================

public function view_programme()
{
    $p = Programme::all();
    return view('admin.view_programme')->withP($p);
}

//======================================== Fos =====================================
    public function new_fos(){
        $f = Faculty::all();  
        $p = Programme::all(); 
      return view('admin.new_fos')->withF($f)->withP($p);
    }
    

  //======================================== post fos =====================================
    function post_new_fos(Request $request)
    {
    $this->validate($request,array(
        'fos_name'=>'required',
        'department_id'=>'required',
        'programme_id'=>'required',
        'duration'=>'required',));

    $fos = strtoupper($request->fos_name);
   
    $check = Fos::where('fos_name',$fos)->first();
    if(count($check) == 1)
    {
    Session::flash('warning',"fos exist already.please");
    return $this->new_fos();
    exit();  
    }
    $f =new Fos; 
   $f->fos_name = $fos;
   $f->department_id =$request->department_id;
   $f->programme_id = $request->programme_id;
   $f->duration = $request->duration;
   $f->status = 0; // not assign
    $f->save();
    Session::flash('success',"SUCCESSFULL.");
    return  $this->new_fos();
}
//========================================== view fos=======================================
public function view_fos()
{
    $d = Department::all();
    return view('admin.view_fos')->withD($d);
}
//==============================post view ============================================================
public function post_view_fos(Request $request)
{
     $d = Department::all();
     $this->validate($request,array('department_id'=>'required',));
     $id =$request->department_id;

     $fos = Fos::where('department_id',$id)->get();

     return view('admin.view_fos')->withFos($fos)->withD($d);
}

//================================ assign fos ========================================================
public function assign_fos()
{

    $d = Department::all();
    return view('admin.assign_fos')->withD($d);
}
//====================================post assign fos =====================================================
public function post_assign_fos(Request $request)
{
     $d = Department::all();
     $this->validate($request,array('department_id'=>'required',));
     $id =$request->department_id;

     $fos = Fos::where([['department_id',$id],['status',0]])->get();
    $user = User::where('department_id',$id)->get();
     return view('admin.assign_fos')->withFos($fos)->withD($d)->withU($user);
}
//=================================================================================================================
public function assign_fosdesk(Request $request)
{
    $variable = $request->input('fos');
$this->validate($request,array('deskofficer'=>'required',));
if($variable == null)
{
    return back();
}
$u_id =$request->deskofficer;
// status 1 mean fos is assign and 0 mean not assigned
foreach ($variable as $key => $value) {
  $v[] = ['fos_id'=>$value,'user_id'=>$u_id,'status'=>1];

}

DB::table('deskoffice_fos')->insert($v);
foreach ($variable as $key => $value) {
DB::table('fos')->where('id',$value)->update(['status'=>1]);
}
Session::flash('success','successfull');
return redirect()->action('HomeController@assign_fos');
}
//========================================== view desk officer=======================================
public function new_desk_officer()
{
    $f = Faculty::all();
    $p = Programme::all(); 
    return view('admin.new_desk_officer')->withF($f)->withP($p);
}
//====================================post desk officer =====================================================
public function post_desk_officer(Request $request)
{
     $this->validate($request,array( 
           'name' => 'required|string|max:255',
            'username' => 'required|unique:users',
           'password' => 'required|string|min:6',
           'faculty_id'=>'required',
           'department_id'=>'required',
           'programme_id'=>'required',));

$user = new User;
$user->name =$request->name;
$user->username =$request->username;
$user->password =bcrypt($request->password);
$user->plain_password =$request->password;
$user->faculty_id =$request->faculty_id;
$user->department_id = $request->department_id;
$user->programme_id =$request->programme_id;
$user->fos_id =0;
$user->edit_right =0;

$user->save();
$role =Role::find(3);
$user_role =DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id' => $role->id]);
Session::flash('success',"SUCCESSFULL.");
return redirect()->action('HomeController@new_desk_officer');

}

public function view_desk_officer()
{
    $users = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id',self::DESKOFFICER)
            ->orderBy('username','ASC')
            ->select('users.*')
            ->paginate(20);
        return view('admin.view_desk_officer')->withU($users);        
}
//========================================== Pds new desk officer=======================================
public function pds_new_desk_officer()
{
  $p = Programme::find(1); 
    return view('admin.pds_new_desk_officer')->withP($p);
}
//====================================post desk officer =====================================================
public function pds_post_desk_officer(Request $request)
{
     $this->validate($request,array( 
           'name' => 'required|string|max:255',
            'username' => 'required|unique:users',
           'password' => 'required|string|min:6',
          'programme_id'=>'required',));

$user = new User;
$user->title=$request->title;
$user->name =$request->name;
$user->username =$request->username;
$user->password =bcrypt($request->password);
$user->plain_password =$request->password;
$user->faculty_id =0;
$user->department_id =0;
$user->programme_id =$request->programme_id;
$user->fos_id =0;
$user->edit_right =0;
$user->save();

$role =Role::find(6);
$user_role =DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id' => $role->id]);
Session::flash('success',"SUCCESSFULL.");
return redirect()->action('HomeController@pds_new_desk_officer');

}
//======================================================================================================================
public function pds_view_desk_officer()
{
    $users = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id',self::PDS)
            ->orderBy('department_id','ASC')
            ->select('users.*')
            ->paginate(20);
        return view('admin.pds_view_desk_officer')->withU($users);        
}

//-------------------------------------predegree new courses ----------------------------------------------
public function pds_create_course()
{
  
    return view('admin.pds_create_course');
}
//-------------------------------------new courses ----------------------------------------------
    function pds_post_create_course(Request $request)
    {
          $variable = $request->input('f_course_code');
          $title = $request->input('course_title');
          $s_course_code = $request->input('s_course_code');
    if($variable == null)
{
    Session::flash('warning',"course Code is empty");
    return back();
}
        foreach ($variable as $key => $value) {
        if(!empty($value)) {
            $cc =strtoupper(str_ireplace(" ","",$value));
          $bb =strtoupper(str_ireplace(" ","",$s_course_code[$key]));
        $clean_list[$cc] =array('course_title'=>$title[$key],'f_course_code'=>$cc,'s_course_code'=>$bb  );
        }
        }

 foreach($clean_list as $kk=>$vv ){
$course_code[] = $vv['f_course_code'];
}

$check =PdsCourse::whereIn('f_course_code',$course_code)->get();
if(count($check) > 0)
{
foreach ($check as $key => $value) {
    unset($clean_list[$value->course_code]);
}
        
}
    if(count($clean_list) != 0)
    {
        
 foreach($clean_list as $k=>$v ){
    
$data[] =['course_title' => $clean_list[$k]['course_title'],'f_course_code' =>$clean_list[$k]['f_course_code'],'s_course_code' =>$clean_list[$k]['s_course_code']];

}
DB::table('pds_courses')->insert($data);
    Session::flash('success',"SUCCESSFULL.");
return redirect()->action('HomeController@pds_create_course');
}
}
//-------------------------------------pds view courses ----------------------------------------------

public function pds_view_course()
{
    $course =PdsCourse::orderBy('course_title','ASC')->get();
    return view('admin.pds_view_course')->withC($course);
}
//--------------------------------------- Edit right---------------------------------------------------
public function edit_right($id,$e)
{
  if(isset($id))
  {
$user = User::find($id);
$user->edit_right =$e;
$user->save();
   Session::flash('success',"SUCCESSFULL.");
return back();
  }
}

//-----------------------------------create course unit -----------------------------------------------
public function create_course_unit()
{
    return view('admin.create_course_unit');
}
//-----------------------------------post create course unit -----------------------------------------------
public function post_create_course_unit(Request $request)
{
  $course_unit = new CourseUnit;
  $course_unit->session =$request->session;
  $course_unit->level =0;
  $course_unit->fos =0;
  $course_unit->min =$request->min;
  $course_unit->max =$request->max;
 $course_unit->save();
  Session::flash('success',"SUCCESSFULL.");
return back();
 
  
}
//-----------------------------------create course unit -----------------------------------------------
public function create_course_unit_special()
{
  $d = Department::get();
    return view('admin.create_course_unit_special')->withD($d);
}
//-----------------------------------post create course unit -----------------------------------------------
public function post_create_course_unit_special(Request $request)
{
  $c =CourseUnit::where([['session',$request->session],['fos',$request->fos],['level',$request->level]])->get();

  if(count($c) == 0)
  {
  $course_unit = new CourseUnit;
  $course_unit->session =$request->session;
  $course_unit->level =$request->level;
  $course_unit->fos =$request->fos;
  $course_unit->min =$request->min;
  $course_unit->max =$request->max;
 $course_unit->save();
  Session::flash('success',"SUCCESSFULL.");
}else{
   Session::flash('warning',"course unit for these field of study have been set already.");
}
return back();
 
  
}
// ================ change password ===========================
public function changepassword()
{
 
 return view('admin.changepassword');
}
// ================ post change password ===========================
public function post_changepassword(Request $request)
{
 $this->validate($request,array('password' => 'required',));
 $password =$request->password;
 $user = User::find(Auth::user()->id);
 $user->password =bcrypt($password); 
 $user->plain_password =$password;
 $user->save();
   Session::flash('success',"successfull.");

return back();
}
//-------------------------------------------success---------------------------------------------
public function success()
{
   return view('admin.view_course_unit');
}
//-----------------------------------view  course unit -----------------------------------------------
public function view_course_unit()
{
 return view('admin.view_course_unit');
}
//-----------------------------------view  course unit -----------------------------------------------
public function post_view_course_unit(Request $request)
{
    $c =CourseUnit::where('session',$request->session)->get();
 return view('admin.view_course_unit')->withC($c);
}
//========================================================================================
// function to get department
 public function getDepartment($id)
    {
  
    $d =Department::where('faculty_id', $id)->get();
    return response()->json($d);
    }
// function to get fos
 public function getFos($id)
    {
     $d =Fos::where('department_id', $id)->get();
    return response()->json($d);
    }
}
