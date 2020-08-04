<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Pin;
use App\User;
use App\Department;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Http\Traits\MyTrait;

class SupportController extends Controller
{
   use MyTrait;
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     return view('support.index');
    }

    //======================================== Get create Pin =====================================
    public function get_create_pin()
    {
      
    	return view('support.get_create_pin');
    }
//======================================== post create Pin =====================================
    function post_create_pin(Request $request)
    {
    ini_set('max_execution_time', 980);    
    $this->validate($request,array(
    'number'=>'required',
     'pin_lenght'=>'required',
    'session' => 'required',
       ));
$pin =new Pin;

$pin->session = $request->session;
$pin->status= 0;

     
for ($i = 0; $i <=$request->number; $i++) {
  $rand = $this->generateRandomString($request->pin_lenght);
  $pin->pin = $rand;
 $check =Pin::where([['pin',$rand],['session',$request->session]])->first();
  if($check == null)
  {
 	DB::table('pins')->insert(['pin' => $rand, 'status' => 0,'session'=>$request->session]);


  }
 else{

  	$i--;
  }

 
    }
       Session::flash('success',"SUCCESSFULL.");
    	return view('support.get_create_pin');

    }
    //============== get_student_with_entry_year===========
    public function get_student_with_entry_year(Request $request)
    {
        $entry_year =$request->entry_year;
   $user = DB::connection('mysql2')->table('users')->where('entry_year',$entry_year)->orderBy('department_id','ASC')->paginate(500);

return view('support.entry_year')->withU($user);
    }

//========================================view un_used_ Pin =====================================
 public function view_unused_pin()
 {
 	
 	$unused_pin = Pin::where('status',0)->orderBy('id','ASC')->paginate(500);
 	
 	return view('support.view_unused_pin')->withUnused_pin($unused_pin);
 }
//========================================view used_ Pin =====================================

 public function view_used_pin()
 {
 	//$used_pin = Pin::where('status',1)->paginate(500);
 	return view('support.view_used_pin');
 }
 public function post_used_pin(Request $request)
 {
      $s =$request->input('session');

    $used_pin = Pin::where([['status',1],['session',$s]])->orderBy('updated_at','DSC')->get();  
  
        $url ="get_used_pin?session=".$s;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($used_pin);

        //Define how many items we want to be visible in each page
        $perPage = 500;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage- 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

       // return view('search', ['results' => $paginatedSearchResults]);
   
    return view('support.view_used_pin')->withU($paginatedSearchResults)->withUrl($url)->withUsed_pin($used_pin);
 }
// =======================  seria number  ==================
  public function post_serial_number(Request $request)
 {
      $id =$request->input('serial_number');

    $pin = Pin::find($id);
   if($pin == null)
   {
    $request->session()->flash('warning', ' No Records is not available');
 return redirect()->action('SupportController@view_used_pin'); 
   }
   $user = DB::connection('mysql2')->table('users')->where('matric_number',$pin->matric_number)->first();

    return view('support.view_used_pin')->withPin($pin)->withUser($user);
 }
 // =================== convert pin =================================

 public function convert_pin()
 {
return view('support.pin.convert');
 }

 //========post convert pin ================
 public function post_convert_pin(Request $request)
 {
    $s =$request->start_serial_number;
  
    $e =$request->end_serial_number;
    for ($i=$s; $i <= $e; $i++) {

     
        $pin =Pin::find($i);
        if($pin != null)
        {
        if($pin->status == 0)
        {
//var_dump($pin->id);
      $pin->session =$request->session;
     
        $pin->save();
    }
}
    }
   //dd();
    $request->session()->flash('success', ' SUCCESSFULL');
 return redirect()->action('SupportController@convert_pin');
 }
 //================== export pin =========================================
 public function export_pin()
 {
   
    // Generate and return the spreadsheet
    Excel::create('pins_three', function($excel){

        // Set the spreadsheet title, creator, and description
        $excel->setTitle('Pins');
        $excel->setCreator('Laravel')->setCompany('Unicalexams, Database');
        $excel->setDescription('Scratcard Pin');
 
        // Build the spreadsheet, passing in the payments array
        $excel->sheet('sheet1', function($sheet)  {
$pin = Pin::orderBy('id','ASC')->take(15000)->get();
//$pin = Pin::where('id','>=','48582')->orderBy('id','ASC')->get();
    // Define the Excel spreadsheet headers
   
 foreach ($pin as $v) {
       $data[] = array($v->id,$v->pin,);
    }


$sheet->fromArray($data, null, 'A1', false, false);
$headings = array('serial number','pins');

$sheet->prependRow(1, $headings);
        });

    })->download('xlsx');
 }
 /*--------------------------------------function  --------------------------------------------------*/
 private function generateRandomString($length) {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
     }
// =================== get student pin ===========================
     public function student_pin()
     { $d = Department::orderBy('department_name','ASC')->get(); 
     $fos = $this->get_fos();
     $u =User::find(Auth::user()->id);
    
          return view('support.student_pin')->withD($d)->withF($fos)->withUd($u);
     }

      public function get_student_pin(Request $request)
     { 
     $session =$request->session;
     $department =$request->department;
     $fos =$request->fos;
     $l =$request->level;
     $matric_number =array();
    
 // $f =$request->fos;
  $d = Department::orderBy('department_name','ASC')->get();
  $foss = $this->get_fos();
  $ud =User::find(Auth::user()->id); 
  if($l == 1)
  {
    $user = DB::connection('mysql2')->table('users')
    ->where([['entry_year',$session],['fos_id',$fos]])->orderBy('matric_number','ASC')->get();
  }else
  {
    $user = DB::connection('mysql2')->table('users')
    ->join('student_regs', 'users.id', '=', 'student_regs.user_id')
   ->where('users.fos_id',$fos)
   ->where([['student_regs.session',$session],['student_regs.level_id',$l],['student_regs.semester',1]])
   ->orderBy('matric_number','ASC')
    ->select('users.*')
    ->get();
  }


   return view('support.student_pin')->withD($d)->withU($user)->withDi($department)->withFos($fos)
  ->withG_s($session)->withF($foss)->withUd($ud)->withLevel($l);
     } 

     /*--------------------------- reset --------------------------------- */
     public function reset_pin(Request $request)
     {
      if($request->isMethod('post'))
      {
        $pin =Pin::find($request->id);
        if($pin == null){
      $request->session()->flash('warning', 'serial number does not exist');

        }else{
          $role =$this->g_rolename(Auth::user()->id);
          if($role == 'Deskofficer')
          {
            $student = DB::connection('mysql2')->table('users')->find($pin->student_id);

            if(Auth::user()->department_id != $student->department_id)
            {
              $request->session()->flash('warning', 'you can only reset pin of students in these department');
              return back();
             }
          }
        
        $pin->status = 0;
        $pin->student_type = null;
        $pin->student_id = null;
        $pin->matric_number = null;
        $pin->session= $request->session;
        $pin->save();
    $request->session()->flash('success', ' SUCCESSFULL');
        }
 return back();
      }
      return view('support.pin.reset_pin');
     }
}
