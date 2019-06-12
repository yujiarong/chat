<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2018/11/17
 * Time: 15:31
 */

namespace App\Services;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use App\ChatTask\ChatTask;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use Seven;
use App\Services\AIChatService;

/**
 * @see https://wiki.swoole.com/wiki/page/400.html
 */
class WebSocketService implements WebSocketHandlerInterface
{
    // 声明没有参数的构造函数
    public function __construct()
    {
    }

    public function onOpen(Server $server, Request $request)
    {
        $data = array(
            'task' => 'open',
            'fd' => $request->fd
        );

        $task = new ChatTask(json_encode($data));
        $ret = Task::deliver($task);
        echo $request->fd."open\n";
    }

    public function onMessage(Server $server, Frame $frame)
    {
        $data = json_decode( $frame->data , true );
        switch($data['type']){
            case 1://登录
                $data = array(
                    'task' => 'login',
                    'params' => array(
                        'name' => $data['name']
                    ),
                    'fd' => $frame->fd,
                    'roomid' =>$data['roomid']
                );
                if(!$data['params']['name']  ){
                    $data['task'] = "nologin";
                }
                $task = new ChatTask(json_encode($data));
                $ret = Task::deliver($task);
                echo $frame->fd."登陆\n";
                break;
            case 2: //新消息
                $data = array(
                    'task' => 'new',
                    'params' => array(
                        'name' => $data['name'],
                        'avatar' => $data['avatar']
                    ),
                    'c' => $data['c'],
                    'message' => $data['message'],
                    'fd' => $frame->fd,
                    'roomid' => $data['roomid']
                );
                $task = new ChatTask(json_encode($data));
                $ret = Task::deliver($task);
                if(strpos($data['message'], '@小爱') !== false){
                    $this->aichat($data);
                }
                echo $frame->fd."发了消息\n";
                break;

            case 3: // 改变房间
                $data = array(
                    'task' => 'change',
                    'params' => array(
                        'name'   => $data['name'],
                        'avatar' => $data['avatar']
                    ),
                    'fd' => $frame->fd,
                    'oldroomid' => $data['oldroomid'],
                    'roomid' => $data['roomid']
                );
                $task = new ChatTask(json_encode($data));
                $ret = Task::deliver($task);
                echo $frame->fd."改变房间\n";
                break;
            case 4: //私聊信息消息
                $data = array(
                    'task' => 'secretnew',
                    'params' => array(
                        'name' => $data['send_name'],
                        'avatar' => $data['send_avatar']
                    ),
                    'c' => $data['c'],
                    'message' => $data['message'],
                    'send_fd' => $frame->fd,
                    'receive_fd' => $data['receive_fd']
                );
                $task = new ChatTask(json_encode($data));
                $ret = Task::deliver($task);
                echo $frame->fd."向".$data['receive_fd']."发起了私聊\n";
                break;
            default :
                $server->push($frame->fd, json_encode(array('code'=>0,'msg'=>'type error')));
        }
    }
    //登出,记得laravels.php中的dispatch_mode要设置为2
    public function onClose(Server $server, $fd, $reactorId)
    {
        //获取登出的用户
        $user = app('swoole')->ws_usersTable->get('user'.$fd);
        if ($user){
            $data = array(
                'task' => 'logout',
                'params' => array(
                    'name' => $user['name'],
                    'roomid'=>$user['roomid']
                ),
                'fd' => $fd
            );
            $task = new ChatTask(json_encode($data));
            $ret = Task::deliver($task);
        }

        echo "client {$fd} closed\n";

    }

    public function aichat($data){
        $domain  = config('chat.domain');
        list(,$content) =  preg_split("/[\s]+/", $data['message']);
        if(empty($content)){
            $content = '你好';
        }
        $aichat  = new AIChatService;
        $message = $aichat->IAChat($content); 
        $data = array(
            'task' => 'new',
            'params' => array(
                'name' =>'小爱同学',
                'avatar' => $domain.'robot.jpg'
            ),
            'c' => 'text',
            'message' => $message,
            'fd' => 0,
            'roomid' => $data['roomid']
        );       
        $task = new ChatTask(json_encode($data));
        $ret = Task::deliver($task);
        echo "对于{$content}小爱同学回复了消息{$message}\n";
    }

}