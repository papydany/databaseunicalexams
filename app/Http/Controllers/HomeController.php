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
use App\RegisterCourse;
use App\AssignCourse;
use App\PdsModernCourse;
use App\CourseReg;
use App\Pin;
use App\StudentResult;
use App\StudentReg;
use App\Contact;
use App\Course;
use Auth;
use bcrypt;
use Mail;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
class HomeController extends Controller
{
    Const DESKOFFICER =3;
    Const PDS =6;
    Const ModernLanguage =7;
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
    return view('admin.index');
    }
    //==============================contact mail ===================================================
    public function contactMail()
    {
      $sql = Contact::where('status',0)->orderBy('id','desc')->get();
      return view('admin.contactMail')->withC($sql);
    }
// ======================reeply email ===================
    public function replyemail(Request $request)
    {
   $email =strtolower($request->email);
   $email = preg_replace('/\s+/', '', $email);
   $body =$request->reply;
   $id =$request->id;
  
   $data = array('email' => $email,'body' => $body);

  Mail::send(array('html'=>'emails.reply'), $data, function($message) use ($data)  {
                
                $message->to($data['email'],$data['body']);
                $message->subject("Reply From Result database");

            });

  $c =Contact::find($id);
  $c->status = 1;
  $c->save();
  $request->session()->flash('success', 'Successful!');
 return redirect()->action('HomeController@contactMail'); 
    }    

    //=============================admin student details ===============================
    public function admin_studentdetails(Request $request)
    {
      $matric_number =$request->matric_number;
      $users = DB::connection('mysql2')->table('users')
      ->where('matric_number',$matric_number)
      ->first();
      if(count($users) > 0)
      {
        $stdReg = DB::connection('mysql2')->table('student_regs')->where('user_id',$users->id)->get();
$f =Faculty::get();
return view('admin.admin_studentdetails')->withU($users)->withSr($stdReg)->withF($f);
      }
 $request->session()->flash('warning', 'Students matric number does not exist');
 return redirect()->action('HomeController@index'); 
    }

//============================================================================================
    public function updatedepartment(Request $request)
    {
      $u =DB::connection('mysql2')->table('users')
            ->where('id', $request->user_id)
            ->update(['faculty_id' =>$request->faculty_id,'department_id' => $request->department_id,'fos_id' => $request->fos_id]);
           
    }

    //====================  edit images==============================================
   /* public function edit_image($id)
    {
      $users = DB::connection('mysql2')->table('users')
      ->find($id);
  
     return view('admin.edit_image')->withU($users);
    }

      public function post_edit_image(Request $request)
    {
       $users = DB::connection('mysql2')->table('users')
      ->find($request->id);
     
     if(count($users) > 0)
     {
      if($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $filename = time() . '.' . $image->getClientOriginalExtension();

           $destinationPath = 'https://unicalexams.edu.ng/img/student';
            $img = Image::make($image->getRealPath());
            $img->resize(150, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
        $users->image_url = $filename;
        $users->save();
        Session::flash('success',"successfull.");

          }
     }
  
return view('admin.edit_image')->withU($users);
    }*/
    //===============================autocomplte department =========================================
     public function autocomplete_department(Request $request)
    {
  $data = Department::select("search_name as name")->where("search_name","LIKE","%{$request->input('query')}%")->distinct()->get();
 return response()->json($data);
    }
    //========================= number of registered students =========================================
    public function admin_getRegStudents()
    {
    return view('admin.admin_getRegStudents');
    }
      public function post_getRegStudents(Request $request)
    {
      $s = $request->session;
      $s_type = $request->student_type;
      $st = Pin::where([['status',1],['session',$s],['student_type',$s_type]])->get()->count();
   
    return view('admin.admin_getRegStudents')->withN($st);
    }

     //========================= course registered students =========================================
    public function admin_courseRegStudents()
    {
      $d = Department::orderBy('department_name','ASC')->get();  
    return view('admin.admin_courseRegStudents')->withD($d);
    }
      public function post_courseRegStudents(Request $request)
    {
      $dd = Department::orderBy('department_name','ASC')->get(); 
      $s = $request->session;
      $fos = $request->fos;
      $d = $request->department;
      $l = $request->level;
      $semester = $request->semester;

      $users = DB::connection('mysql2')->table('users')
            ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
            ->where([['users.fos_id',$fos],['student_regs.department_id',$d],['student_regs.session',$s],['student_regs.semester',$semester],['student_regs.level_id',$l]])
            ->select('student_regs.*','users.surname','users.firstname','users.othername','users.matric_number')
            ->get();
    return view('admin.admin_courseRegStudents')->withU($users)->withD($dd)->withL($l)->withS($s)->withSm($semester);
    }

    //==================== delete course registered students ==============================
