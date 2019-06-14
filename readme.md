#  聊天室

> * 照着[webim](https://github.com/shisiying/webim)搭建的一个聊天项目[chat](https://github.com/yujiarong/chat),涉及swoole,websocket,laravels等知识点 
> * [聊天室入口](http://chat.dwyjr.cn/chat)  
> * [后台入口](http://chat.dwyjr.cn/chat/room/index)

### 主要知识点
* 使用Laravel 快速搭建后台管理系统，这里使用的是之前集成的一个项目 [niftyAdmin](https://github.com/yujiarong/niftyAdmin)，Laravel5.5。
* 集成[Laravels](https://github.com/hhxsv5/laravel-s)插件来使用Swoole的功能。
* 通过Nginx反向代理Swoole来加速HTTP服务，提高并发。
* 通过Swoole将Laravel常驻内存需要解决的一些注意事项。
* 在Laravel中使用多表登陆，前后台用户分开登陆管理，直接使用的Laravels的`guards`来处理。
* 通过Swoole来搭建高性能的Websocket的服务。
* 使用Swoole的异步Task功能来Push Websokcet 的Message。
* 使用Swoole的Tabel的直接管理一些不重要的数据。


### 主要功能
* 可以在聊天室群聊，也可以私聊。
* 通过laravels使用swoole搭建websocket 服务。
* 使用Task 异步发送websocket message 提高性能。
* 使用swoole_table 存储数据，如果是生产环境建议还是改成redis。

### 主要改动

* 新增一个聊天室后台，设置了onRequest回调，WebSocket\Server同时作为http服务器。
* 后台可以管理聊天室，主要是新增和查看聊天房间 [链接](http://chat.dwyjr.cn/chat/room/index)。
* 支持多表登陆,聊天用户管理,后台用户管理分开。
* 新增自动登录注册，也就是说页面会记住当前登录用户，不需要每次刷新抖登录。
* 新增小爱同学智能聊天，`@小爱`  聊天 ，他就会回复你哦，这个机器人很笨。

### 搭建流程

1. git clone https://github.com/yujiarong/chat
2. composer install
3. php artisan key:generate  composer里面应该集成了脚本
4. php artisan migrate 数据表迁移
5. php artisan laravels publish  发布laravels的配置文件
6. 修改配置文件
```bash
 `.env` 里面的 `JS_DOMIND` 图片域名  ，`WS_SERVER` JSd的websokcet连接地址
 `.env` 里面的 `LARAVELS_LISTEN_IP`和`LARAVELS_LISTEN_PORT`用于swoole的启动监听地址
```

7. nginx  使用以下的配置,后台域名HTTP访问直接代理到laravels,websocket直接使用ip+port访问。

```bash
upstream laravels {
    # 通过 IP:Port 连接
    server 127.0.0.1:9090  weight=5 max_fails=3 fail_timeout=30s;
    # 通过 UnixSocket Stream 连接，小诀窍：将socket文件放在/dev/shm目录下，可获得更好的性能
    #server unix:/xxxpath/laravel-s-test/storage/laravels.sock weight=5 max_fails=3 fail_timeout=30s;
    #server 192.168.1.1:5200 weight=3 max_fails=3 fail_timeout=30s;
    #server 192.168.1.2:5200 backup;
    keepalive 16;
}
server {

        listen       80;
        server_name  chat.dwyjr.cn;

        root        /data/web/chat/public/;
        error_log   /data/web/chat/storage/logs/error.log   error;
        access_log  /data/web/chat/storage/logs/access.log  main;
        index index.php;

        location / {
             try_files $uri @laravels;
        }


     location @laravels {
        # proxy_connect_timeout 60s;//看情况设置
        # proxy_send_timeout 60s;
        # proxy_read_timeout 120s;
        proxy_http_version 1.1;
        proxy_set_header Connection "";
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Real-PORT $remote_port;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header Server-Protocol $server_protocol;
        proxy_set_header Server-Name $server_name;
        proxy_set_header Server-Addr $server_addr;
        proxy_set_header Server-Port $server_port;
        proxy_pass http://laravels;
    }

}

```


### 开启 

使用 ./bin/laravels start 就可以开始了,后台挂起加 -d,这里通过[Laravels](https://github.com/hhxsv5/laravel-s/blob/master/Settings-CN.md)来使用swoole
```bash
 _                               _  _____ 
| |                             | |/ ____|
| |     __ _ _ __ __ ___   _____| | (___  
| |    / _` | '__/ _` \ \ / / _ \ |\___ \ 
| |___| (_| | | | (_| |\ V /  __/ |____) |
|______\__,_|_|  \__,_| \_/ \___|_|_____/ 
                                           
Speed up your Laravel/Lumen
>>> Components
+---------------------------+---------+
| Component                 | Version |
+---------------------------+---------+
| PHP                       | 7.1.10  |
| Swoole                    | 4.2.1   |
| LaravelS                  | 3.5.2   |
| Laravel Framework [local] | 5.5.45  |
+---------------------------+---------+
>>> Protocols
+----------------+--------+-------------------------------+--------------+
| Protocol       | Status | Handler                       | Listen At    |
+----------------+--------+-------------------------------+--------------+
| Main HTTP      | On     | Laravel Framework             | 0.0.0.0:9090 |
| Main WebSocket | On     | App\Services\WebSocketService | 0.0.0.0:9090 |
+----------------+--------+-------------------------------+--------------+

```

### 遇到的坑
> 基于swoole，将HTTP服务和Websocket服务整合在一起，使用laravels插件，swoole是常驻内存的,所以单例对象的使用是非常要注意的，Laravel内有很多功能使用单例模式。

1. Laravel的Controller里的构造方法如果初始化了一些参数，初始化后每次请求都是一样的，除非worker重启，这里如果遇到问题则每次请求后需要手动重置Controller。
2. 某些服务提供者在加入了swoole之后因为会出现问题在，需要每次请求后重置，可以加在`config/laravels.php`的`register_providers`数组中。
3. 如果使用到了Session一定要把`config/laravels.php`的`cleaners`中`SessionCleaner`和`AuthCleaner`开启，原因和上面一样。
4. 若按照上面这样设置了之后还是有问题，则自己手动使用中间件清理或者重新绑定服务，比如以下方式。

```bash
<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Log;

class SwooleCleaner
{
    /**
     * 使用swoole时 清理一些常驻内存有问题的实例 
     * 因控制器是单例，会常驻于内存，控制器中使用了静态变量,或者在构造函数__construct() 初始化了一些东西，就需要重置这个控制器
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public $resetProvider = [
       'datatables.request' => \Yajra\DataTables\Utilities\Request::class, //如果不清理，这个插件搜索的时候就会出问题。
    ];

    public function handle($request, Closure $next)
    {
        if (PHP_SAPI === 'cli') { 
            $this->resetProvider();
            $response  = $next($request);
            if(isset(Route::current()->controller )){
                unset( Route::current()->controller );
            }
            Log::info( "Swoole 请求之后删除controller");
            return $response ;
        }else{
            return $next($request);
        }
    }

    /*
    * 重新绑定一些服务提供者,有些服务提供者有 boot()有初始化可能需要更多的操作
    */
    public function resetProvider(){
        foreach ($this->resetProvider as $key => $provider) {
            if(app($key)){
                Log::info("Swoole 重置 {$key}");
                app()->singleton($key, function ()use($provider) {
                    return new $provider;
                });                
            }
        }
    }
}

```