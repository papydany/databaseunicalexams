<?php

namespace App;
use Illuminate\Support\Facades\DB;
use App\PdsResult;
use App\Department;
use App\Programme;
use App\Fos;
use App\Faculty;
use App\CourseReg;
use App\StudentResult;
use App\StudentResultBackup;
use App\RegisterCourse;
use App\Http\Traits\MyTrait;
class R
{
use MyTrait;
//----------------------get result-----------------------------------
 public function getresult($id){
        $result =DB::connection('mysql2')->table('student_results')
                         ->where('coursereg_id',$id)
                         ->first();
                       return $result;
       
   }

   public function getresultWithResultType($id,$ResultType){
    $result =DB::connection('mysql2')->table('student_results')
                     ->where([['coursereg_id',$id],['flag',$ResultType]])
                     ->first();
                   return $result;
   
}
//--------------------------get role name--------------------------------------
   public function getrolename($id){
        $user = DB::table('roles')
            ->join('user_roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_roles.user_id',$id)
            ->first();
            return $user->name;
    }

    public function getroleId($id){
      $user = DB::table('roles')
          ->join('user_roles', 'roles.id', '=', 'user_roles.role_id')
          ->where('user_roles.user_id',$id)
          ->select('roles.id')
          ->first();
          return $user->id;
  }

  public function getResultActivation($id){
    $user = DB::table('result_activations')
        ->where([['role_id',$id],['status',1]])
        ->first();
        if($user == null)
        {
          return null;
        }else{
        return $user->session;
        }
}
//===================================PDS=================================================================
//---------------------get pds result------------------------------------//
   public function pds_getresult($id,$mat_no,$course,$semester,$session){
        $result =DB::connection('mysql2')->table('pds_results')
                         ->where([['pdg_user',$id],['matric_number',$mat_no],['course',$course],['semester',$semester],['session',$session]])
                         ->first();
                       return $result;
       
   }
//---------------------------------------------------------------------------------------------
 public   function select_result_display($s_id,$course_id,$semester,$session){

if( empty($course_id) ){
    return array();
  }
$result= array();
$subj_id=array();

      $query =PdsResult::wherein('course',$course_id)->where([['pdg_user',$s_id],['semester',$semester],['session',$session]])->get();
        if(count($query) != 0){
foreach ($query as $key => $value) {
   $subj_id[$value->course] = $value;
}
}

 
     if(!empty($subj_id)){
    if(count($subj_id) != 0){
      
    $keys = array_keys($subj_id);
  }
  }else{
    $keys =array('');
  }

  foreach($course_id as $k=>$v ) {
    

    if( in_array($v, $keys) ) {
     
        $result[] = array('course'=>$v,'grade'=>$subj_id[$v]['grade']);
      
      }else{
 $result[] = array('course'=>$v,'grade'=>'','point'=>'');
      
      }
    
  }
  

      return $result;
      
}
//-----------------------------------------------get course-------------------------------------------------
public function getcourse()
{
  $c =PdsCourse::get();
  foreach ($c as $key => $value) {
    $id[] =$value->id;
  }
return $id;
}
//------------------------------------------------------------------------------
 public   function get_result_point($s_id,$course_id,$semester,$session){
$query =PdsResult::wherein('course',$course_id)->where([['pdg_user',$s_id],['semester',$semester],['session',$session]])->get();
return $query->sum('point');
 }
//--------------------------------------------------------------------------------------------------------
 public function get_course_grade($id,$c,$s,$sm)
 {
     $result =PdsResult::where([['pdg_user',$id],['course',$c],['session',$s],['semester',$sm]])->get();
     return $result;
 }

