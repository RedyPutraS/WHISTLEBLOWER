<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'u_username';
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'u_password');
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $attribute = [
            'password' => 'Password',
            'username' => 'Username',
        ];

        $rules_message =[
            'required' => ':attribute belum diisi'
        ];
        $this->validate($request, $rules, $rules_message, $attribute);

        $login = [
            'u_username' => $request->username,
            'password' => $request->password
        ];
        
        try{
            $user = User::active()->where('u_username', $request->username)->first();
            if (Auth::attempt($login)) {
                $log = [
                    'l_nama_aktivitas' => 'Login Sistem',
                    'l_nama_user' => $user->u_username,
                ];
                Log::create($log);
                return redirect()->route('dashboard');
            }
            else {
                return redirect()->route('login')->withErrors('Username / Password Salah!');
            }
        }
        catch(\Exception $e){
            return redirect()->route('login')->withErrors($e->getMessage());
        }
    }

    protected function loggedOut(Request $request)
    {
        try{
            $name = User::active()->select('u_username')->where('u_id',Crypt::decrypt($request->u_id))->first();
            User::active()->where('u_id',Crypt::decrypt($request->u_id))->update([
                'u_last_login' => date('Y-m-d H:i:s'),  
            ]);
            $log = [
                'l_nama_aktivitas' => 'Logout Sistem',
                'l_nama_user' => $name->u_username,
            ];
            Log::create($log);
            return redirect()->route('login');
        }catch(\Exception $e){
            return redirect()->route('login')->withErrors($e->getMessage());
        }
    }
}
