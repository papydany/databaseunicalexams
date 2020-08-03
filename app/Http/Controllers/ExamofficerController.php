<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Auth;
use App\Role;
use App\Faculty;
use App\Department;
use App\Programme;
use App\Fos;
use App\Level;
use App\Semester;
use App\StudentResult;
use DB;
use App\User;
use App\Course;
use App\RegisterCourse;
use App\AssignCourse;
use App\CourseReg;
use App\DeskofficeFos;
use App\Service\R;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\MyTrait;
class ExamofficerController extends Controller
{
	use MyTrait;

   public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {
     $p =$this->getp();

  return view('examofficer.index')->withP($p);
    }
//-----------------------------------------------------------------------------------------------------------------

    public function eo_assign_courses(Request $request)
    {
  $this->validate($request,array('programme'=>'required','session'=>'required','level'=>'required','semester'=>'required',));
  $p =$request->input('programme');
  $l =$request->input('level');
  $semester =$request->input('semester');
  $session =$request->input('session');
  $d =Auth::user()->department_id;
  $f =Auth::user()->faculty_id;
  $id=Auth::user()->id;
  $f_id = $this->get_fos_exams_officer_and_hod($id,$d,$p);
  $course =$course = $this->getRegisterAssign_courses($id,$l,$semester,$session,$d,$f,$f_id);
 return view('examofficer.eo_assign_courses')->withC($course)->withSm($semester)->withS($session)->withL($l)->withFos($f_id)->withP($p);

    }
//---------------------------------------- get student  by course -----------------------------------
  public  function eo_result_c(Request $request)
    {  
      $id =$request->input('id');
      $result_type =$request->input('result_type'); 
      $l =$request->input('level');   
      $sm =$request->input('semester'); 
      $s =$request->input('session'); 
  $period =$request->input('period'); 
  $registercourse = RegisterCourse::find($id);
   $d =Auth::user()->department_id;
  $f =Auth::user()->faculty_id;
  $p =$request->input('programme_id'); 

  $prob_user_id = $this->getprobationStudents($p,$d,$f,$l,$s);
  //dd($prob_user_id);

  if($result_type == "Omitted")
    {
      $user_with_no_result =array();
      $coursereg =CourseReg::where([['registercourse_id',$id],['period',$period]])->get();
      foreach ($coursereg as $key => $value) {
        $result =DB::connection('mysql2')->table('student_results')
                         ->where('coursereg_id',$value->id)
                         ->first();
        if($result == null){
       $user_with_no_result [] = $value->user_id;
       }               

      }
      $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where([['course_regs.registercourse_id',$id],['level_id',$l],['semester_id',$sm],['session',$s],['period',$period]])
        ->whereIn('users.id',$user_with_no_result)
        ->whereNotIn('users.id',$prob_user_id)
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.entry_year')
        ->get();
      }else{

      $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where([['course_regs.registercourse_id',$id],['level_id',$l],['semester_id',$sm],['session',$s],['period',$period]])
        ->whereNotIn('users.id',$prob_user_id)
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.entry_year')
        ->get();
      }
     // dd($user);
  //Get current page form url e.g. &page=6
        $url ="eo_result_c?id=".$id."&level=".$l."&semester=".$sm."&session=".$s."&period=".$period."&result_type=".$result_type;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($user);

        //Define how many items we want to be visible in each page
        $perPage = 50;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage- 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

       // return view('search', ['results' => $paginatedSearchResults]);
    
      return view('examofficer.eo_result_c')->withU($paginatedSearchResults)->withUrl($url)->withC($registercourse)->withRt($result_type);
    }  

//=========================result insert for student percourse ==========================

