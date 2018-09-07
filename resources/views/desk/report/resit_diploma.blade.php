@extends('layouts.display')
@section('title','REPORT')
@section('content')
@inject('R','App\R')
<style type="text/css">
@media print,Screen{
 html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,font,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td{border:0 none;font-size:100%;vertical-align:baseline;margin:0;padding:0;}
 
  .thead th{ border-right:1px solid #000;} 
 .table-bordered {border: 1.5px solid #000;
} 
.table-bordered > tbody > tr > td{border: 2px solid #000 !important;}
.table-bordered > tbody > tr > th{border: 2px solid #000 !important;}
.table-bordered > thead > tr > td{padding: 1px; border: 2px solid #000 !important;}
.table-bordered > thead > tr > th{padding: 1px; border: 2px solid #000 !important;}
.table > tbody > tr > td{padding: 1px !important;}
.table > tbody > tr > th{padding: 0px !important;}

.tB{ border-top:1px solid #000 !important;}
.bbt{ vertical-align:bottom; width:65px;}
.B{ font-weight:700;}
body{font-size: 14px;}
.ups{
-webkit-transform: rotate(-90deg);
-moz-transform: rotate(-90deg);
-o-transform: rotate(-90deg);
-khtml-transform: rotate(-90deg);

filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
height:70px;
text-align:center;
width:20px;
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
.s9{ font-size:10px;}
.dw{ width:140px; display:block; word-spacing:.1px;}

}
@media print{
.pagination{display: none}
}


</style>
  <div class="row" style="min-height: 520px;padding-left: 0px; padding-right: 0px;">
     <div class="col-sm-12">
          
                   <?php   $d = $R->get_departmetname(Auth::user()->department_id);

                      $f = $R->get_facultymetname(Auth::user()->faculty_id);

                      $fos_name =$R->get_fos($fos);


                      $reg_course_elective_id1 =$R->getRegisteredCourseElective($s,$l,1,$fos);
                      $reg_course_elective_id2 =$R->getRegisteredCourseElective($s,$l,2,$fos);

                     if(empty($n1c))
                      {
                         $n1c = 1;
                         $regc1 = array('');
                      }
                     
                       if(empty($n2c))
                      {
                         $n2c = 1;
                         $regc2 = array('');
                      }
                      

                      if($l > 1)
                      {
                        // greater than 1 condition
                     $no1 =$n1c + 2;  
                     $no2 =$n2c + 2;
                      }else{
                        // equal to 1 condition
                     $no1 =$n1c + 1;  
                     $no2 =$n2c + 1;
                      }

                    if( $l > 1 )
  {

    
    $set['rpt'] = array(0=>'<th>REPEAT COURSES</th>', 1=>'<th></th>', 2=>'<th class="tB"></th>');
    $set['carry'] = array(0=>'<th>CARRY OVER COURSES</th>', 1=>'<th></th>', 2=>'<th class="tB">CH</th>');
    $set['cpga'] = array(0=>'<th>CGPA</th>', 1=>'<th></th>', 2=>'<th class="tB"></th>');
    $set['chr'] = array(1=>'<th class="tB s9 bbt">Repeat/Carryover Result</th>', 2=>'<th class="tB"></th>');
    $set['plus'] = 1;
    $set['wrong_fix'] = '';
    
  } else {
    
    $set['rpt'] = array(0=>'', 1=>'', 2=>'');
    $set['carry'] = array(0=>'', 1=>'', 2=>'');
 $set['cpga'] = array(0=>'<th>CGPA</th>', 1=>'<th></th>', 2=>'<th class="tB"></th>');
    $set['chr'] = array(1=>'', 2=>'');
    $set['plus'] = 0;
    $set['wrong_fix'] = '<p style=" text-align:right;">CH</p>';

  }


    
    $set['class'] = array(0=>'', 1=>'', 2=>'');
    
   
    
    
    
    $set['bottom'] = '<p style="margin-left:0px">
              <span>_______________________</span>
              <span style="color:#000; padding-left:3px"></span>
              <span style="color:#000; padding-left:3px; font-size:10px;" class="B">(HEAD OF DEPT)</span>
              <span style="color:#000; padding:20px 0 0 3px; font-size:10px;">DATE: .....................................................</span>
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
              <span style="color:#000; padding:20px 0 0 3px; font-size:10px;">DATE: .............................................................</span>
            </p>
            
            <p style="margin-right:0;"> 
              <span>___________________________</span>
              <span style="color:#000; padding-left:3px"></span>
              <span style="color:#000; padding-left:3px; font-size:10px;" class="B">(CHAIRMAN SERVC)</span>
              <span style="color:#000; padding:20px 0 0 3px; font-size:10px;">DATE: .............................................................</span>
            </p>';

              
 // }
  

                   ?>
                   <table  class="table table-bordered">
                      <tr>
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
                       <tr>
                          <td bgcolor="#cec">
                              <div class="col-sm-12 text-center"> 
                              <p><strong>EXAMINATION REPORT SHEET<br/>
                              {{$t}} RESULTS</strong></p> 
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
                      <?php
                     echo  $set['rpt'][0],
                      $set['carry'][0];
                      ?>
                      <th class="text-center" colspan="{{$no1}}">FIRST SEMESTER RESULTS</th>
                      <th class="text-center" colspan="{{$no2}}">SECOND SEMESTER RESULTS</th>
                      <th class="text-center">GPA</th>
                      <?php
                      echo $set['cpga'][0],
                          $set['class'][0];
                          ?>
                      <th  class="text-center">REMARKS</th>
                      
                    </tr>
                      
                  <tr class="thead">
                  <th></th>
                  <th></th>
                  <th></th>
                  <?php
     echo $set['rpt'][1],
          $set['carry'][1];
  

  if( $n1c != 0 || $n2c != 0 ) {
    
    echo $set['chr'][1];
    
    $sizea = $n1c; //+ 1;
    $sizeb =  $n1c + 1 + $n2c + 1;
  
    $k = (int)($n1c + $n2c) + 1 + 2; // additional 2 is for the two elective spaces
   // dd($regc1);

    $list = array_merge( $regc1, array(1=>'elective'), array(1=>''), $regc2, array(1=>'elective') );
    

    for($i=0; $i<$k; $i++) {

      if( $i == $sizea ) {
        // input 1st elective
        echo '<th class="tB s9 bbt"></th>';
        continue;
      }
      if( $i == $sizeb ) {
        // input 2nd elective
        echo '<th class="tB s9 bbt"></th>';
        continue;
      }
      
      if( $i == ($n1c + 1) )
        echo $set['chr'][1];
    
      else {
        echo '<th class="tB"><p class="ups">',isset($list[$i]['reg_course_code']) ? strtoupper($list[$i]['reg_course_code']) : '','</p></th>';
      }
    }
  
  } else {
    echo '<th></th>';
  }
  
  echo 
    '<th></th>',
     $set['cpga'][1],
     $set['class'][1],
     '<th></th>',
     '</tr>';

     echo '<tr class="thead">',
     '<th class="tB"></th>',
     '<th class="tB"></th>',
     '<th class="tB">',$set['wrong_fix'],'</th>',
     $set['rpt'][2],
     $set['carry'][2];

  if($n1c != 0 || $n2c != 0 ) {
    //echo $k, $sizea, $sizeb;
    echo $set['chr'][2];
    
    for($i=0; $i<$k; $i++) {

      if( $i == $sizea ) {
        // input 1st elective
        echo '<th class="tB s9"></th>';
        continue;
      }
      if( $i == $sizeb ) {
        // input 2nd elective
        echo '<th class="tB s9"></th>';
        continue;
      }
      
      if( $i == ($n1c + 1) )
        echo $set['chr'][2];
      else
        echo '<th class="tB">',isset($list[$i]['reg_course_unit']) ? $list[$i]['reg_course_unit'] : '','</th>';
    }
  
  } else
    echo '<th></th>';
  
  
  echo '<th class="tB"></th>',
     $set['cpga'][2],
     $set['class'][2],
     '<th class="tB"></th>',
     '</tr></thead>';    
  
 
 
if($pn >= 1)
{
  $pn1 =$pn -1;
  $c = $page * $pn1;
}
else
{ $c = 0;}

  ?> 
 @if(count($u) > 0)
  
    
  @foreach($u as $v)
  

 {{! $fullname = $v->surname.' '.$v->firstname.' '.$v->othername}}
 <?php  
$first_grade = $R->getStudentResult($v->id, $course_id1, $s, $flag,$season);

$second_grade = $R->getStudentResult($v->id,$course_id2,$s,$flag,$season);

$first_semester = empty($first_grade) ? array('') : $first_grade;

$second_semester = empty($second_grade) ? array('') : $second_grade;

 $ll = array_merge($first_semester, array(1=>array()), array(1=>array()), $second_semester, array(1=>array()) );

$gpa = $R->get_gpa($s,$v->id,$l,$season);

$cgpa =$R->get_cgpa($s,$v->id,$season);

$remark = $R->result_check_pass_sessional_diploma($l,$v->id,$s, $cgpa,$take_ignore=false,$season);

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
            
            if( $i == ($n1c + 1) ) {
              if( $l > 1 ) {

              
              }
            }
            else {
              
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
          } 
           echo'<td>',$gpa,'</td>';
            echo'<td>',$cgpa,'</td>';
        echo '<td class="s9"><div class="dw">',$remark,'</div></td>';


?>

  </tr>
  @endforeach

  @else
  <div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center" role="alert" >
   No records of students is available
    </div>
  @endif
</tbody>

</table>    
<div class="sph block bl" style="margin-top:30px; ">
  <div style="border-bottom:2px solid #000; padding:4px 10px;" class="block B">STATISTICS</div>
  <div class="st block">
  <div><p class="a">No Of Students Registered</p> <p class="b">
{{count($users)}}
 </p></div>
  <div><p class="a">No of Results Published</p> <p class="b">{{count($users)}}</p></div>
  </div>
  </div>


<div class="sph block" style="margin-top:40px;"><?php echo $set['bottom'] ?></div>

<div class="sph center" style="text-align:center; font-size:15px; font-weight:700;">Date of Senate Approval :  .......................................................................</div>     
{{$u->setPath($url)->render()}}
     </div>

  </div>
@endsection