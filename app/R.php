<?php

namespace App;
use DB;
use App\PdsResult;
use App\Department;
use App\Programme;
use App\Fos;
use App\Faculty;
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


}	