 //-----------------------------------------------------------------------------------------------------
 public   function get_course_avg($s_id,$course_id,$session){
$query =PdsResult::where([['pdg_user',$s_id],['session',$session],['course',$course_id]])->get();
$sum = $query->sum('total');

$no = Count($query);
if($no == 0)
{
 $avg ='zero';
}else{
$avg = $sum/$no;
}

return $avg;

 }
//==================================================end of pds code======================================
//---------------------------------------------------------------------------------------------------------
 public function get_course_grade_point($total)
 {

  switch($total) {
      case $total =='zero':
               $return['grade']  = '';
               $return['point'] = '';
                 return $return;
                 break;
            case $total >= 70:
                $return['grade'] = 'A';
                $return['point'] = 5;
               return $return;
                break;
            case $total >= 60:
                $return['grade']  = 'B';
                 $return['point'] = 4;
                  return $return;
                break;
            case $total >= 50:
                 $return['grade']  = 'C';
                 $return['point'] = 3;
     return $return;
                break;
            case $total >= 45:
                 $return['grade']  = 'D';
                 $return['point'] = 2;
                  return $return;
                break;
            case $total >= 40:
                 $return['grade']  = 'E';
                 $return['point'] = 1;
                  return $return;
                break;
            case $total < 40:
                 $return['grade']  = 'F';
                $return['point'] = 0;
                 return $return;
                break;
            
        }
    
 }
 //---------------------------------------get department by name----------------------------------------------
public function get_departmetname($id)
{

$d =Department::find($id);
if($d == null)
{
  return "No Department";
}
return $d->department_name;
}
//----------------------------------------get faculty by name--------------------------------------------
public function get_facultymetname($id)
{
$d =Faculty::find($id);
if($d == null)
{
  return "No Faculty";
}
return $d->faculty_name;
}
//---------------------------------------get programme by name---------------------------------------------
public function get_programmename($id)
{
$d =Programme::find($id);
if($d == null)
{
  return "No Programme";
}
return $d->programme_name;
}
//-------------------------------------get field of studies--------------------------------------
public function get_fos($id)
{
$d =Fos::find($id);
if($d == null)
{
  return "No Field Of study";
}
return $d->fos_name;
}

//=================  report  ============================================
 // get result grade
function getStudentResult($id,$course_id,$s,$season) {
  
  if( empty($course_id) )
    return array();
   $all = array();
  $s_result =DB::connection('mysql2')->table('student_results')
  ->where([['user_id',$id],['session',$s],['season',$season]])
  ->whereIn('course_id',$course_id)->get();
 
  if(count($s_result) > 0)
  {
    foreach ($s_result as $key => $value ) {
      $all[$value->course_id] =$value;
    }
    
  }

  /*coursereg*/
    $creglist = array();
      $creg =CourseReg::where([['user_id',$id],['session',$s],['period',$season]])->get();
      if(count($creg))
      {
      foreach ($creg as $key => $value) {
        $creglist[] =  $value->course_id;
      }
    }
/*coursereg*/
  $keys = array_keys($all);

  foreach($course_id as $k=>$v ) {

    if( in_array($v, $keys) ) {
      if( empty($all[$v]->total) || $all[$v]->total ==0 ) {
        $result[] = array( 'total'=>$all[$v]->total, 'grade'=>$all[$v]->grade);
      } else {
        $result[] = array( 'total'=>$all[$v]->total, 'grade'=>$all[$v]->grade);
      }
    } else {
      if( in_array($v, $creglist) )
        $result[] = array('total'=>'', 'grade'=>'&nbsp;&nbsp;');
      else
        $result[] = array('total'=>'', 'grade'=>'');
    }
  }

  return $result;
  
}
//------------------------------------get register elective course-----------------------------------------
public function getRegisteredCourseElective($s,$l,$sem,$fos)
{
    $reg_id =array();
   $sql =DB::table('register_courses')
   ->where([['fos_id',$fos],['level_id',$l],['session',$s],['reg_course_status','E'],['semester_id',$sem]])->get();
   if(count($sql) > 0)
   {
      foreach ($sql as $key => $value) {
    $reg_id [] =$value->id;
   }
   }

   return $reg_id;
}
// get elective result
//-----------------------------------get elective course----------------------------------------
function fetch_electives($id, $s,$l,$sem,$season,$reg_id) {
 $elec = '';
$coursereg =DB::connection('mysql2')->table('course_regs')
->whereIn('registercourse_id',$reg_id)->where([['user_id',$id],['level_id',$l],['semester_id',$sem],['session',$s],['course_status','E'],['period',$season]])->get();
if(count($coursereg) > 0)
  {
  foreach ($coursereg as $key => $value) {
 $grade = $this->getSingleResult($id,$s,$l,$sem,$season,$value->course_id);
   if ($grade!=NULL && $grade!=''){
    $elec .= $value->course_unit.' '.substr_replace($value->course_code, '',3,0).' '.$grade->grade."<br/>";
   }
    }
  } 
  
  return $elec;
}





//------------------------------------gpa for a session ---------------------------------


function get_gpa($s,$id,$l,$season){
  
  $tcu = 0; $tgp = 0;  $course_id = array();
  $entry_year = $this->get_entry_sesssion($id);
  
  //, level_id, std_mark_custom_2, period
   $creg =CourseReg::where([['user_id',$id],['session',$s],['period',$season]])->get();
   foreach ($creg as $key => $value) {
     $course_id[] =$value->course_id;
   }
$s_result = $this->getResult_grade($id,$s,$l,$season,$course_id);
 
  if(count($s_result) > 0)
  {
foreach ($s_result as $key => $value) {
  $cu = $this->get_crunit($value->course_id, $s, $id,$season);
  $gp = $this->get_gradepoint ($value->grade, $cu, $entry_year );
   
    $tcu = $tcu + $cu;
    $tgp = $tgp + $gp;
   
}
  @$gpa = $tgp / $tcu ;
  $gpa = number_format ($gpa,2);
  return $gpa;
}
return 0;

}
// get course unit
//------------------------------------get course unit-----------------------------------
private function get_crunit ($courseid, $s, $id,$season ) {
  if($season == "VACATION")
  {
    $creg =CourseReg::where([['user_id',$id],['session',$s],['course_id',$courseid]])->whereIn('period',['NORMAL','VACATION'])->first();
  }elseif($season == "RESIT"){
   $creg =CourseReg::where([['user_id',$id],['session',$s],['course_id',$courseid]])->whereIn('period',['NORMAL','RESIT'])->first();
  }else{
    $creg =CourseReg::where([['user_id',$id],['session',$s],['period',$season],['course_id',$courseid]])->first();
  }

  $cu = $creg['course_unit'];
  return $cu;
}
// get grade point
//-------------------------------------get grade point-------------------------------------------
private function get_gradepoint ($grade, $cu,$entry_year){
  
  if ($grade == 'A' )
    return 5.0 * $cu;
  else if ($grade == 'B' )
    return 4.0 * $cu;
  else if ($grade == 'C' )
    return 3.0 * $cu;
  else if ($grade == 'D' )
    return 2.0 * $cu;
  else if ($grade == 'E' )
    return 1.0 * $cu;
  else if ($grade == 'F' )
    return 0.0 * $cu ;

}
// get result
//---------------------------------------------------------------------------------------------------------
private function getResult_grade($id,$s,$l,$season,$course_id_array)
{
    $s_result =StudentResult::where([['user_id',$id],['session',$s],['season',$season],['level_id',$l]])
  ->whereIn('course_id',$course_id_array)->get();
  return $s_result;
}

// get result single
//---------------------------------------------------------------------------------------------------------
private function getSingleResult($id,$s,$l,$sem,$season,$course_id)
{
    $s_result =DB::connection('mysql2')->table('student_results')
    ->where([['user_id',$id],['session',$s],['season',$season],['level_id',$l],['course_id',$course_id],['semester',$sem]])->first();
 return $s_result;
}


//------------------------ remarks -----------------------------------------

  function result_check_pass_sessional($l, $id, $s, $cgpa,$take_ignore=false, $taketype='',$fos,$f='')
{ $fail=array();$carryf ='';$rept=''; $course_id_array =array();$pass_course_id=array();
  
  $new_prob=$this->new_Probtion($l,$id,$s,$cgpa,$fos,$taketype);
  if($new_prob==true){
    return $new_prob;
  }
  $chekvac='';

  if($taketype == 'VACATION')
  {
    $chekvac ='VACATION';
    $taketype =['VACATION','NORMAL'];
  }else{
    $taketype =['NORMAL'];
  }
  
  $check =DB::connection('mysql2')->table('student_results')
  ->where([['user_id',$id],['session',$s],['level_id',$l],['grade',"F"]])
  ->whereIn('season',$taketype)
  ->select('course_id','cu')->get();
  
  if(count($check) != 0){
 
//$sql =StudentResult::where([['user_id',$id],['session',$s],['grade',"F"],['level_id',$l]])->groupBy('course_id','id')->select('course_id')->distinct()->get();
$sql =DB::connection('mysql2')->table('student_results')
->where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l]])
->whereIn('season',$taketype)
->select('course_id','cu')->get()->groupBy('course_id','id');


