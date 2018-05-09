<?php

namespace App;
use DB;
use App\PdsResult;
use App\Department;
use App\Programme;
use App\Fos;
use App\Faculty;
use App\CourseReg;
use App\StudentResult;
use App\RegisterCourse;
class R
{
 public function getresult($id){
        $result =DB::connection('mysql2')->table('student_results')
                         ->where('coursereg_id',$id)
                         ->first();
                       return $result;
       
   }

   public function getrolename($id){
        $user = DB::table('roles')
            ->join('user_roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_roles.user_id',$id)
            ->first();
            return $user->name;
    }

   public function pds_getresult($id,$mat_no,$course,$semester,$session){
        $result =DB::connection('mysql2')->table('pds_results')
                         ->where([['pdg_user',$id],['matric_number',$mat_no],['course',$course],['semester',$semester],['session',$session]])
                         ->first();
                       return $result;
       
   }

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
public function getcourse()
{
  $c =PdsCourse::get();
  foreach ($c as $key => $value) {
    $id[] =$value->id;
  }
return $id;
}
//======================================================================================================
 public   function get_result_point($s_id,$course_id,$semester,$session){
$query =PdsResult::wherein('course',$course_id)->where([['pdg_user',$s_id],['semester',$semester],['session',$session]])->get();
return $query->sum('point');
 }

 public function get_course_grade($id,$c,$s,$sm)
 {
     $result =PdsResult::where([['pdg_user',$id],['course',$c],['session',$s],['semester',$sm]])->get();
     return $result;
 }

