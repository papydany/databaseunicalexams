<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Pin;
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

//========================================view un_used_ Pin =====================================
 public function view_unused_pin()
 {
 	
 	$unused_pin = Pin::where('status',0)->paginate(500);
 	
 	return view('support.view_unused_pin')->withUnused_pin($unused_pin);
 }
//========================================view used_ Pin =====================================

 public function view_used_pin()
 {
 	$used_pin = Pin::where('status',1)->paginate(500);
 	return view('support.view_used_pin')->withUsed_pin($used_pin);
 }

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
        $characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZabcdeghnqrty';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
     }
}