if (count($sql)!=0){ // found failed courses in the level
  foreach($sql as $key => $value)
  {
    $course_array [$key]=['course_id'=>$key,'number'=>$value->count()];
    $course_id_array []=$key;
  }

  $sql1 = DB::connection('mysql2')->table('student_results')
  ->where([['user_id',$id],['session','<=',$s],['grade','!=',"F"],['level_id','<=',$l]])
  ->whereIn('course_id',$course_id_array)
  ->whereIn('season',$taketype)
  ->get();
  if (count($sql1)!=0){
    foreach ($sql1 as $k => $v)
{
$pass_course_id[]= $v->course_id;
}
   }
// the remain course_id that is not yet passed
$unpass_course_id=array_diff($course_id_array,$pass_course_id);
$exitingResult =StudentResult::where([['user_id',$id],['level_id',$l],['session',$s]])->select('course_id')->get();

$coursereg_join = CourseReg::where([['user_id',$id],['level_id',$l],['session',$s]])
->whereIn('course_status',['R','D'])
->whereNotIn('course_id',$exitingResult)->select('course_id', 'course_code');

$coursereg = CourseReg::where('user_id',$id)->whereIn('course_id',$unpass_course_id)
->select('course_id', 'course_code')->union($coursereg_join)->distinct()->get();

if(count($coursereg) != 0){
foreach($coursereg as $k =>$v)
{
  $code = substr($v->course_code,0,3).' '.substr($v->course_code,3,4);
  $type = substr($v->course_code,0,3); // GSSS
if(in_array($v->course_id,$course_id_array))
{
  $n = $course_array[$v->course_id]['number'];
}else{
  $n = 1;
}
  
  if ($n >= 3)
  {
    
      if (!in_array($type,['GSS','GST']))
      { 
      if($this->ignore_carryF ($id, $v->course_id, $s ) == '')
          {
          $carryf .= ', '.$code;
          }
      } else {
               $rept .= ', '.$code;
              }
  } elseif($n < 3) 
  {
      $rept .= ', '.$code;
  }

}//dd($carryf);
}

}



}else{
  // check for repeat or carryover courses that dont have result and the student did fail anycaurse in the session
  $result =StudentResult::where([['user_id',$id],['level_id',$l],['session',$s]])->select('course_id')->get();
  /*foreach($result as $key => $value)
  {
    $result_array[]=$value->course_id;
  }*/
  $coursereg = CourseReg::where([['user_id',$id],['level_id',$l],['session',$s]])
  ->whereIn('course_status',['R','D'])
  ->whereNotIn('course_id',$result)->get();
  //dd($coursereg);
  

  foreach($coursereg as $k =>$v)
  {
    $code = substr($v->course_code,0,3).' '.substr($v->course_code,3,4);
    $rept .= ', '.$code;
  }
}

  $take = $take_ignore == true ? '' : $this->take_courses_sessional($id, $l, $s, $taketype,$fos);
 // $take = take_courses_sessional($id, $l, $s, $taketype='');
  //$rept = $carryf == $rept? '': $rept;
  // silent take for vacation student for management science for 2018/2019 session
  if($s == '2018' && $chekvac == 'VACATION' && $f==8)
  {
    $take ='';
  }
  $carryf = $carryf != '' ? '<b>CARRY F :</b>'.substr($carryf,2)."<br>" : '';
  $rept = $rept != '' ? '<b>RPT : </b>'. substr($rept,2) : '';
  $rept = $take != '' ? '<b>TAKE : </b>'. $take ."<br>".$rept : $rept;
  $dur = $this->G_duration($id);
  
  if (($l >= $dur) && ($rept == '')) {
    $fail = "PASS <br>".$carryf;
  } else if (($carryf != '') && ($rept != '')) {
    $fail = $carryf . $rept;
  } else if (($carryf != '') && ($rept == '')) {
    $fail = "PASS <br>".$carryf;
  } else if (($carryf != '') || ($rept != '')) {
    $fail = $carryf . $rept;
  } else { $fail = 'PASS' ;}
  
  return $fail;

}




//=======================premedical remarks =======================================

function preMedicalRemarks($l,$id,$s,$cgpa,$take_ignore=false,$fos)
{ $fail=array();$rept=''; $course_id_array =array();$pass_course_id=array();
 if($cgpa < '2.5')
 {
   return 'Change Of Programme';
 }


  $check =DB::connection('mysql2')->table('student_results')
  ->where([['user_id',$id],['session',$s],['level_id',$l],['grade',"F"]])
  ->select('course_id','cu')->get();
  
if (count($check)!=0){ // found failed courses in the level
  foreach($check as  $value)
  {
   $course_id_array []=$value->course_id;
  }
$coursereg = CourseReg::where('user_id',$id)->whereIn('course_id',$course_id_array)
->select('course_id', 'course_code')->distinct()->get();

if(count($coursereg) != 0){
  $n =0;
foreach($coursereg as $k =>$v)
{
  $code = substr($v->course_code,0,3).' '.substr($v->course_code,3,4);
  $type = substr($v->course_code,0,3); // GSSS

      if (!in_array($type,['GSS','GST']))
      { 
     $rept .= ', '.$code;
     $n ++;
      } else {
      $rept .= ', '.$code;
    }
  } 

  if($n > 2)
  {
    return 'Change Of Programme';
  }

}

}

  $take = $take_ignore == true ? '' : $this->take_courses_sessional($id, $l, $s,'NORMAL',$fos);
 
  $rept = $rept != '' ? '<b>RPT : </b>'. substr($rept,2) : '';
  $rept = $take != '' ? '<b>TAKE : </b>'. $take ."<br>".$rept : $rept;

  if ($rept == '') {
    $fail = "PASS <br>";
  } else if ($rept != '') {
    $fail =  $rept;
  }
  return $fail;

}
//======================= clinical remarks ========================================

