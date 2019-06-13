<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\ChatUser;
use Illuminate\Support\Facades\Auth;

class ChatLoginController extends Controller
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
    protected $redirectTo = '/chat';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function registerLogin(Request $request){
        $name     = $request->get('name');
        $password = $request->get('password');
        if(!ChatUser::where('name',$name)->count() ){
            $this->store([ 'name'=>$name,'password'=>$password,'ip'=>$request->ip() ]);//如果用户是第一次登陆则直接注册。
        }
        return $this->login($request);
    }


    public function showLoginForm()
    {
        return view('chat');
    }

    protected function guard()
    {
        return Auth::guard('chat');
    }

    public function username()
    {
        return 'name';
    }

    public function store($data){
        $userModel = new ChatUser;
        $userModel->name     = $data['name'];
        $userModel->password = bcrypt($data['password']);
        $userModel->ip       = $data['ip'];
        $userModel->avatar   = 'images/avatar/f1/f_'.rand(1,12).'.jpg';
        return  $userModel->save();      

    }   

    public function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $request->ajax() || $request->wantsJson() ? 
            response()->json([
                'code' => 200,
                'msg' => 'Login Success!',
                'data' => [],
            ]) : redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if(  $request->ajax() || $request->wantsJson() ){
            return response()->json([
                'code' => 301,
                'msg' => '密码出错!',
                'data' => [],
            ]);
        }else{
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);           
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();//多表用户登陆,这里会出问题

        return redirect($this->redirectTo);
    }

}
