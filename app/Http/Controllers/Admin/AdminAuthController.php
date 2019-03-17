<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Mail\AdminResetPassword;
use DB;
use Carbon\Carbon;
use Mail;

class AdminAuthController extends Controller
{
    //
    public function login()
    {
    	return view('admin.login');
    }

    public function doLogin(){

		$rememberme    	 = request('rememberme') == 1 ? true: false;
    	if (admin()->attempt(['email'=> request('email'), 'password' => request('password')] , $rememberme) ) {
    		return redirect('admin');
    	}else{
    		session()->flash('error', trans('admin.wrong_login_data'));
    		return redirect(aurl('login')); // aurl helper fun
    	}
    }

    public function logout(){
    	admin()->logout();
    	return redirect('admin/login');

    }

    public function forgot_password(){
        return view('admin.forgot_password');
    }

    public function forgot_password_post(){
        $admin = Admin::where('email', request('email'))->first();
        if (!empty($admin)) {
            $token = app('auth.password.broker')->createToken($admin);

            $data = DB::table('password_resets')->insert([
                'email' => $admin->email,
                'token' => $token,
                'created_at' => carbon::now(),
            ]);

            return new AdminResetPassword(['data' => $data, 'token' => $token]);  // mail
            //Mail::to(admin()->email)->send(new AdminResetPassword(['data' => $data, 'token' => $token]));
            session()->flash('success', trans('admin.the_link_reset_sent'));
            return back();
        }
        return back();
    }

    public function reset_password($token){
        $check_token = DB::table('password_resets')->where('token', $token)->where('created_at', '>', carbon::now()->subHours(2))->first();
        if(!empty($check_token)){
            return view('admin.reset_password', ['data'=> $check_token]);
        }else{
            return redirect(aurl('forgot/passwoed'));
        }
    }

    public function reset_password_post($token){
        $this->validate(request(),[
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
        ],[],[
                'password' => 'Password',
                'password_confirmation' => 'Confirmation Password',
        ]);

        $check_token = DB::table('password_resets')->where('token', $token)->where('created_at', '>', carbon::now()->subHours(2))->first();
        if(!empty($check_token)){
            $admin = Admin::where('email', $check_token->email)->update([
                    'password' => bcrypt(request('password'))
            ]);
            DB::table('password_resets')->where('email', request('email'))->delete();
            admin()->attempt(['email'=> $check_token->email, 'password' => request('password')] , true);
            return redirect(aurl(''));
        }else{
            return redirect(aurl('forgot/passwoed'));
        }
    }
}