function clinicalRemarks($l,$id,$s,$season)
{ $fail=array();$rept=''; $coursereg_id_array =array();
  // student who have apassed  all courses
  $check =DB::connection('mysql2')->table('student_results')
  ->where([['user_id',$id],['session',$s],['level_id',$l],['season',$season]])
  ->whereIn('grade',['P','PD'])
  ->get();

 if (count($check) == 0){ // found failed courses in the level
  $check =DB::connection('mysql2')->table('student_results')
  ->where([['user_id',$id],['session',$s],['level_id',$l],['season',$season]])
  ->whereIn('grade',['P','PD'])
  ->select('total')->get();
  $totalFailed =$check->sum('total');
  
  if($totalFailed < 120)
  {
    return 'Change Of Programme';
  }else{
    return 'Resit All Courses';
  }
 }
 
 $check2 =DB::connection('mysql2')->table('student_results')
 ->where([['user_id',$id],['session',$s],['level_id',$l],['grade','F'],['season',$season]])
 ->select('coursereg_id')->get();

 if(count($check2) != 0)
 {
   if($season =='VACATION') {
    $rept ='REPEAT THE YEAR FOR THE LAST TIME';
   }else{
   foreach($check2 as $v)
  {
    $coursereg_id_array []=$v->coursereg_id;
  }

  $coursereg = CourseReg::where([['user_id',$id],['level_id',$l],['session',$s],['period',$season]])
  ->whereIn('id',$coursereg_id_array)->get();
  foreach($coursereg as $v)
  {
    $rept .= ' , '.strtoupper($v->course_title);
  }
$rept ='RESIT '.$rept;
   }
 }else{
   $rept ='PASS';
 }
return $rept;

}
// =========================  diploma remarks ======================================

 function result_check_pass_sessional_diploma($l, $id, $s, $cgpa,$take_ignore=false, $taketype='',$fos)
{ $fail=''; $pass='';$c=0;$rept='';
 
  $check =StudentResult::where([['user_id',$id],['session',$s],['level_id',$l]])->get()->COUNT();
  if($check != 0){
 /*$sql_num = StudentResult::where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l]])->groupBy('course_id','id')->select('course_id','cu')->COUNT('course_id');*/
$sql =StudentResult::where([['user_id',$id],['session',$s],['grade',"F"],['level_id',$l],['flag',"Sessional"],['season',$taketype]])->groupBy('course_id','id')->select('course_id')->distinct()->get();



$c=count($sql);

if($c !=0){
foreach($sql as $key => $value)
{

$rowc = CourseReg::where([['user_id',$id],['course_id',$value->course_id],['level_id',$l],['session',$s]])->first();
if($rowc != null )
{
$code = substr($rowc->course_code,0,3).' '.substr($rowc->course_code,3,4);
$rept .= ', '.$code;

}
}
}

  $take = $this->take_courses_sessional($id, $l, $s, $taketype,$fos);

if($taketype == "RESIT")
{
 $rept = $rept != '' ? '<b>CARRY F</b> '. substr($rept,2) : '';
}else
{
   $rept = $rept != '' ? '<b>RESIT</b> '. substr($rept,2) : '';
}
 
  $rept = $take != '' ? '<b>TAKE</b> '. $take ."<br>".$rept : $rept;
 
  
  if($rept == ''){
    $fail = "PASS <br>";
  } else if ($rept != '') {
    $fail = $rept;
  }else { $fail = 'PASS' ;}
  
  return $fail;
}else{
   return $fail;
}
}


//------------------------ entry session----------------------------------------------------
function get_entry_sesssion($id)
{//dd($id);
  $users = DB::connection('mysql2')->table('users')
  ->find($id);
  return  $users->entry_year;
}
//---------------------------------- new probation-------------------------------------------
function new_Probtion($l,$id,$s,$cgpa,$fos,$taketype){
  $fail_cu=$this->get_fail_crunit($l,$id,$s,$taketype);
//get fos duaration
$duration =Fos::find($fos);
 //$entry_year = $this->get_entry_sesssion($id);

$return ='';
if($l >= $duration->duration)
{

}else{


 if($fail_cu > 15 && $cgpa < 1.5 || $cgpa >=0.00 && $cgpa <=0.99 ){
      
    $return = 'WITHDRAW';
    }
    elseif($cgpa >=1.00 && $cgpa <=1.49 || $fail_cu ==15){

      $return = 'PROBATION';

    }//elseif( $cgpa > 1.49 && $cgpa <=1.5 && $fail_cu ==15 ){
      elseif( $cgpa >=1.5 && $fail_cu > 15 ){
    $return = 'CHANGE PROGRAMME';
    }
  }

    return $return;
}
/*=================================================== probation function ==================================*/

//------------------------ probation remarks -----------------------------------------

  function result_check_pass_probational($l, $id, $s, $cgpa,$take_ignore=false,$taketype='',$fos)
{ $fail=''; $pass='';$c=0;$carryf ='';$rept='';
$new_prob=$this->withdrawer_condition_for_probation($l,$id,$s,$cgpa);

  if($new_prob==true){
    return $new_prob;
  }
  $check =StudentResult::where([['user_id',$id],['session',$s],['level_id',$l]])->get()->COUNT();

  if($check != 0){

$sql =StudentResult::where([['user_id',$id],['session',$s],['grade',"F"],['level_id',$l]])->groupBy('course_id','id')->select('course_id')->distinct()->get();

$c=count($sql);
//dd($sql);

if($c !=0){
foreach($sql as $key => $value)
{
 
$sql1 = StudentResult::where([['user_id',$id],['session','<=',$s],['grade','!=',"F"],['level_id','<=',$l],['course_id',$value->course_id]])->first();

$sql2 = StudentResult::where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l],['course_id',$value->course_id]])->get();
    
if ($sql1 != null){ //found that failed course passed in the level

$pass .= ','.$sql1->course_id;


}else{
$rowc = CourseReg::where([['user_id',$id],['course_id',$value->course_id],['level_id','<=',$l],['session','<=',$s]])->first();
if($rowc != null )
{
$code = substr($rowc->course_code,0,3).' '.substr($rowc->course_code,3,4);
            
$type = substr($rowc->course_code,0,3); // GSSS

$n = count($sql2);

          
if ($n >= 3)
{
    if ($type != 'GSS')
    { 
        
        if($this->ignore_carryF ($id, $value->course_id, $s ) == '')
        {
            $carryf .= ', '.$code;
        }
    } else {
             $rept .= ', '.$code;
            }
} elseif($n < 3) 
{
    $rept .= ', '.$code;
}
}
}
}
}//dd('lhhh');
  $take = $this->take_courses_sessional($id, $l, $s, $taketype,$fos);

 // $take = take_courses_sessional($id, $l, $s, $taketype='');
  //$rept = $carryf == $rept? '': $rept;
  $carryf = $carryf != '' ? 'CARRY F '.substr($carryf,2)."<br>" : '';
  $rept = $rept != '' ? 'RPT '. substr($rept,2) : '';
  $rept = $take != '' ? 'TAKE '. $take ."<br>".$rept : $rept;
  $dur = $this->G_duration($id);
  
  if (($l >= $dur) && ($rept == '')) {
    $fail = "PASS <br>".$carryf;
  } else if (($carryf != '') && ($rept != '')) {
    $fail = $carryf . $rept;
  } else if (($carryf != '') && ($rept == '')) {
    $fail = "PASS <br>".$carryf;
  } else if (($carryf != '') || ($rept != '')) {
    $fail = $carryf . $rept;
  } else { $fail = 'PASS' ;}
  
  return $fail;
}else{
   return $fail;
}
}

