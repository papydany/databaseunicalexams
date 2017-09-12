<?php
namespace App\Http\Traits;



trait MyTrait {


   public function mm( $G, $U ) {

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
        }
        return $return;
    }
 public function get_grade($total)
 {

  switch($total) {
      case $total =='No Score':
               $return['grade']  = '';
             
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
    
 }
    
}