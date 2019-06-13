<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\ChatUser;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{
    public function index(){
        return view('chat.user.index');
    }

    public function tableGet(){
        $userList  = ChatUser::select('*');
        return DataTables::of($userList)
            ->make(true);        
    }


}