// condition for withdrawer for probation condition
function withdrawer_condition_for_probation($l,$id,$s,$cgpa){
  $fail_cu=$this->get_fail_crunit($l,$id,$s,'NORMAL');

 //$entry_year = $this->get_entry_sesssion($id);

$return ='';


 if($fail_cu >= 15 || $cgpa < 1.5 ){
      
    $return = 'WITHDRAW OR CHANGE PROGRAMME';
    }
    return $return;
}

/*=================================================== End probation function ==================================*/
function get_fail_crunit($l,$id,$s,$taketype){

$sql =StudentResult::where([['level_id',$l],['user_id',$id],['session',$s],['grade','F'],['season',$taketype]])
->get(); 
$tcu=$sql->sum('cu');
return $tcu;
}

public function ignore_carryF ( $id, $course_id, $s ){
  $sql =CourseReg::where([['user_id',$id],['session',$s],['course_id',$course_id]])->get();
  if(count($sql) == 0)
  {

  return 'true';
  } else { // add this carryF course since it exist in same year
    return '';
  }
 
  
}

public function take_courses_sessional($id,$l,$s,$taketype='',$fos) 
{
  $take = '';
  $regcos_array = array();
  $result =array();
  if ($taketype == 'VACATION')
  { 
    
      $result = StudentResult::where([['user_id',$id],['level_id',$l],['session',$s]])
      ->whereIn('season',['NORMAL','VACATION'])->select('course_id')->get();
      
  }  elseif ($taketype == 'RESIT')
  { 
    
      $result = StudentResult::where([['user_id',$id],['level_id',$l],['session',$s]])
      ->whereIn('season',['RESIT'])->select('course_id')->get();
  }
  
  else { //ignore vac result for take remark
     $result = StudentResult::where([['user_id',$id],['level_id',$l],['session',$s]])
      ->whereIn('season',['NORMAL'])->select('course_id')->get();
  }
/*if(count($result) > 0)
      {
      foreach ($result as $key => $value) {
        $result_array [] = $value->course_id;
      }*/
      if ($taketype == 'RESIT')
      {
        
        //var_dump($result_array);
    $cos =CourseReg::where([['user_id',$id],['level_id',$l],['session',$s],['course_status','R']])
      ->whereNotIn('course_id',$result)->get();

      foreach ($cos as $key => $v) {
      $regcos_array [] =$v->registercourse_id;
      }
    
$sql =RegisterCourse::whereIn('id',$regcos_array)->get();

     // dd($sql);
      }
      elseif($taketype == 'PROBATION')
      {

    $cos =CourseReg::where([['user_id',$id],['level_id',$l],['session',$s]])
      ->whereNotIn('course_id',$result)->get();

      foreach ($cos as $key => $v) {
      $regcos_array [] =$v->registercourse_id;
      }
    
$sql =RegisterCourse::whereIn('id',$regcos_array)->get();

     // dd($sql);
      
      }else
      {
        $sql =RegisterCourse::where([['fos_id',$fos],['level_id',$l],['session',$s],['reg_course_status','C']])
      ->whereNotIn('course_id',$result)->get();
      }
     // dd($sql);
      if(count($sql) > 0)
      {
        foreach ($sql as $key => $value) {
              $take.= ', '.substr($value->reg_course_code,0,3).' '.substr($value->reg_course_code,3,4);
        }
    
      }
     
   // }

 
  return $take != '' ? substr($take,2) : '';
  }

  
//---------------------- get duration --------------------------------------------
 public  function G_duration($id){
  $users = DB::connection('mysql2')->table('users')->find($id);
  $fos =Fos::find($users->fos_id);
  return $fos->duration;  
}

