<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;
use App\Programme;
use App\Faculty;
use App\CourseUnit;
use App\CourseReg;
use Illuminate\Support\Facades\Auth;

trait MyTrait {
   public function mm($G,$U) {

        $return = array();
       
        switch( $G ) {
            case 'A':
                $return['cp'] = 5 * $U;
                break;
            case 'B':
                $return['cp'] = 4 * $U;
                break;
            case 'C':
                $return['cp'] = 3 * $U;
                break;
            case 'D':
                $return['cp'] = 2 * $U;
                break;
            case 'E':
                $return['cp'] = 1 * $U;
                break;
            case 'F':
                $return['cp'] = 0 * $U;
                break;
                case 'PD':
                  $return['cp'] = 5 * $U;
                  break;
                  case 'P':
                    $return['cp'] = 4* $U;
                    break;
            }
        
        return $return;
    }
 public function get_grade($total)
 { 
    if($total == 0)
    {
    $total =1; 
}

  switch($total) {
               case $total < 40:
                 $return['grade']  ='F';
                 return $return;
                break; 
                case $total >= 70:
                $return['grade']='A';
               return $return;
                break;
            case $total >= 60:
                $return['grade'] ='B';
                return $return;
                break;
            case $total >= 50:
                 $return['grade'] ='C';
                 return $return;
                break;
            case $total >= 45:
                 $return['grade'] ='D';
                return $return;
                break;
            case $total >= 40:
                 $return['grade'] ='E';
               return $return;
                break; 
              }
            }


 public function get_grade_medicine($total,$season,$l)
 { 
    if($total == 0)
    {
    $total =1; 
}
if($l > 2)

{
  if($season =='VACATION')
  {
    switch($total) {
      case $total < 50:
        $return['grade']  ='F';
        return $return;
       break; 
      
   case $total >= 50:
        $return['grade'] ='P';
        return $return;
       break;
   }
  }else{
  switch($total) {
    case $total < 50:
      $return['grade']  ='F';
      return $return;
     break; 
     case $total >= 70:
     $return['grade']='PD';
    return $return;
     break;
 case $total >= 50:
      $return['grade'] ='P';
      return $return;
     break;
 }
}

}else{
  switch($total) {
               case $total < 40:
                 $return['grade']  ='F';
                 return $return;
                break; 
                case $total >= 70:
                $return['grade']='A';
               return $return;
                break;
            case $total >= 60:
                $return['grade'] ='B';
                return $return;
                break;
            case $total >= 50:
                 $return['grade'] ='C';
                 return $return;
                break;
            case $total >= 45:
                 $return['grade'] ='D';
                return $return;
                break;
            case $total >= 40:
                 $return['grade'] ='E';
               return $return;
                break;
            
            }

          }

 }
      public function g_rolename($id){
        $user = DB::table('roles')
            ->join('user_roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_roles.user_id',$id)
            ->first();
            return $user->name;
    }

protected function getp()
{
  $p =Programme::where('id','!=',1)->get();
  
return $p;
}

protected function get_faculty()
{
  
$sql =Faculty::orderBy('faculty_name','ASC')->get();
return $sql;
}

protected function get_fos()
{
    $fos= DB::connection('mysql')->table('fos')
            ->join('deskoffice_fos', 'fos.id', '=', 'deskoffice_fos.fos_id')
            ->where('deskoffice_fos.user_id',Auth::user()->id)
            // ->where('deskoffice_fos.status',1)
            ->orderBy('fos_name','ASC')
            ->select('fos.*')
            ->get();
            return $fos;
}

//---------------------------- get probation students -----------------------------------
 public function getprobationStudents($p,$d,$f,$l,$s)
 {
    // get student that did probation
  $s1 = $s-1;
  $prob_user_id = array();
  
$prob_Student_reg =DB::connection('mysql2')->table('student_regs')
->where([['semester',1],['programme_id',$p],['department_id',$d],['faculty_id',$f],['level_id',$l],['session',$s]])->get();
foreach ($prob_Student_reg as $key => $value) {
 $u =DB::connection('mysql2')->table('student_regs')
 ->where([['user_id',$value->user_id],['session',$s1],['level_id',$l]])->count();
 if($u > 0){
 $prob_user_id [] = $value->user_id;
}
}
return $prob_user_id;
 }

