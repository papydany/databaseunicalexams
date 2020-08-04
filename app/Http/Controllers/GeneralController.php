<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Pin;
use App\StudentResult;
use App\StudentResultBackup;
use Illuminate\Support\Facades\Session;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit_matric_number($id)
    {
    $user =DB::connection('mysql2')->table('users')->find($id);
   

    if($user == null)
    {
        Session::flash('warning',"Students does not exist.");
    
    }
    return view('general.edit.matric_number')->withU($user);
    }

    public function post_edit_matric_number(Request $request)
    {
        $old_matric_number = $request->input('old_matric_number');
        $new_matric_number = $request->input('matric_number');
        $id = $request->input('id');
        
       
        if($new_matric_number != $old_matric_number)
        {
        $this->validate($request,array('matric_number' => 'bail|required|unique:mysql2.users',));
        }
        $user = User::on('mysql2')->find($id);
        $old_matric_number  = $user->matric_number;
        $user->matric_number = $new_matric_number;
        $user->password = bcrypt($new_matric_number);
        
        $user->save();
        
        // ==== updated result table
        StudentResult::where('user_id',$id)
        ->update(['matric_number' => $new_matric_number]);

        // ==== updated backup result table
        StudentResultBackup::where('user_id',$id)
        ->update(['matric_number' => $new_matric_number]);
        
        // ==== pin
        Pin::where([['student_id',$id],['matric_number',$old_matric_number]])
        ->update(['matric_number' => $new_matric_number]);
        
        
        
           Session::flash('success',"SUCCESSFULL");
           return back();
    }

    public function edit_profile($id)
    {
    $user = User::on('mysql2')->find($id);
    return view('general.edit.profile')->withU($user);
    }

    public function post_edit_profile(Request $request)
    {
        $id = $request->input('id');
        $this->validate($request,array('email' => 'required|unique:mysql2.users,email,'.$id,));

        
        $surname = $request->input('surname');
        $firstname = $request->input('firstname');
        $othername = $request->input('othername');
        $phone= $request->input('phone');
        $email = $request->input('email');

        $user = User::on('mysql2')->find($id);
      
        $user->surname = strtoupper($surname);
        $user->firstname = strtoupper($firstname);
        $user->othername = strtoupper($othername);
        $user->phone = $phone;
        $user->email = strtolower($email);
        
        $user->save();
        Session::flash('success',"SUCCESSFULL");
        return back();
    }

    public function updatedepartment(Request $request)
    {
      
      $u =DB::connection('mysql2')->table('users')
            ->where('id', $request->user_id)
            ->update(['faculty_id' =>$request->faculty_id,'department_id' => $request->department_id,'fos_id' => $request->fos_id]);
            Session::flash('success',"SUCCESSFULL");
            return back();
    }

 


}