//----------------------------------------- auto cgpa ----------------------------------
function auto_cgpa( $s, $id, $l,$season ) {
 $duration = $this->G_duration($id);
  $year_of_study = $l.'/'.$duration;
  $info = $this->get_count_session_used($id);
  if( $l < $duration ) {
   
      return $this->get_cgpa($s,$id,$season); 
  
    
  } elseif( $info == $duration ) {
    //final year std who has had no probation
    return $this->get_cgpa($s,$id,$season);
  } else {
    //helpiing with final year + spill over cgpa calc
    $yr = substr($year_of_study,0,1);
    $calc = $yr - $duration;
    $magic_s = ($calc == 0) ? $s : $s-$calc;
    
   
    return $this->get_cgpa($s,$id,$season);
  }
  
}
//------------------------ cgpa--------------------------------
function get_cgpa($s,$id,$season){

$tcu = 0; $tgp = 0;$coursereg_id =array();

$entry_year = $this->get_entry_sesssion($id);

$coursereg =CourseReg::where([['user_id',$id],['session','<=',$s]])->get();
foreach ($coursereg as $key => $value) {
$coursereg_id [] =$value->id;
}

if($season == 'VACATION')
{
    $result = StudentResult::where([['user_id',$id],['level_id','!=',0],['session','<=',$s]])
      ->whereIn('season',['NORMAL','VACATION'])
      ->whereIn('coursereg_id',$coursereg_id)->get();
}
elseif($season =='RESIT')
{
  $result = StudentResult::where([['user_id',$id],['level_id','!=',0],['session','<=',$s]])
      ->whereIn('season',['NORMAL','RESIT'])
      ->whereIn('coursereg_id',$coursereg_id)->get();

}
else
{
$result = StudentResult::where([['user_id',$id],['level_id','!=',0],['session','<=',$s],['season',$season]])->whereIn('coursereg_id',$coursereg_id)->get();
}

 
if(count($result) > 0)
{
  foreach ($result as $key => $value) {
   
  $cu = $this->get_crunit($value->course_id,$value->session,$id,$season);
  $gp = $this->get_gradepoint($value->grade,$cu,$entry_year);

    $tcu += $cu;
    $tgp += $gp;
  }

@$gpa = $tgp / $tcu ;
$gpa = number_format ($gpa,2); 
return $gpa;
}
return 0;
}
//------------------- get session used------------------------------------
function get_count_session_used( $id, $l = 6 ) {
  $stdReg =StudentReg::where([['user_id',$id],['level_id','<=',$l]])
  ->whereIn('semester',['1,2'])->distinct()->select('session')->get()->count();

  if( $stdReg > 0)
  {
    return $stdReg;
  }else{
  
    return '';  
  }

}
//-------------------get pin year------------------------------------------------------
public function get_pin_year($user_id,$mat,$year)
{
  $p =Pin::where([['student_id',$user_id],['matric_number',$mat],['session',$year]])->get();
return $p;
}
//---------------------------get repeat course-------------------------------------------
public function repeat_course($id,$session,$level,$season)
{
  $return = '';
  $inc = array();
  if($season =='VACATION')
  {
    $last_level =$level;
    $last_session =$session;
    $level =$level + 1;
    $period =['NORMAL'];
  }else{
  $last_level =$level -1;
  $last_session =$session -1;
  $period =['NORMAL','VACATION'];
  }
  $gss_gst =['gss','gst'];
  $array_of_failed_course_id =array();
  $array_of_failed_course_id_with_count =array();
  $failed_course  = DB::connection('mysql2')->table('student_results')
            ->join('course_regs', 'student_results.coursereg_id', '=', 'course_regs.id')
            ->where([['grade','F'],['student_results.user_id',$id],['student_results.session',$last_session],['student_results.level_id',$last_level]])
            ->select('student_results.*', 'course_regs.course_code', 'course_regs.period')
            ->get();
            if(count($failed_course) > 0)
            {
  foreach($failed_course as $key => $value)
  {
   $array_of_failed_course_id [] =$value->course_id;
  }

$course =DB::connection('mysql2')->table('student_results')->where([['grade','F'],['user_id',$id],['session','<=',$last_session],['level_id','<',$level]])
          ->whereIn('course_id',$array_of_failed_course_id)
          ->get()
          ->groupBy('course_id');
  
        foreach($course as  $key => $value)
        {
           $array_of_failed_course_id_with_count[$key]=array('size'=>count($value));
        }
  foreach ($failed_course as $key => $value) {
  
    $coursenumber =$array_of_failed_course_id_with_count[$value->course_id]['size'];
    
if ( in_array(strtolower(substr($value->course_code,0,3)),$gss_gst) ||   $coursenumber < 3 )
{  
    if( $value->session ==  $last_session && in_array($value->period,$period)) { 
    $inc[$value->coursereg_id] = array( 'sizem'=> $coursenumber, 'code'=>$value->course_code, 'std'=>$id,'pero'=>$value->period );
     continue;
   
  }   
          
    
}
}

   
$return = '';
    
    foreach( $inc as $v ) {
    
      if(in_array(strtolower(substr($v['code'],0,3)),$gss_gst) ){
        $return .=  substr_replace($v['code'],' ',3,0)." F<br/>";
      }
      elseif( $v['sizem'] < 3 ) 
      {
        $return .= $v['sizem'] == 2 ? substr_replace($v['code'],' ',3,0)." F/F<br/>" : substr_replace($v['code'],' ',3,0)." F<br/>";
      }
    }
    $return = substr( $return, 0, -5);
  }

    return strtoupper($return);
}
//----------------------- failed drop courses--------------------------------
public function get_failed_drop_courses($id,$l,$s,$season,$course_status,$semester)
{
  $return =array();
  $course =CourseReg::where([['user_id',$id],['level_id',$l],['session',$s],['period',$season],['course_status',$course_status],['semester_id',$semester]])->get();

  if(count($course) > 0)
  {
  foreach ($course as $key => $value) {
    if($course_status == 'R') // repeat courses
    {
    if($season =='VACATION')
    {
      $result =StudentResult::where([['course_id',$value->course_id],['grade','F'],['session',$s]])->first();
   
    }else{
    $result =StudentResult::where([['course_id',$value->course_id],['grade','F'],['session','<',$s]])->first();
    }
    if($result != null)
    {
      $return [] =$value->course_id;
    }
  }else
  {
    $return [] =$value->course_id;
  }
  }
}
return $return;
}

//------------------failed drop course result---------------------------------------------
function get_failed_drop_course_result($id,$l,$s, $semester,$rpt_list,$carryov_list,$season) {
  //var_dump($rpt_list);
  $to_go = array();
  $return = '';
  if(empty($carryov_list))
  {
    $merger =$rpt_list;
  }
  elseif(empty($rpt_list)){
    $merger =$carryov_list;
  }
  elseif(!empty($carryov_list && $rpt_list)){
  $merger = array_merge($rpt_list, $carryov_list);
}
  
  if( !empty($merger) ) 
  {

  $result =StudentResult::whereIn('course_id',$merger)->where([['user_id',$id],['session',$s],['semester',$semester],['level_id',$l],['season',$season]])->get();
  
  // dd($result);
   if(count($result) > 0)
   {
   foreach ($result as $key => $value) {
    $reg =CourseReg::find($value->coursereg_id);
    
        $return .= "<br/>". $value->cu.' '.substr_replace($reg->course_code," ",3, 0).' '.$value->grade;
      }
      
   }
}
    $return = substr($return, 5);
    echo strtoupper($return);
   // dd($return);
  
   // echo "";
  
}