    public function eo_insert_result(Request $request)
    {
        //$this->validate($request,array('id'=>'required',));
        $flag = $request->input('flag');
       // dd($flag);
        $date = date("Y/m/d H:i:s");
        $url =$request->input('url');

        $id =$request->input('id');
        if($id == null)
{
Session::flash('warning',"the result you want to submit must be checked by your right hand.");
return back();
}

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
        //$total=$request->input('total')[$value];
        $total=$ca + $exam;
        $entry_year=$request->input('entry_year')[$value];
        $grade_value =$this->get_grade($total,$entry_year);
        $grade = $grade_value['grade'];
        $cp = $this->mm($grade, $cu,$entry_year);

        if($ca ==''){$ca=0;}
          if($exam ==''){$exam=0;}
          if($total ==''){$total=0;}
     

      $check_result = StudentResult::where([['level_id', $l_id], ['session', $session], ['course_id', $course_id], ['coursereg_id', $coursereg_id],['flag',$flag]])->first();
                    if ($check_result != null) {
        $result_id =$request->input('result_id')[$value];


      
$update = StudentResult::find($result_id);
            $update->ca = $ca;
            $update->exam = $exam;
            $update->total = $total;
            $update->grade = $grade;
            $update->cp = $cp['cp'];
            $update->examofficer = Auth::user()->id;
            $update->save();
         }else{

          
               
                        $insert_data[] = ['user_id'=>$user_id,'matric_number'=>$mat_no,'course_id'=>$course_id,'coursereg_id'=>$coursereg_id,'ca'=>$ca,'exam'=>$exam,'total'=>$total,'grade'=> $grade,'cu'=>$cu,'cp'=>$cp['cp'],'level_id'=>$l_id,
                            'session'=>$session,'semester'=>$semester,'status'=>0,'season'=>$season,'flag'=>$flag,'examofficer'=>Auth::user()->id,'post_date'=>$date,'approved'=>0];
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
      //  return redirect($url);
    }
//--------------------------------------------view result --------------------------------------------------
    public function v_result()
    {
   $p =$this->getp();
return view('examofficer.view_result')->withP($p);
    }

//-----------------------------------------------------------------------------------------------------------------

    public function post_v_result(Request $request)
    {
      $pp =$this->getp();
  $this->validate($request,array('programme'=>'required','session'=>'required','level'=>'required','semester'=>'required',));
  $p =$request->input('programme');
  $l =$request->input('level');
  $semester =$request->input('semester');
  $session =$request->input('session');
  $d =Auth::user()->department_id;
  $f =Auth::user()->faculty_id;
  $id=Auth::user()->id;
  $f_id = $this->get_fos_exams_officer_and_hod($id,$d,$p);
  $course = $course = $this->getRegisterAssign_courses($id,$l,$semester,$session,$d,$f,$f_id);
  return view('examofficer.view_result')->withC($course)->withSm($semester)->withS($session)->withL($l)->withP($pp);

    }    

//-----------------------------------------display result ----------------------------------------------------
 
 public function display_result(Request $request)
 {
   $c_id =$request->input('id');
     $xc = explode('~', $c_id);
    $id = $xc[0];
     $f_id = $xc[1];
      $course_code = $xc[2]; 
   $p =$request->input('programme');
  $l =$request->input('level');
  $sm =$request->input('semester');
  $s =$request->input('session');
  $period =$request->input('period');

$user= $this->getRegisterStudent($id,$l,$sm,$s,$period);
  return view('examofficer.display_result')->withU($user)->withSm($sm)->withS($s)->withL($l)->withF_id($f_id)->withCourse_code($course_code);
 }

 //--------------------------------------------view result --------------------------------------------------
    public function r_student()
    {
         $p =$this->getp();
return view('examofficer.r_student')->withP($p);
    }

//-----------------------------------------------------------------------------------------------------------------

    public function post_r_student(Request $request)
    {
      $pp =$this->getp();
  $this->validate($request,array('programme'=>'required','session'=>'required','level'=>'required','semester'=>'required',));
  $p =$request->input('programme');
  $l =$request->input('level');
  $semester =$request->input('semester');
  $session =$request->input('session');
  $d =Auth::user()->department_id;
  $f =Auth::user()->faculty_id;
  $id=Auth::user()->id;
  $fos_id =Fos::where([['department_id',$d],['programme_id',$p]])->get();
  foreach ($fos_id as $key => $value) {
  $f_id[] =$value->id;
  }

$course = $this->getRegisterAssign_courses($id,$l,$semester,$session,$d,$f,$f_id);
  

          return view('examofficer.r_student')->withC($course)->withSm($semester)->withS($session)->withL($l)->withP($pp);

    }

 //-----------------------------------------display result ----------------------------------------------------
 
 public function d_student(Request $request)
 {
   $c_id =$request->input('id');
     $xc = explode('~', $c_id);
    $id = $xc[0];
     $f_id = $xc[1];
      $course_code = $xc[2]; 
   $p =$request->input('programme');
  $l =$request->input('level');
  $sm =$request->input('semester');
  $s =$request->input('session');
  $period =$request->input('period');
$user= $this->getRegisterStudent($id,$l,$sm,$s,$period);

 
  return view('examofficer.d_student')->withU($user)->withSm($sm)->withS($s)->withL($l)->withF_id($f_id)->withCourse_code($course_code);
 }
 //---------------------------------- delete result -------------------------------------------
 public function eo_delete_result()
 {
  $p =$this->getp();

  return view('examofficer.delete_result.index')->withP($p); 
 } 

 public function post_eo_delete_result(Request $request)
 {
  $p =$this->getp();
  $this->validate($request,array('programme'=>'required','session'=>'required','level'=>'required','semester'=>'required',));
  $pp =$request->input('programme');
  $l =$request->input('level');
  $semester =$request->input('semester');
  $session =$request->input('session');
  $d =Auth::user()->department_id;
  $f =Auth::user()->faculty_id;
  $id=Auth::user()->id;
  $f_id = $this->get_fos_exams_officer_and_hod($id,$d,$pp);
  $fos_id =Fos::where([['department_id',$d],['programme_id',$pp]])->get();
 $course =$course = $this->getRegisterAssign_courses($id,$l,$semester,$session,$d,$f,$f_id);
//dd($course);
return view('examofficer.delete_result.index')->withC($course)->withSm($semester)->withS($session)->withL($l)->withFos($f_id)->withP($p)->withPp($pp);

 } 

 public function eo_delete_result_detail(Request $request)
 {
   $reg_id =$request->input('id');
  $l =$request->input('level');
  $sm =$request->input('semester');
  $s =$request->input('session');
  $period =$request->input('period');
  $registercourse = RegisterCourse::find($reg_id);
 $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where([['course_regs.registercourse_id',$reg_id],['level_id',$l],['semester_id',$sm],['session',$s],['period',$period]])
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number')
        ->get();
       
  return view('examofficer.delete_result.detail')->withU($user)->withSm($sm)->withS($s)->withL($l)->withC($registercourse);
 }
 

 function eo_delete_desk_result($id)
{


$reg =StudentResult::destroy($id);

Session::flash('success',"successfull.");
return redirect()->action('ExamofficerController@eo_delete_result');
}

function eo_delete_desk_multiple_result(Request $request)
{
 $variable = $request->input('id');
  if($variable == null)
{Session::flash('warning',"you have not select any result.");
   return redirect()->action('ExamofficerController@eo_delete_result');
}

$reg =StudentResult::destroy($variable);

Session::flash('success',"successfull.");
return redirect()->action('ExamofficerController@eo_delete_result');
}
 
 //----------------------------------------------------------------------------------------------------------

 public function getRegisterAssign_courses($id,$l,$semester,$session,$d,$f,$f_id)
 {
  $role =$this->getrolename($id);
   if($role == "examsofficer")
   {
    $course =RegisterCourse::where([['semester_id',$semester],['level_id',$l],['session',$session]])
    ->wherein('fos_id',$f_id)
    ->get()
    ->groupBy('fos_id');
   }else{
   $course = DB::table('assign_courses')
        ->join('register_courses', 'register_courses.id', '=', 'assign_courses.registercourse_id')
        ->where([['assign_courses.user_id',$id],['assign_courses.level_id',$l],['assign_courses.semester_id',$semester],['assign_courses.session',$session],['assign_courses.department_id',$d],['assign_courses.faculty_id',$f]])
        ->wherein('assign_courses.fos_id',$f_id)
        ->orderBy('register_courses.reg_course_status','ASC')
        ->orderBy('register_courses.reg_course_code','ASC')
        ->get()->groupBy('fos_id');
   }
    
        return $course;
 }

 
 //---------------------------------------------------------------------------------------------------
 public function getRegisterStudent($id,$l,$sm,$s,$period)
 {
  $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where([['course_regs.registercourse_id',$id],['level_id',$l],['semester_id',$sm],['session',$s],['period',$period]])
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number','users.image_url')
        ->get();
        return $user;
 }
 public function getlevel($id)
{
$level =Level::where('programme_id',$id)->get();
   return response()->json($level);
}
public function getsemester($id)
{
   $semester =Semester::where('programme_id',$id)->get();
   return response()->json($semester);

} 

protected function p()
{
	$p =Programme::all();
return $p;
}
//=====================without pds ==================

public function getFos_hod($id)
    {
      $role =$this->getrolename(Auth::user()->id);
   if($role == "examsofficer")
   {
    $f_id =array();
  $fos_id =DeskofficeFos::where('user_id',Auth::user()->id)->get();
  foreach($fos_id as $v){
    $f_id [] =$v->fos_id;
  }
  $d =Fos::whereIn('id',$f_id)
  ->where([['department_id', Auth::user()->department_id],['programme_id',$id]])
  ->get();
   }else{
     $d =Fos::where([['department_id', Auth::user()->department_id],['programme_id',$id]])->get();
   }
    return response()->json($d);
    }


//========================== get fos assign to exams officer and hod fos ==================
public function get_fos_exams_officer_and_hod($id,$d,$p)
{
  $role =$this->getrolename($id);
  $f_id =array();
  if($role == "examsofficer")
  {
 $fos_id =DeskofficeFos::where('user_id',$id)->get();
 if(count($fos_id) == 0)
 {
   Session::flash('warning',"no field of study. contact system admin");
   return back();
 }
 foreach ($fos_id as $key => $value) {
 $f_id[] =$value->fos_id;
 }
  }else{
 $fos_id =Fos::where([['department_id',$d],['programme_id',$p]])->get();

 if(count($fos_id) == 0)
 {
   Session::flash('warning',"no field of study. contact system admin");
   return back();
 }
 foreach ($fos_id as $key => $value) {
 $f_id[] =$value->id;
 }
  }
  return $f_id;
}

    
}
