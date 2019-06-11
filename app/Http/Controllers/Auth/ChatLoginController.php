<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\ChatUser;

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
            $this->store(['name'=>$name,'password'=>$password]);//如果用户是第一次登陆则直接注册。
        }
        return $this->login($request);
    }


    public function showLoginForm()
    {
        return view('chat');
    }

    protected function guard()
    {
        return auth()->guard('chat');
    }

    public function username()
    {
        return 'name';
    }

    public function store($data){
        $userModel = new ChatUser;
        $userModel->name     = $data['name'];
        $userModel->password = bcrypt($data['password']);
        return  $userModel->save();      

    }   

    public function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $request->ajax() || $request->wantsJson() ? 
            response()->json([
                'code' => 200,
                'message' => 'Login Success!',
                'data' => [],
            ]) : redirect()->intended($this->redirectPath());
    }

}
