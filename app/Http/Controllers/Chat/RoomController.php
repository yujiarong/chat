<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use DataTables;

class RoomController extends Controller
{
    public function index(){
        return view('chat.room.index');
    }

    public function tableGet(){
        $userList  = ChatRoom::select('*');
        return DataTables::of($userList)
            ->make(true);        
    }

    public function store(Request $request){
    	$name  = $request->get('name');
    	$room  = new ChatRoom;
    	$room->name       = $name;
    	$room->online_num = 0;
    	$room->save();
    	return ['code'=>200,'msg'=>'操作成功'];    
    }

}
