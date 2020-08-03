<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\User;
use App\PasswordReset;
use Auth;
use Mail;
use DB;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function password_reset()
    {
        return view('auth.passwords.index');
    }

    public function post_password_reset(Request $request)
    {
    $this->validate($request, ['username' => 'required',]);
    $u = User::where('username',$request->input('username'))->first();
    if ($u != null)
    {
        $check =DB::table('password_resets')->where('email',$request->username)->first();
        if($check != null)
        {
    DB::table('password_resets')->where('email',$request->username)->delete();

        }
        $token = str_random(64);
         $email =$u->email;
        if($email != null){
            $new =DB::table('password_resets')->insert(['email' => $request->username, 'token' => $token]);

         $data = array('email' => $email,'token' => $token);

  Mail::send(array('html'=>'emails.password_reset'), $data, function($message) use ($data)  {
                
                $message->to($data['email'],$data['token']);
                $message->subject("Reset Your Password");

            });
}else
{
    Session::flash('warning',"your have no email on your account. contact system admistrator");
    return back(); 
}
Session::flash('success',"Check your email .For reset link.");
      return view('auth.passwords.index');

    }else
    {
       Session::flash('warning',"please check your username.");
            return back(); 
    }


}
public function password_reset_token(Request $request, $token)
{
    if(isset($token))
    {
$check = DB::table('password_resets')->where('token',$token)->first();
if($check != null)
{
   return view('auth.passwords.newpassword')->withU($check); 
}else
{
    Session::flash('warning',"Please the link has expired. please enter your username to reset again ");
      return view('auth.passwords.index');
}

}
}

public function post_password_reset_token(Request $request)
{
    $this->validate($request, ['password' => 'required|string|min:6|confirmed',]);
  $user = User::where('username',$request->username)->first();
  $user->password =bcrypt($request->password);
  $user->plain_password =$request->password;
  $user->save();
   DB::table('password_resets')->where('email',$request->username)->delete();
    Session::flash('success',"password change successfully.");

   return redirect('/'); 
}
}

