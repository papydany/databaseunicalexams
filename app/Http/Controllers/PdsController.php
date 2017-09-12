<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\MyTrait;
use App\PdgUser;
use App\PdsCourse;
use Auth;
use DB;
use App\PdsResult;
use App\Service\R;
use App\PdsCourseCode;

class PdsController extends Controller
{

	
      public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {
     
  return view('pds.index');
    }

     public function pds_student()
    {
     
  return view('pds.pds_student');
    }

     public function pds_get_student(Request $request)
    {
     
      $s =$request->input('session'); 
 $semester =$request->input('semester'); 
      $user = PdgUser::where('entry_year',$s)->orderBy('surname','ASC')->get();
        
  //Get current page form url e.g. &page=6
        $url ="pds_student1?session=".$s."&semester=".$semester;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($user);

        //Define how many items we want to be visible in each page
        $perPage = 20;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage- 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

  return view('pds.pds_student')->withU($paginatedSearchResults)->withUrl($url)->withS($semester)->withSs($s);
    }

    // ======================================more enter result =============================================
    public function pds_result(Request $request)
    {
        $variable = $request->input('id');
        $semester = $request->input('semester');
          $s = $request->input('session');
        $user = PdgUser::whereIn('id',$variable)->get();
        $course =PdsCourse::get();
        return view('pds.pds_result')->withU($user)->withC($course)->withS($semester)->withSs($s);
    }

 
    //---------------------------------------------------------------------------------------------------------
  public function pds_enter_result()
  {  $course =PdsCourse::get();
  	return view('pds.pds_enter_result')->withC($course);
  }   
//--------------------------------------------------------------------------------------------------------------
  public function pds_get_result(Request $request)
  {
 $s =$request->input('session'); 
 $semester =$request->input('semester');
 $course =$request->input('course'); 
 $user = PdgUser::where('entry_year',$s)->orderBy('surname','ASC')->get();
 $course_name =PdsCourse::find($course);
        
  //Get current page form url e.g. &page=6
        $url ="pds_enter_result1?session=".$s."&semester=".$semester."&course=".$course;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($user);

        //Define how many items we want to be visible in each page
        $perPage = 20;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage- 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

  return view('pds.pds_enter_result1')->withU($paginatedSearchResults)->withUrl($url)->withS($semester)->withSs($s)->withCourse($course)->withCn($course_name);
  }

//------------------------------------------------------------------------------------------

  public function pds_post_result(Request $request)
  {

	$allcheck =$request->input('check');
	$course_id =$request->input('course');
	$session =$request->input('session');
	$semester =$request->input('semester');
	$date = date("Y/m/d H:i:s");
	$examofficer=Auth::user()->id;
	$url =$request->input('url');
	 if($allcheck == null)
{
    return back();
}
	
foreach ($allcheck as $value) {
        $check=$value; 
		$no=$check;
		$total =$request->input('total')[$no];
		$ca = $request->input('ca')[$no];
		$exam = $request->input('exams')[$no];
		$mat_no = $request->input('matric_number')[$no];
		$id =$request->input('pdg_user')[$no];

		switch($total) {
            case $total >= 70:
                $grade = 'A';
                $point= 5;
                break;
            case $total >= 60:
                $grade = 'B';
                $point= 4;
                break;
            case $total >= 50:
                $grade = 'C';
                $point= 3;
                break;
            case $total >= 45:
                $grade = 'D';
                $point= 2;
                break;
            case $total >= 40:
                $grade = 'E';
                $point= 1;
                break;
            case $total < 40:
                $grade = 'F';
                $point= 0;
                break;
        }
    
		$exit =PdsResult::where([['course',$course_id],['session',$session],['semester',$semester],['pdg_user',$id],['matric_number',$mat_no]])->first();

		if(count($exit) > 0)
		{
		 $update = PdsResult::find($exit->id);
                    $update->ca =$ca; 
                    $update->exam = $exam;
                    $update->total=$total;
                     $update->grade=$grade;
                      $update->point=$point;
                    $update->date=$date;
                    $update->examofficer =$examofficer;
                    $update->save();

		}

		$data[] =['course'=>$course_id,'session'=>$session,'semester'=>$semester,'pdg_user'=>$id,'matric_number'=>$mat_no,'ca'=>$ca,'exam'=>$exam,'total'=>$total,'grade'=>$grade,'point'=>$point,'examofficer'=>$examofficer,'date'=>$date];


	}
  if(isset($data))
        {
        if(count($data) > 0)
        {
		DB::connection('mysql2')->table('pds_results')->insert($data);
	}}
Session::flash('success',"SUCCESSFULL.");
return redirect($url);
	}
  //-----------------------------------------------------------------------------------------------
	 public function pds_view_result()
  { 

  	return view('pds.pds_view_result');
  }
  //----------------------------------------------------------------------------------------------------

   public function pds_display_result(Request $request)
    {
     $sm = $request->input('semester');
       $s = $request->input('session');
        $user = PdgUser::where('entry_year',$s)->get();
        $course =PdsCourse::orderBy('id','ASC')->get();

        return view('pds.pds_display_result')->withU($user)->withC($course)->withSs($s)->withSm($sm);
    }
    //-----------------------------------------------------------------------------------------------
	 public function pds_view_course_result()
  { 
 $course =PdsCourse::orderBy('id','ASC')->get();
  	return view('pds.pds_view_course_result')->withC($course);
  }
  //----------------------------------------------------------------------------------------------------

   public function pds_display_course_result(Request $request)
    {
     $c= $request->input('course');
       $s = $request->input('session');
        $user = PdgUser::where('entry_year',$s)->get();
        $course =PdsCourse::find($c);
 
        return view('pds.pds_display_course_result')->withU($user)->withC($course)->withSs($s)->withCs($c);
    }

   //-----------------------------------------------------------------------------------------------
	 public function pds_view_final_result()
  { 

  	return view('pds.pds_view_final_result');
  }
  //----------------------------------------------------------------------------------------------------

   public function pds_display_final_result(Request $request)
    {
    
       $s = $request->input('session');
        $user = PdgUser::where('entry_year',$s)->get();
        $course =PdsCourse::get();
 
        return view('pds.pds_display_final_result')->withU($user)->withC($course)->withSs($s);
    } 
}