 //======================================================================================================
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
public function get_departmetname($id)
{
$d =Department::find($id);
return $d->department_name;
}
public function get_facultymetname($id)
{
$d =Faculty::find($id);
return $d->faculty_name;
}
public function get_programmename($id)
{
$d =Programme::find($id);
return $d->programme_name;
}

public function get_fos($id)
{
$d =Fos::find($id);
return $d->fos_name;
}

//=================  report  ============================================
 // get result grade
function getStudentResult($id,$course_id,$s,$flag,$season) {
  
  if( empty($course_id) )
    return array();
  
  $return = array(); 
   $all = array();
  $s_result =StudentResult::where([['user_id',$id],['session',$s],['flag',$flag],['season',$season]])
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

public function getRegisteredCourseElective($s,$l,$sem,$fos)
{
    $reg_id =array();
   $sql =RegisterCourse::where([['fos_id',$fos],['level_id',$l],['session',$s],['reg_course_status','E'],['semester_id',$sem]])->get();
   if(count($sql) > 0)
   {
      foreach ($sql as $key => $value) {
    $reg_id [] =$value->id;
   }
   }

   return $reg_id;
}
// get elective result

function fetch_electives($id, $s,$l,$sem,$season,$reg_id) {
 $elec = '';
$coursereg =CourseReg::whereIn('registercourse_id',$reg_id)->where([['user_id',$id],['level_id',$l],['semester_id',$sem],['session',$s],['course_status','E'],['period',$season]])->get();


  if(count($coursereg) > 0)
  {
   
    foreach ($coursereg as $key => $value) {

   $grade = $this->getSingleResult($id,$s,$l,$sem,$season,$value->course_id);
   if ($grade!=NULL && $grade!=''){
    $elec .= $value->course_unit.' '.substr_replace($value->course_code, ' ',3,0).' '.$grade->grade."<br/>";
   }
    }
  } 
  
  return $elec;
}

//------------------------------------gpa for a session ---------------------------------


function get_gpa($s,$id,$l,$season){
  
  $tcu = 0; $tgp = 0;  $course_id = array();
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
  $gp = $this->get_gradepoint ($value->grade, $cu );
   
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
private function get_crunit ($courseid, $s, $id,$season ) {
   $creg =CourseReg::where([['user_id',$id],['session',$s],['period',$season],['course_id',$courseid]])->first();

  $cu = $creg['course_unit'];
  return $cu;
}
// get grade point
private function get_gradepoint ($grade, $cu){
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
private function getResult_grade($id,$s,$l,$season,$course_id_array)
{
    $s_result =StudentResult::where([['user_id',$id],['session',$s],['season',$season],['level_id',$l]])
  ->whereIn('course_id',$course_id_array)->get();
  return $s_result;
}

// get result single
private function getSingleResult($id,$s,$l,$sem,$season,$course_id)
{
    $s_result =StudentResult::where([['user_id',$id],['session',$s],['season',$season],['level_id',$l],['course_id',$course_id],['semester',$sem]])->first();
 
return $s_result;
}


//------------------------ remarks -----------------------------------------

  function result_check_pass_sessional($l, $id, $s, $cgpa,$take_ignore=false, $taketype='')
{ $fail=''; $pass='';$c=0;$carryf ='';$rept='';
  $new_prob=$this->new_Probtion($l,$id,$s,$cgpa);
  if($new_prob==true){
    return $new_prob;
  }
  $check =StudentResult::where([['user_id',$id],['session',$s],['level_id',$l]])->get()->COUNT();
  if($check != 0){
 /*$sql_num = StudentResult::where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l]])->groupBy('course_id','id')->select('course_id','cu')->COUNT('course_id');*/
$sql =StudentResult::where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l]])->groupBy('course_id','id')->select('course_id')->get();

$c=count($sql);

if($c !=0){
foreach($sql as $key => $value)
{
 
$sql1 = StudentResult::where([['user_id',$id],['session','<=',$s],['grade','!=',"F"],['level_id','<=',$l],['course_id',$value->course_id]])->first();

$sql2 = StudentResult::where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l],['course_id',$value->course_id]])->get();
    
if (count($sql1)!=0){ //found that failed course passed in the level

$pass .= ','.$sql1->course_id;

}else{
$rowc = CourseReg::where([['user_id',$id],['course_id',$value->course_id],['level_id','<=',$l],['session','<=',$s]])->first();
    
$code = substr($rowc->course_code,0,3).' '.substr($rowc->course_code,3,4);
            
$type = substr($rowc->course_code,0,3); // GSSS
$n = count($sql2);
//$n == $c;            
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

    

  $take = (($take_ignore == true) && ($l != 4)) ? '' : $this->take_courses_sessional($id, $l, $s, $taketype);

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

function get_entry_sesssion($id)
{
  $users = DB::connection('mysql2')->table('users')
  ->find($id);
  return  $users->entry_year;
}

function new_Probtion($l,$id,$s,$cgpa){
  $fail_cu=$this->get_fail_crunit($l,$id,$s);
$return ='';
     if($fail_cu > 15 || $cgpa >=0.00 && $cgpa <=0.99 ){
      
    $return = 'WITHDRAW';
    }
    elseif($cgpa >=1.00 && $cgpa <=1.49 || $fail_cu ==15){

      $return = 'PROBATION';

    }elseif( $cgpa > 1.49 && $cgpa <=1.5 && $fail_cu ==15 ){
    $return = 'WITHDRAW OR CHANGE PROGRAMME';
    }
  
    return $return;
}
function get_fail_crunit($l,$id,$s){

$sql =StudentResult::where([['level_id',$l],['user_id',$id],['session',$s],['grade','F']])->get(); 
$tcu=$sql->sum('cu');
return $tcu;
}

function ignore_carryF ( $id, $course_id, $s ){
  $sql =CourseReg::where([['user_id',$id],['session',$s],['course_id',$course_id]])->get();
  if(count($sql) == 0)
  {

  return 'true';
  } else { // add this carryF course since it exist in same year
    return '';
  }
 
  
}

function take_courses_sessional($id, $l, $s, $taketype='') 
{
  //$c_duration = get_course_duration( $fos );
  $users = DB::connection('mysql2')->table('users')->find($id);
  $fos =$users->fos_id;
  $take = '';
  $result_array =array();
  if ($taketype == 'VACATION')
  { 
    
      $result = StudentResult::where([['user_id',$id],['level_id',$l],['session',$s]])
      ->whereIn('season',['NORMAL','VACATION'])->get();
      
    

  } else { //ignore vac result for take remark
     $result = StudentResult::where([['user_id',$id],['level_id',$l],['session',$s]])
      ->whereIn('season',['NORMAL'])->get();
  }
if(count($result) > 0)
      {
      foreach ($result as $key => $value) {
        $result_array [] = $value->course_id;
      }
      $sql =RegisterCourse::where([['fos_id',$fos],['level_id',$l],['session',$s],['reg_course_status','C']])
      ->whereNotIn('course_id',$result_array)->get();
      if(count($sql) > 0)
      {
        foreach ($sql as $key => $value) {
              $take.= ', '.substr($value->reg_course_code,0,3).' '.substr($value->reg_course_code,3,4);
        }
    
      }
     
    }

 
  return $take != '' ? substr($take,2) : '';
  }

  

  function G_duration($id){
  $users = DB::connection('mysql2')->table('users')->find($id);
  $fos =Fos::find($users->fos_id);
  return $fos->duration;  
}


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

function get_cgpa($s,$id,$season){

$tcu = 0; $tgp = 0;$coursereg_id =array();
$coursereg =CourseReg::where([['user_id',$id],['session','<=',$s]])->get();
foreach ($coursereg as $key => $value) {
$coursereg_id [] =$value->id;
}

if($season == 'VACATION')
{
    $result = StudentResult::where([['user_id',$id],['level_id','!=',0],['session','<=',$s]])
      ->whereIn('season',['NORMAL','VACATION'])
      ->whereIn('coursereg_id',$coursereg_id)->get();
}else
{
$result = StudentResult::where([['user_id',$id],['level_id','!=',0],['session','<=',$s],['season',$season]])->whereIn('coursereg_id',$coursereg_id)->get();
}

 
if(count($result) > 0)
{
  foreach ($result as $key => $value) {
   
  $cu = $this->get_crunit($value->course_id,$s,$id,$season);
  $gp = $this->get_gradepoint ($value->grade,$cu);

    $tcu += $cu;
    $tgp += $gp;
  }

@$gpa = $tgp / $tcu ;
$gpa = number_format ($gpa,2); 
return $gpa;
}
return 0;
}

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

}	