//====================================drop courses=====================================
public function get_drop_course($id,$l,$s,$fos,$season=null)
{
  if($season == 'VACATION')
  {
    $last_session =$s;
    $last_level =$l;
  }else{
  $last_session =$s-1;
  $last_level =$l-1;
  }
  $return ='';
  $coursereg_id =array();
  $probationstudent = $this->probationStudent($id,$last_level,'NORMAL');

  if($probationstudent == true)
  {

  }else{


  $course_reg=DB::connection('mysql2')->table('course_regs')->where([['user_id',$id],['level_id',$last_level],['session',$last_session],['course_status','C']])->get();
  if(count($course_reg) > 0)
{
  foreach ($course_reg as $key => $value) {
$coursereg_id [] =$value->registercourse_id;
  }
}

$reg =DB::table('register_courses')->where([['fos_id',$fos],['level_id',$last_level],['session',$last_session],['reg_course_status','C']])
->whereNotIn('id',$coursereg_id)
->orderBy('reg_course_status','ASC')
->get();

if(count($reg) > 0)
{
  foreach ($reg as $key => $value) {

$return .=substr_replace($value->reg_course_code," ",3, 0).'<br/>';
  }
}
  }
echo strtoupper($return);
}

//=================================summmer vation function===========================

public function repeat_summer_course($id,$session,$level)
{
  $return = '';
  $inc = array();
  $last_level =$level;
    $last_session =$session;
    $level =$level + 1;
    $period =['NORMAL'];
 
  $gss_gst =['gss','gst'];
  $array_of_failed_course_id =array();
  $array_of_failed_course_id_with_count =array();
  $failed_course  = DB::connection('mysql2')->table('student_results')
            ->join('course_regs', 'student_results.coursereg_id', '=', 'course_regs.id')
            ->where([['grade','F'],['student_results.user_id',$id],['student_results.session',$last_session],['student_results.level_id',$last_level]])
            ->whereIn('student_results.season',$period)
            ->select('student_results.*', 'course_regs.course_code', 'course_regs.period')
            ->get();
           
            if(count($failed_course) > 0)
            {
  foreach($failed_course as $key => $value)
  {
   $array_of_failed_course_id [] =$value->course_id;
  }

$course =DB::connection('mysql2')->table('student_results')->where([['grade','F'],['user_id',$id],['session','<=',$last_session],['level_id','<',$level]])
          ->whereIn('course_id',$array_of_failed_course_id)
          ->whereIn('student_results.season',$period)
          ->get()
          ->groupBy('course_id');
  
        foreach($course as  $key => $value)
        {
           $array_of_failed_course_id_with_count[$key]=array('size'=>count($value));
        }
  foreach ($failed_course as $key => $value) {
  
    $coursenumber =$array_of_failed_course_id_with_count[$value->course_id]['size'];
    
if ( in_array(strtolower(substr($value->course_code,0,3)),$gss_gst) ||   $coursenumber < 3 )
{  
    if( $value->session ==  $last_session && in_array($value->period,$period)) { 
    $inc[$value->coursereg_id] = array( 'sizem'=> $coursenumber, 'code'=>$value->course_code, 'std'=>$id,'pero'=>$value->period );
     continue;
   
  }   
          
    
}
}

   
$return = '';
    
    foreach( $inc as $v ) {
    
      if(in_array(strtolower(substr($v['code'],0,3)),$gss_gst) ){
        $return .=  substr_replace($v['code'],' ',3,0)." F<br/>";
      }
      elseif( $v['sizem'] < 3 ) 
      {
        $return .= $v['sizem'] == 2 ? substr_replace($v['code'],' ',3,0)." F/F<br/>" : substr_replace($v['code'],' ',3,0)." F<br/>";
      }
    }
    $return = substr( $return, 0, -5);
  }

    return strtoupper($return);
}

/*==================== correctional result function========================================*/
 // get result grade
 function getStudentResultCorrection($id,$course_id,$s,$season) {
  
  if( empty($course_id) )
    return array();
  
  $return = array(); 
   $all = array();
  $s_result =StudentResult::where([['user_id',$id],['session',$s],['season',$season]])
  ->whereIn('course_id',$course_id)->get();
 
  if(count($s_result) > 0)
  {
    
    foreach ($s_result as $key => $value ) {
$cor =StudentResultBackup::where([['user_id',$id],['session',$s],['season',$season],['course_id',$value->course_id]])->first();
 if($cor != null)
 {
  $all[$value->course_id] =$cor;
 }else
 {
  $all[$value->course_id] =$value;
 }

    }
    
  }

  /*coursereg*/
    $creglist = array();
      $creg =CourseReg::where([['user_id',$id],['session',$s],['period',$season]])->get();
      if(count($creg))
      {
      foreach ($creg as $key => $value) {
        $creglist[] =  $value->course_id;
      }
    }
/*coursereg*/
  $keys = array_keys($all);

  foreach($course_id as $k=>$v ) {

    if( in_array($v, $keys) ) {
      if( empty($all[$v]['total']) || $all[$v]['total']==0 ) {
        $result[] = array( 'total'=>$all[$v]['total'], 'grade'=>$all[$v]['grade'] );
      } else {
        $result[] = array( 'total'=>$all[$v]['total'], 'grade'=>$all[$v]['grade'] );
      }
    } else {
      if( in_array($v, $creglist) )
        $result[] = array('total'=>'', 'grade'=>'&nbsp;&nbsp;');
      else
        $result[] = array('total'=>'', 'grade'=>'');
    }
  }

  return $result;
  
}

//---------------------- gpa correctional ----------------------------------------------------------------
function get_gpa_correctional($s,$id,$l,$season){
  
  $tcu = 0; $tgp = 0;  $course_id = array();
  $entry_year = $this->get_entry_sesssion($id);
  
  //, level_id, std_mark_custom_2, period
   $creg =CourseReg::where([['user_id',$id],['session',$s],['period',$season]])->get();
   foreach ($creg as $key => $value) {
     $course_id[] =$value->course_id;
   }
$s_result = $this->getResult_grade_correction($id,$s,$l,$season,$course_id);
 
  if(count($s_result) > 0)
  {
foreach ($s_result as $key => $value) {
  $cu = $this->get_crunit($value->course_id, $s, $id,$season);
  $gp = $this->get_gradepoint ($value->grade, $cu, $entry_year );
   
    $tcu = $tcu + $cu;
    $tgp = $tgp + $gp;
   
}
  @$gpa = $tgp / $tcu ;
  $gpa = number_format ($gpa,2);
  return $gpa;
}
return 0;

}

