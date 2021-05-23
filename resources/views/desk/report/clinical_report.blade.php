<?php ini_set('max_execution_time', 3000); ?>
@extends('layouts.display')
@section('title','REPORT')
@section('content')
@inject('R','App\R')

<style type="text/css">
@media print,Screen{
 html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,font,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td{border:0 none;font-size:100%;vertical-align:baseline;margin:0;padding:0;}
 
  .thead th{ border-right:1px solid #000;} 
 .table-bordered {border: 1px solid #000;
} 
.table-bordered > tbody > tr > td{border: 2px solid #000 !important;}
.table-bordered > tbody > tr > th{border: 2px solid #000 !important;}
.table-bordered > thead > tr > td{padding: 1px; border: 2px solid #000 !important;}
.table-bordered > thead > tr > th{padding: 1px; border: 2px solid #000 !important;}
.table > tbody > tr > td{padding: 0.3px !important;}
.table > tbody > tr > th{padding: 0.3px !important;}

.tB{ border-top:1px solid #000 !important;}
.bbt{ vertical-align:bottom; width:65px;}
.B{ font-weight:700;}
body{font-size: 12px;}
.ups{
-webkit-transform: rotate(-90deg);
-moz-transform: rotate(-90deg);
-o-transform: rotate(-90deg);
-khtml-transform: rotate(-90deg);

filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
height:65px;
text-align:center;
width:15px;
position:relative;
left:25px;
top:15px;

}

.bl{ border:2px solid #000; display:block; overflow:hidden; margin-bottom:5px; padding:3px 5px 5px;}
.bl p{ margin-bottom:2px;}
.sph p{ float:left; margin-right:20px;}
.sph p span{ display:block; color:#000;}
.center{ margin:40px auto; display:block;}
.block{ display:block; overflow:hidden;}
.st div{ padding-top:5px; display:block; overflow:hidden; padding-left:20px; }
.st .a{ color:#000; width:200px;}
.st .b{ color:#000;}
.s9{ font-size:8px;color:#000;}
.dw{ width:140px; display:block; word-spacing:.1px;}

}
@media print{
.pagination{display: none}
}


</style>
 <?php   
 $d = $R->get_departmetname($d);
 $f = $R->get_facultymetname($f);
 $fos_name =$R->get_fos($fos);

if(empty($n1c))
{
$n1c = 1;
$regc1 = array('');
}


// greater than 1 condition
$no1 =$n1c;


$set['rpt'] = array(0=>'<th class="s9 text-center">REPEAT COURSES</th>', 1=>'<th></th>', 2=>'<th class="tB"></th>');
$set['chr'] = array(1=>'<th class="s9 text-center">REPEAT RESULT</th>', 2=>'<th class="tB"></th>');

$set['plus'] = 1;
$set['wrong_fix'] = '';

$set['bottom'] = '<p style="margin-left:0px">
              <span>_______________________</span>
              <span style="color:#000; padding-left:3px"></span>
              <span style="color:#000; padding-left:3px; font-size:10px;" class="B">(HEAD OF DEPT)</span>
              <span style="color:#000; padding:20px 0 0 3px; font-size:10px;">DATE: ...............................................</span>
            </p>
            <p> 
              <span>______________________________</span>
              <span style="color:#000; padding-left:3px"></span>
              <span style="color:#000; padding-left:3px"></span>
              <span style="color:#000; padding-left:3px; font-size:10px;" class="B">(DEAN OF '.strtoupper($f).')</span>
              <span style="color:#000; padding:20px 0 0 3px; font-size:10px;">DATE: .............................................................</span>
            </p>
            <p> 
              <span>_______________________</span>
              <span style="color:#000; padding-left:3px"></span>
              <span style="color:#000; padding-left:3px; font-size:10px;" class="B">(EXTERNAL EXAMINER)</span>
              <span style="color:#000; padding:20px 0 0 3px; font-size:10px;">DATE: ..................................................</span>
            </p>
            
            <p> 
              <span>___________________________</span>
              <span style="color:#000; padding-left:3px"></span>
              <span style="color:#000; padding-left:3px; font-size:10px;" class="B">(CHAIRMAN SERVC)</span>
              <span style="color:#000; padding:20px 0 0 3px; font-size:10px;">DATE: .....................................................</span>
            </p>
            <p style="margin-right:0;"> 
          <br/><br/>
            <span style="color:#000; padding-left:3px; font-size:10px;" class="B"></span>
            <span style="color:#000; padding:20px 0 0 3px; font-size:10px;">Date of Senate Approval: .....................................................</span>
          </p>'
            ;

              
 // }
            
  ?>
   <div class="row" style="min-height: 520px;padding-left: 0px; padding-right: 0px;">
     <div class="col-sm-12">
      
                   <table  class="table table-bordered">
                    
                 
                      <tr class="thead">
                      	<td>
                             <p class="text-center" style="font-size:18px; font-weight:700;">
                                UNIVERSITY OF CALABAR </br>
                            CALABAR</p>
    
                              <div class="col-sm-9 www" style="padding-left: 0px; padding-right: 0px;">
  
                                  <p>FACULTY: {{$f}}</br>
                                 DEPARTMENT: {{$d}}</br>
                                  PROGRAMME:  {{$fos_name }}</p>
                              </div>
                              <div class="col-sm-3 ww" style="padding-left: 0px; padding-right: 0px; float: right;">
                                  {{!$next = $s + 1}}
                                  <p> <strong>YEAR OF STUDY : </strong>{{$l.' / '.$duration}}</br>
                                 <strong>SESSION : </strong>{{$s.' / '.$next}}</br>
                                  <strong>SEMESTER : </strong>FIRST & SECOND </p>
                              </div>
                         </td>
                       </tr>
                       <tr class="thead">
                          <td bgcolor="#cec">
                          	  <div class="col-sm-12 text-center"> 
                          	  <p><strong>PROFESSIONAL EXAMINATION REPORT SHEET<br/>
                          PART @if($l == 3)
                                 I
                            @elseif($l ==4)
                            II
                            @elseif($l ==5)
                            III
                            @elseif($l ==6)
                            IV
                            @endif
                              M.B.BCH RESULTS</strong></p> 
                          	  </div>
                         </td>
                      </tr>
                 
                </table>
               
                  <table class="table table-bordered">
                    <thead>
                  	<tr class="thead">
                  		<th class="text-center text-size">S/N</th>
                  		<th class="text-center">NAME</th>
                  		<th  class="text-center">REG NO</th>
                     
                  		<th class="text-center" colspan="{{$no1}}">COURSE TAKEN</th>
                  		
                  		<th  class="text-center">REMARKS</th>
                  		
                  	</tr>
                  		
                  <tr class="thead">
                  <th></th>
                  <th></th>
                  <!--<th></th>
                  <th></th>-->
                  <th></th>
                  <?php
     

  if( $n1c != 0 || $n2c != 0 ) {
    
    
    
    $sizea = $n1c; //+ 1;
    $sizeb =  $n1c;
  
    $k = (int)($n1c); // additional 2 is for the two elective spaces
   // dd($regc1);

    $list = array_merge( $regc1 );
//  var_dump($list); 
//dd();
    for($i=0; $i<$k; $i++) {

    
      
      if( $i == ($n1c + 1) )
       {}
    
      else {
       echo '<th class="tB"><p class="">',isset($list[$i]->reg_course_title) ? strtoupper($list[$i]->reg_course_title) : '','</p></th>';
      }
    }
  
  } else {
    echo '<th></th>';
  }
  
  echo 
    '<th></th>',
  
     
     '</tr>';

 
    
 
if($cpage >= 1)
{
  $pn1 =$cpage -1;
  $c = $page * $pn1;
}
else
{ $c = 0;}

  ?> 
 @if(count($u) > 0)
  
    
  @foreach($u as $v)
  

 {{! $fullname = $v->surname.' '.$v->firstname.' '.$v->othername}}
 <?php  
 //dd($season);
$first_grade = $R->getStudentResult($v->id,$course_id1,$s,$season);

$first_semester = empty($first_grade) ? array('') : $first_grade;


$ll = array_merge($first_semester,  array(1=>array()) );

 //$repeat_course =$R->repeat_course($v->id,$s,$l,$season);

$remark =$R->clinicalRemarks($l,$v->id,$s,$season);
 ?>
 <tbody>
<tr>
    <td>{{++$c}}</td>
    <td>{{strtoupper($fullname)}}</td>
    <td>{{$v->matric_number}}</td>
<?php
  

for($i=0; $i<$k; $i++) {
            
            if( $i == $sizea ) {
 
              echo '<td class="tB s9"></td>';
              continue;
            }
            if( $i == $sizeb ) {


              echo '<td class="tB s9"></td>';
              continue;


            }
            
        
              
              if( isset($ll[$i]['grade']) ) { 

                if( $ll[$i]['grade'] == '&nbsp;&nbsp;' ) {
                  echo '<td class="tB" style="background:yellow"></td>';
                } else {
                  echo '<td class="tB">',$ll[$i]['grade'],
                  '</td>';
                }
   
              
              } else { //  Jst for GUI purpose
                echo '<td class="tB"></td>';
              }
             
            
          } 
          
        
        echo '<td class="s9"><div class="dw">',$remark,'</div></td>';


?>

  </tr>
  @if($t =="CORRECTIONAL")

  <tr>
    <td>Prev</td>
    <td>{{strtoupper($fullname)}}</td>
    <td>{{$v->matric_number}}</td>
<?php

$first_grade_cor = $R->getStudentResultCorrection($v->id,$course_id1,$s,$season);

$second_grade_cor = $R->getStudentResultCorrection($v->id,$course_id2,$s,$season);

$first_semester_cor = empty($first_grade_cor) ? array('') : $first_grade_cor;

$second_semester_cor = empty($second_grade_cor) ? array('') : $second_grade_cor;

$ll_cor = array_merge($first_semester_cor, array(1=>array()), array(1=>array()), $second_semester_cor, array(1=>array()) );
$gpa_cor = $R->get_gpa_correctional($s,$v->id,$l,$season);
$remark_cor = $R->remarks_correctional($l,$v->id,$s,$season, $gpa_cor, $fos,$take_ignore=false);
//$remark_cor =remarks_correctional($p, $f, $d, $l,$id,$s,$season, $cgpa, $fos, $finalyear = false, $new=false);

if( $l > 1 ) {
echo '<td class="s9">',$repeat_course,'</td>';
echo '<td class="s9">',$R->get_drop_course($v->id,$l,$s,$fos),'</td>';
echo '<td class="tB s9">',$R->get_failed_drop_course_result($v->id,$l,$s,1, $repeat_1, $drop_1),'</td>';              
              }
for($i=0; $i<$k; $i++) {
            
            if( $i == $sizea ) {
 
              echo '<td class="tB s9"></td>';
              continue;
            }
            if( $i == $sizeb ) {


              echo '<td class="tB s9"></td>';
              continue;


            }
            
            if( $i == ($n1c + 1) ) {
              if( $l > 1 ) {

              echo '<td class="tB s9">',$R->get_failed_drop_course_result($v->id,$l,$s,2, $repeat_2, $drop_2);' </td>';
              }
            }
            else {
              
              if( isset($ll_cor[$i]['grade']) ) { 

                if( $ll_cor[$i]['grade'] == '&nbsp;&nbsp;' ) {
                  echo '<td class="tB" style="background:yellow"></td>';
                } else {
                  echo '<td class="tB">',$ll_cor[$i]['grade'],
                  '</td>';
                }
   
              
              } else { //  Jst for GUI purpose
                echo '<td class="tB"></td>';
              }
             
            }
          } 
           echo'<td>',$gpa_cor,'</td>';
           if( $l > 1 ) {
           echo'<td>',$cgpa,'</td>';
         }
         
        echo '<td class="s9"><div class="dw">',$remark_cor,'</div></td>';


?>

  </tr>
  @endif
  @endforeach

  @else
  <div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center" role="alert" >
   No records of students is available
    </div>
  @endif
</tbody>

</table> 
<div class="sph block bl" style="margin-top:30px;">
<div style="border-bottom:2px solid #000; padding:4px 10px;" class="block B">
  <div class="col-sm-4"><p class="a">STATISTICS  </p></div> 
  <div class="col-sm-4"> <p class="a">Number Of Students Registered</p> <p class="b">
{{count($users)}}</p></div>
<div class="col-sm-4"><p class="a">Number of Results Published</p> 
<p class="b">{{count($users)}}</p></div>
  
  </div>
  </div>


  <div class="sph block" style="margin-top:30px;"><?php echo $set['bottom'] ?>
<div class='col-sm-12' style="text-align:center;">page {{$cpage}}</div>
</div>   
{{$u->setPath($url)->render()}}

   


 
  </div>

  </div>
@endsection