function delete_courseRegStudents($id)
{
$coureg_id =array();
  $course_reg = CourseReg::where('studentreg_id',$id)->get();
  foreach ($course_reg as $key => $value) {
    $coureg_id [] =$value->id;
  $result = StudentResult::where('coursereg_id',$value->id)->first();

  if(count($result) > 0)
  {
    // delete result one after the other
    $result_delete =StudentResult::destroy($result->id);
  }
  }
  // delete course reg
$check_delete = CourseReg::destroy($coureg_id);
// delete the student reg
$studentreg_delete =StudentReg::destroy($id);

Session::flash('success',"successfull.");
return back();
}

function delete_multiple_courseRegStudents(Request $request)
{$coureg_id =array();
       $variable = $request->input('id');
     if($variable == null)
{
    return back();
}

$course_reg = CourseReg::whereIn('studentreg_id',$variable)->get();
  foreach ($course_reg as $key => $value) {
    $coureg_id [] =$value->id;
  $result = StudentResult::where('coursereg_id',$value->id)->first();

  if(count($result) > 0)
  {
    // delete result one after the other
    $result_delete =StudentResult::destroy($result->id);
  }
  }
  // delete course reg
$check_delete = CourseReg::destroy($coureg_id);
// delete the student reg
$studentreg_delete =StudentReg::destroy($variable );


Session::flash('success',"successfull.");
return back();
}

// ==================   view students =======================================================
public function admin_viewStudents()
{
      $d = Department::orderBy('department_name','ASC')->get();  
   return view('admin.admin_viewStudents')->withD($d);
 }  
      public function post_viewStudents(Request $request)
    {
      $dd = Department::orderBy('department_name','ASC')->get(); 
      $s = $request->session;
      $fos = $request->fos;
      $d = $request->department;
      
      $st = DB::connection('mysql2')->table('users')
      ->where([['entry_year',$s],['fos_id',$fos],['department_id',$d]])->orderBy('matric_number','ASC')->get();
   
    return view('admin.admin_viewStudents')->withU($st)->withD($dd)->withDid($d)->withFosid($fos)->withS($s);
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
    $f = Faculty::orderBy('faculty_name','ASC')->get();
    return view('admin.view_department')->withF($f);
}

public function post_view_department(Request $request)
{
     
    $f = Faculty::orderBy('faculty_name','ASC')->get();
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
       
    $f = Faculty::orderBy('faculty_name','ASC')->get();
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
    $d = Department::orderBy('department_name','ASC')->get();
    return view('admin.view_fos')->withD($d);
}
//==============================post view ============================================================
public function post_view_fos(Request $request)
{
      $d = Department::orderBy('department_name','ASC')->get();
     $this->validate($request,array('department_id'=>'required',));
     $id =$request->department_id;

     $fos = Fos::where('department_id',$id)->get();

     return view('admin.view_fos')->withFos($fos)->withD($d);
}


//==============================edit fos=================================
public function edit_fos($id)
{
    $f =Fos::find($id);
    return view('admin.edit_fos')->withF($f);
}

//==============================update fos=================================
public function post_edit_fos(Request $request)
{
    $id = $request->id;
   $f =Fos::find($id);
  $f->fos_name = strtoupper($request->fos_name);
  $f->duration =$request->duration;
  $f->save();
   Session::flash('success',"SUCCESSFULL.");
    return redirect()->action('HomeController@view_fos');
}

