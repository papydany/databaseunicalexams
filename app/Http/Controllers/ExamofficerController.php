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
  
  $fos_id =Fos::where([['department_id',$d],['programme_id',$p]])->get();
  if(count($fos_id) == 0)
  {
    Session::flash('warning',"no field of study. contact system admin");
    return back();
  }
  foreach ($fos_id as $key => $value) {
  $f_id[] =$value->id;
  }

 $course =$course = $this->getRegisterAssign_courses($id,$l,$semester,$session,$d,$f,$f_id);

return view('examofficer.eo_assign_courses')->withC($course)->withSm($semester)->withS($session)->withL($l)->withFos($f_id);

    }
//---------------------------------------- get student  by course -----------------------------------
  public  function eo_result_c(Request $request)
    {  
       $id =$request->input('id');

 
      $l =$request->input('level');   
      $sm =$request->input('semester'); 
      $s =$request->input('session'); 
  $period =$request->input('period'); 
  $registercourse = RegisterCourse::find($id);
      $user = DB::connection('mysql2')->table('users')
        ->join('course_regs', 'course_regs.user_id', '=', 'users.id')
        ->where([['course_regs.registercourse_id',$id],['level_id',$l],['semester_id',$sm],['session',$s],['period',$period]])
        ->orderBy('users.matric_number','ASC')
        ->select('course_regs.*', 'users.firstname', 'users.surname','users.othername','users.matric_number')
        ->get();
  //Get current page form url e.g. &page=6
        $url ="eo_result_c?id=".$id."&level=".$l."&semester=".$sm."&session=".$s."&period=".$period;
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
    
      return view('examofficer.eo_result_c')->withU($paginatedSearchResults)->withUrl($url)->withC($registercourse);
    }  

//=========================result insert for student percourse ==========================

    public function eo_insert_result(Request $request)
    {
        //$this->validate($request,array('id'=>'required',));
        $flag = "Sessional";
        $date = date("Y/m/d H:i:s");
        $url =$request->input('url');

        $id =$request->input('id');

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
     

      $check_result = StudentResult::where([['level_id', $l_id], ['session', $session], ['course_id', $course_id], ['coursereg_id', $coursereg_id],['flag',$flag]])->first();
                    if (count($check_result) > 0) {
        $result_id =$request->input('result_id')[$value];


      
$update = StudentResult::find($result_id);
            $update->ca = $ca;
            $update->exam = $exam;
            $update->total = $total;
           $update->grade = $grade;
            $update->cp = $cp['cp'];
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
  $fos_id =Fos::where([['department_id',$d],['programme_id',$p]])->get();
  foreach ($fos_id as $key => $value) {
  $f_id[] =$value->id;
  }

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
   
 //----------------------------------------------------------------------------------------------------------

 public function getRegisterAssign_courses($id,$l,$semester,$session,$d,$f,$f_id)
 {
   $course = DB::table('assign_courses')
        ->join('register_courses', 'register_courses.id', '=', 'assign_courses.registercourse_id')
        ->where([['assign_courses.user_id',$id],['assign_courses.level_id',$l],['assign_courses.semester_id',$semester],['assign_courses.session',$session],['assign_courses.department_id',$d],['assign_courses.faculty_id',$f]])
        ->wherein('assign_courses.fos_id',$f_id)
        ->orderBy('register_courses.reg_course_code','ASC')
        ->get()->groupBy('fos_id');

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
protected function getp()
{
  $p =Programme::where('id','!=',1)->get();
return $p;
}
}