 public function probationStudent($id,$l,$season)
 {
    $studentreg =DB::connection('mysql2')->table('student_regs')
    ->where([['level_id',$l],['user_id',$id],['semester',1],['season',$season]])->count();
    //dd($studentreg);
    if($studentreg > 1)
    {
     return true;   
    }
    return false;
 }
 public function getrolename($id){
    $user = DB::table('roles')
        ->join('user_roles', 'roles.id', '=', 'user_roles.role_id')
        ->where('user_roles.user_id',$id)
        ->first();
        return $user->name;
}

public function student_with_no_result($id,$period)
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
    return $user_with_no_result;
}


//============================= correctional result =========================================

// get registered Correctional students
public function getRegisteredStudentsWithFlag($p,$d,$f,$fos,$l,$s,$flag)
{
 // get student that did probation
 
 $prob_user_id = array(); $correctional_array = array();

$prob_user_id = $this->getprobationStudents($p,$d,$f,$l,$s);

$correctional =$this->getStudentsWithFlag($p,$d,$f,$fos,$l,$s,$flag);

if($correctional != null)
{
 foreach ($correctional as $key => $value) {
   $correctional_array [] = $value->id;
 }
}
 $users = DB::connection('mysql2')->table('users')
           ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
           ->where([['student_regs.programme_id',$p],['student_regs.department_id',$d],['student_regs.faculty_id',$f],['users.fos_id',$fos],['student_regs.level_id',$l],['student_regs.session',$s]])
           ->whereNotIn('users.id',$prob_user_id)
           ->whereIn('users.id',$correctional_array)
           ->orderBy('users.matric_number','ASC')
           ->distinct()            
           ->select('users.*')
           ->get();
  
  return $users;
}
 //------------------------------ get students with flag ---------------------------
 public function getStudentsWithFlag($p,$d,$f,$fos,$l,$s,$flag)
 {
    $users = DB::connection('mysql2')->table('users')
            ->join('student_results', 'users.id', '=', 'student_results.user_id')
            ->where([['users.programme_id',$p],['users.department_id',$d],['users.faculty_id',$f],['users.fos_id',$fos],['student_results.level_id',$l],['student_results.session',$s],['student_results.flag',$flag]])
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();
return $users;
 }

 public function SelectedStudentsWithFlag($array,$l,$s,$flag)
 {
    $users = DB::connection('mysql2')->table('users')
            ->join('student_results', 'users.id', '=', 'student_results.user_id')
            ->where([['student_results.level_id',$l],['student_results.session',$s],['student_results.flag',$flag]])
            ->whereIn('users.id',$array)
            ->orderBy('users.matric_number','ASC')
            ->distinct()            
            ->select('users.*')
            ->get();
return $users;
 }

 //---------------------- get registered students ------------------------
 public function registerdStudents($fos_id,$p,$d,$f,$season,$session,$l_id,$prob_user_id)
 {
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
      
  return $user;
 }

 // -------------------- get course unit -----------------

 public function getTotalCourseunit($fos_id,$s,$level_id)
 {
      // get course unit set for the programme    
      $course_unit =DB::table('course_units')->where([['fos',$fos_id],['session',$s],['level',$level_id]])->first();
      
      if($course_unit == null)
      {
        $course_unit =DB::table('course_units')->where([['fos',0],['session',$s],['level',0]])->first();
     
      }

      return $course_unit;
 }

 // -------------- get total of unit of courses taken in semster -------
public function getTotalCourseUnitPerSemster($id,$session,$semester,$level,$season)
{
    $courseRegTotal =DB::connection('mysql2')->table('course_regs')
    ->where([['session',$session],['user_id',$id],
    ['semester_id',$semester],['level_id',$level],['period',$season]])->sum('course_unit');
  return $courseRegTotal; 
}
 
}