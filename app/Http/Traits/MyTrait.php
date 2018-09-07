<?php
namespace App\Http\Traits;
use DB;
use App\Programme;

trait MyTrait {


   public function mm( $G, $U , $entry_year) {

        $return = array();
        if($entry_year <= 2016)
        {
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
        }
}else{
         switch( $G ) {
            case 'A':
                $return['cp'] = 4 * $U;
                break;
            case 'B':
                $return['cp'] = 3 * $U;
                break;
            case 'C':
                $return['cp'] = 2 * $U;
                break;
            case 'D':
                $return['cp'] = 1 * $U;
                break;
           
            case 'F':
                $return['cp'] = 0 * $U;
                break;
        }
    }
        return $return;
    }
 public function get_grade($total,$entry_year)
 {
if($entry_year <= 2016)
{
  switch($total) {
      case $total =='No Score':
               $return['grade']  = '';
            case $total == '0':
                 $return['grade']  = 'F';
                
                 return $return;
                break; 
                 return $return;
                 break;
            case $total >= 70:
                $return['grade'] = 'A';
               
               return $return;
                break;
            case $total >= 60:
                $return['grade']  = 'B';
                
                  return $return;
                break;
            case $total >= 50:
                 $return['grade']  = 'C';
                 return $return;
                break;
            case $total >= 45:
                 $return['grade']  = 'D';
                return $return;
                break;
            case $total >= 40:
                 $return['grade']  = 'E';
               return $return;
                break;
            case $total < 40:
                 $return['grade']  = 'F';
                
                 return $return;
                break; 
            }
}else{


     switch($total) {
      case $total =='No Score':
               $return['grade']  = '';
               return $return;
               break;
            case $total == '0':
                 $return['grade']  = 'F';
                 return $return;
                 break;
            case $total >= 70:
                $return['grade'] = 'A';
               
               return $return;
                break;
            case $total >= 60:
                $return['grade']  = 'B';
                
                  return $return;
                break;
            case $total >= 50:
                 $return['grade']  = 'C';
                 return $return;
                break;
            case $total >= 45:
                 $return['grade']  = 'D';
                return $return;
                break;
            
            case $total < 45:
                 $return['grade']  = 'F';
                
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
}