// ------------------get result grade correction-------------------------------
private function getResult_grade_correction($id,$s,$l,$season,$course_id_array)
{$result =array();
    $s_result =StudentResult::where([['user_id',$id],['session',$s],['season',$season],['level_id',$l]])
  ->whereIn('course_id',$course_id_array)->get();
  foreach($s_result as $v)
  {
    $srb =StudentResultBackup::where([['user_id',$id],['session',$s],['season',$season],['level_id',$l],['course_id',$v->course_id]])
  ->first();
  if($srb != null)
  {
    $result[]=$srb;
  }else{
    $result[]=$v;
  }
  }
  
  return $result;
}

//------------------------ remarks  correction-----------------------------------------


public function remarks_correctional($l,$id,$s,$season, $cgpa, $fos, $taketype = false){

$prob = $this->new_Probtion_correctional($l,$id,$s,$season,$cgpa);

if($prob==true){
  
return $prob;
}
$return = '';
$carryf = '';
$take ='';
$take = $this->take_courses_sessional($id, $l, $s, $taketype,$fos);
//$repeat = get_repeat_courses_reloaded_corr($l, $s, $s_id, $d, $fos);
$repeat1 = $this->repeatCourseCorrection($id,$s,$l,$season);

if( !empty( $repeat1 ) ) 
{
  
  foreach($repeat1 as $rep1)
  {
    
    if( $rep1['number'] == 3 )
    {
      
      $carryf .= substr_replace($rep1['code1'],' ',3, 0).',';
    }
    elseif($rep1['number'] < 3)
    {
      $return .= substr_replace($rep1['code1'],' ',3 ,0).',';
    }
  }
  
  $carryf = empty($carryf) ? '' : '<b> CARRY F : </b>'.$carryf." <br/>";
  $return = empty($return) ? '' : '<b> RPT : </b>'.$return;
  //var_dump($return);
  
}

  if(!empty($return) || !empty($carryf))
  {
    $return = $carryf.$return;
  
  }

  if(empty($take) && !empty($carryf) &&  empty($return)) 
  {
    //echo "here1";		
    return $cgpa > 0.99 ? "PASS </br> ".$carryf : '';
  }
  else if(empty($take) && $return=='') 
  {
    //echo "here2";
    return $cgpa > 0.99 ? "PASS": '';
  }
$return .= $take != '' ? '<br>TAKE '. $take :'';

  //$return .= $take != '' ? 'TAKE '. $take ."<br>".$return :'';
return strtoupper($return);


}

public function repeatCourseCorrection($id,$s,$l,$season)
{
$courseRegCourseId =array();
$courseRegCourseIdAndCode =array();
$course_array =array();
$courseReg =CourseReg::where([['user_id',$id],['session',$s],['level_id',$l]])
->whereIn('period',[$season])->select('course_id','course_code')->get();
foreach($courseReg as $v)
{
  $courseRegCourseIdAndCode[$v->course_id] =['course_id'=>$v->course_id,'code'=>$v->course_code];
  $courseRegCourseId []=$v->course_id;
}


$check =StudentResult::where([['user_id',$id],['session',$s],['level_id',$l],['grade','!=',"F"]])
->whereIn('season',[$season])->select('course_id')->get();
 
$sql =StudentResult::where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l]])
->whereNotIn('course_id',$check)->whereIn('course_id',$courseRegCourseId)->whereIn('season',[$season])
->select('course_id','cu');

$sql2 =StudentResultBackup::where([['user_id',$id],['session',$s],['grade',"F"],['level_id',$l]])
->whereIn('season',[$season])->union($sql)->select('course_id','cu')->get()->groupBy('course_id','id');


if (count($sql2)!=0){ // found failed courses in the level
  foreach($sql2 as $key => $value)
  {
    $course_array []=['course_id'=>$key,'number'=>$value->count(),'code1'=>$courseRegCourseIdAndCode[$key]['code']];
   
   //var_dump($course_array);
  }

}

return $course_array;
}
//-------------------------------- probation for correctional result -------------
function new_Probtion_correctional($l,$id,$s,$season,$cgpa){

  $fail_cu=$this->fail_course_unit_correction($l,$id,$s,$season);
  $return ='';
 
		if($fail_cu > 15 && $cgpa < 1.5 || $cgpa >=0.00 && $cgpa <=0.99 ){
      $return = 'WITHDRAW';
      }
      elseif($cgpa >=1.00 && $cgpa <=1.49 || $fail_cu ==15){
     $return = 'PROBATION';
     }elseif( $cgpa >=1.5 && $fail_cu > 15 ){
      $return = 'CHANGE PROGRAMME';
      }
	
		return $return;
}

private function fail_course_unit_correction($l,$id,$s,$season){
   $tcu =''; $tcu1 ='';
   if($season == 'NORMAL')
   {
    $season =['NORMAL'];
   }else{
     $season =['NORMAL','VACATION'];
   }
$sql =StudentResult::where([['user_id',$id],['session',$s],['level_id',$l],['grade','F']])
->whereIn('season',$season)->get();
$tcu=$sql->sum('cu');
$sql =StudentResultBackup::where([['user_id',$id],['session',$s],['level_id',$l],['grade','F']])
->whereIn('season',$season)->get();
$tcu1=$sql->sum('cu');
$c =$tcu + $tcu1;
 return $c;
 }

 public function G_degree( $cpga, $ignore = false ) 
 {
   
   if( $ignore )
     return '';
     
   switch( $cpga ){
     case $cpga <= 1.49 && $cpga >= 1.00 :
       return 'PASS';
     break;
     case $cpga <= 2.39 && $cpga >= 1.50 :
       return 'THIRD CLASS';
     break;
     case $cpga <= 3.49 && $cpga >= 2.40 :
       return 'SECOND CLASS LOWER';
     break;
     case $cpga <= 4.49 && $cpga >= 3.50 :
       return 'SECOND CLASS UPPER';
     break;
     case $cpga <= 5.00 && $cpga >= 4.50:
       return 'FIRST CLASS';
     break;
     default:
       return '---';
     break;
   }
   
 }
     
}	

