<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use App\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)

    {

        $this->validate($request, [

            'username' => 'required',
             'password' => 'required'
            

        ]);


        if (auth()->attempt(array('username' => $request->input('username'), 'password' => $request->input('password'))))
 {
     $user_id = auth()->user()->id;
     $role = DB::table('roles')
            ->join('user_roles', 'user_roles.role_id', '=', 'roles.id')
            ->Where('user_roles.user_id',$user_id)
            ->select('roles.name')
            ->first();
            if(auth()->user()->edit_right > 0)
            {
             $new_e =auth()->user()->edit_right - 1;

             $u =User::find( $user_id);
             $u->edit_right =$new_e;
             $u->save();
            }    
            return redirect($role->name); 

    

        }else{
            Session::flash('warning',"please check your username and password.");
            return back();

        }

   
}
}
