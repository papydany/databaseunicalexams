<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Http\Requests;
use Auth;
use App\Pin;
use App\Department;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use DB;
use Excel;

class SupportController extends Controller
{
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
  if(count($check) == 0)
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
   if(count($pin) == 0)
   {
    $request->session()->flash('warning', ' No Records is not available');
 return redirect()->action('SupportController@view_used_pin'); 
   }
    return view('support.view_used_pin')->withPin($pin);
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
        if(count($pin) > 0)
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
          return view('support.student_pin')->withD($d);
     }

      public function get_student_pin(Request $request)
     { 
     $session =$request->session;
     $department =$request->department;
     $fos =$request->fos;
  $d = Department::orderBy('department_name','ASC')->get(); 
   $user = DB::connection('mysql2')->table('users')->where([['entry_year',$session],['fos_id',$fos]])->orderBy('matric_number','ASC')->get();
          return view('support.student_pin')->withD($d)->withU($user)->withDi($department)->withFos($fos)->withG_s($session);
     } 
}