//================================ assign fos ========================================================
public function assign_fos()
{

    $d = Department::orderBy('department_name','ASC')->get();
    return view('admin.assign_fos')->withD($d);
}
//====================================post assign fos =====================================================
public function post_assign_fos(Request $request)
{
     $d = Department::orderBy('department_name','ASC')->get();
     $this->validate($request,array('department_id'=>'required',));
     $id =$request->department_id;

     $fos = Fos::where([['department_id',$id],['status',0]])->get();
   // $user = User::where('department_id',$id)->get();

    $user = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
           ->where('users.department_id',$id)
            ->where('user_roles.role_id',self::DESKOFFICER)
            ->select('users.*')
            ->get();

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
   $f = Faculty::orderBy('faculty_name','ASC')->get();
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

    return view('admin.pds_new_desk_officer');
}
//====================================post desk officer =====================================================
public function pds_post_desk_officer(Request $request)
{
     $this->validate($request,array( 
           'name' => 'required|string|max:255',
            'username' => 'required|unique:users',
           'password' => 'required|string|min:6',
          'role'=>'required',));

$user = new User;
$user->title=$request->title;
$user->name =$request->name;
$user->username =$request->username;
$user->password =bcrypt($request->password);
$user->plain_password =$request->password;
$user->faculty_id =0;
$user->department_id =0;
$user->programme_id =1;
$user->fos_id =0;
$user->edit_right =0;
$user->save();

$user_role =DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id' => $request->role]);
Session::flash('success',"SUCCESSFULL.");
return redirect()->action('HomeController@pds_new_desk_officer');

}
//=====================================================================================
public function pds_view_desk_officer()
{
    $users = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->whereIn('user_roles.role_id',[self::PDS,self::ModernLanguage])
            ->orderBy('department_id','ASC')
            ->select('users.*','user_roles.role_id')
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

public function modern_view_course()
{
    $course =PdsModernCourse::orderBy('semester','ASC')->orderBy('code','ASC')->get();
    return view('admin.modern_view_course')->withC($course);
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
//=====================view registered courses ===========================
public function adminreg_course()
{
 $d = Department::orderBy('department_name','ASC')->get();    
 return view('admin.reg_course')->withD($d);
}

function post_adminreg_course(request $request)
{
$this->validate($request,array('fos'=>'required','session'=>'required','level'=>'required'));
$session =$request->session;
$fos =$request->fos;
$l =$request->level;
$d =$request->department;
$register_course =RegisterCourse::where([['department_id',$d],['fos_id',$fos],['level_id',$l],['session',$session]])->orderBy('semester_id','ASC')->orderBy('reg_course_status','ASC')->get();

return view('admin.display_register_course')->withR($register_course)->withG_s($session)->withG_l($l)->withFos($fos)->withD($d);
}
// edit courses reg
function edit_adminreg_course($id,$s)
{
  $getreg =RegisterCourse::where([['id',$id],['session',$s]])->first();
 
  return view('admin.regcourse.edit')->withR($getreg);
}

public function update_adminreg_course(Request $request)
{
  $id =$request->id;
  $s =$request->session;
  $code =$request->code;
  $title =$request->title;
  $status =$request->status;
  $unit =$request->unit;
$getreg =RegisterCourse::where([['id',$id],['session',$s]])->first();

// normal courses first
$course = Course::find($getreg->course_id);
if(count($course) > 0)
{
/*$course->course_title =$title;
$course->course_code =$code;
$course->status =$status;
$course->course_unit =$unit;
$course->save();*/
// update register courses

$getreg->reg_course_title =$title;
$getreg->reg_course_code =$code;
$getreg->reg_course_status =$status;
$getreg->reg_course_unit =$unit;
$getreg->save();

$getcourse = CourseReg::where([['registercourse_id',$getreg->id],['course_id',$getreg->course_id]])->get();

if(count($getcourse) > 0)
{
// update register courses students
$data  =['course_title'=>$title,'course_code'=>$code,'course_unit'=>$unit,'course_status'=>$status];

$c = CourseReg::where('registercourse_id',$getreg->id)->where('course_id',$getreg->course_id)->update($data);

// update result 
$cu [] =['cu'=>$unit];
foreach ($getcourse as $key => $value) {
 $result =StudentResult::where('coursereg_id',$value->id)->first();
 if(count($result) > 0)
 {
  $result->cu = $unit;
 $result->save();
 }
 }
}
  Session::flash('success',"SUCCESSFULL.");
  }else{
    Session::flash('warning',"Please check not on course table.");
  }

return redirect()->action('HomeController@adminreg_course');

}

function delete_adminreg_course($id,$s)
{

  $check = CourseReg::where([['registercourse_id',$id],['session',$s]])->first();
if(count($check) > 0)
{
  Session::flash('warning',"The courses selected has been registered by students.so u can not delete it.");

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

function delete_adminreg_multiple_course(Request $request)
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


// ============================== delete students registration =============
public function deleteRegistration($id)
{
 $courseReg = DB::connection('mysql2')->table('course_regs')->where('studentreg_id',$id)->get();
 if(count($courseReg) > 0)
 {
  foreach ($courseReg as $key => $value) {
    // check students result is present
  $student_results = DB::connection('mysql2')->table('student_results')->where('coursereg_id',$value->id)->first();
  if(count($student_results) > 0)
  {// delete students result 
    DB::connection('mysql2')->table('student_results')->where('id',$student_results->id)->delete();

  }// delete course reg 
   DB::connection('mysql2')->table('course_regs')->where('id',$value->id)->delete();
  }

}// delete student reg 
DB::connection('mysql2')->table('student_regs')->where('id',$id)->delete();
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
// function to get fos


}
