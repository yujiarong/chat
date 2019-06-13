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
       'datatables.request' => \Yajra\DataTables\Utilities\Request::class,
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
