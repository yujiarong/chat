<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AIChatService;
use App\Exceptions\InvalidRequestException;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['chat','aichat']);;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('home');
    }

    public function chat(){
        return view('index');
    }

    public function aichat(Request $request){
        $content = $request->get('content');
        if(empty($content)){
            dd('请输入有效的content字段');
        }
        $aichat  = new AIChatService;
        $data    = $aichat->IAChat($content);
        dd($data);
    }
}
