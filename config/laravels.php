<?php
/**
 * @see https://github.com/hhxsv5/laravel-s/blob/master/Settings-CN.md  Chinese
 * @see https://github.com/hhxsv5/laravel-s/blob/master/Settings.md  English
 */
return [
    'listen_ip'                => env('LARAVELS_LISTEN_IP', '0.0.0.0'),
    'listen_port'              => env('LARAVELS_LISTEN_PORT', 9090),
    'socket_type'              => env('LARAVELS_SOCKET_TYPE', defined('SWOOLE_SOCK_TCP') ? \SWOOLE_SOCK_TCP : 1),
    'enable_gzip'              => env('LARAVELS_ENABLE_GZIP', false),
    'enable_coroutine_runtime' => false,
    'server'                   => env('LARAVELS_SERVER', 'LaravelS'),
    'handle_static'            => env('LARAVELS_HANDLE_STATIC', true),
    'laravel_base_path'        => env('LARAVEL_BASE_PATH', base_path()),
    'inotify_reload'           => [
        'enable'        => env('LARAVELS_INOTIFY_RELOAD', false),
        'watch_path'    => base_path(),
        'file_types'    => ['.php'],
        'excluded_dirs' => [],
        'log'           => true,
    ],
    'websocket'                => [
        'enable' => true,
        'handler' => \App\Services\WebSocketService::class,
    ],
    'sockets'                  => [
    ],
    'processes'                => [
    ],
    'timer'                    => [
        'enable' => false,
        'jobs'   => [
            // Enable LaravelScheduleJob to run `php artisan schedule:run` every 1 minute, replace Linux Crontab
            //\Hhxsv5\LaravelS\Illuminate\LaravelScheduleJob::class,
            // Two ways to configure parameters:
            // [\App\Jobs\XxxCronJob::class, [1000, true]], // Pass in parameters when registering
            // \App\Jobs\XxxCronJob::class, // Override the corresponding method to return the configuration
        ],
    ],
    'events'                   => [
    ],
    'swoole_tables'            => [
        //定义登陆用户的信息
        'ws_users'          =>[
            'size'   => 1024,//Table的最大行数
            'column' => [// Table的列定义$roomid,$fd,$name,$email,$avatar
                ['name' => 'roomid', 'type' => \swoole_table::TYPE_STRING, 'size' => 8],
                ['name' => 'fd', 'type' => \swoole_table::TYPE_INT, 'size' => 8],
                ['name' => 'name', 'type' => \swoole_table::TYPE_STRING, 'size' => 100],
                ['name' => 'email', 'type' => \swoole_table::TYPE_STRING, 'size' => 100],
                ['name' => 'avatar', 'type' => \swoole_table::TYPE_STRING, 'size' => 100],
                ['name' => 'time', 'type' => \swoole_table::TYPE_STRING, 'size' => 50],
            ]
        ],
        'ws_rooms'=>[
            'size'   => 1024,//Table的最大行数
            'column' => [// Table的列定义$roomid,$fd,$name,$email,$avatar
                ['name' => 'users', 'type' => \swoole_table::TYPE_STRING, 'size' => 1024],
            ]
        ],
        'ws_roomUsers'=>[
            'size'   => 1024,//Table的最大行数
            'column' => [// Table的列定义$roomid,$fd,$name,$email,$avatar
                ['name' => 'infos', 'type' => \swoole_table::TYPE_STRING, 'size' => 1024],
            ]
        ],
    ],
    'register_providers'       => [
    ],
    'swoole'                   => [
        'daemonize'          => env('LARAVELS_DAEMONIZE', false),
        'dispatch_mode'      => 2,
        'reactor_num'        => function_exists('\swoole_cpu_num') ? \swoole_cpu_num() * 2 : 4,
        'worker_num'         => function_exists('\swoole_cpu_num') ? \swoole_cpu_num() * 2 : 8,
        'task_worker_num'    => function_exists('\swoole_cpu_num') ? \swoole_cpu_num() * 2 : 8,
        'task_ipc_mode'      => 1,
        'task_max_request'   => 5000,
        'task_tmpdir'        => @is_writable('/dev/shm/') ? '/dev/shm' : '/tmp',
        'message_queue_key'  => ftok(base_path('public/index.php'), 1),
        'max_request'        => 3000,
        'open_tcp_nodelay'   => true,
        'pid_file'           => storage_path('laravels.pid'),
        'log_file'           => storage_path(sprintf('logs/swoole-%s.log', date('Y-m'))),
        'log_level'          => 4,
        'document_root'      => base_path('public'),
        'buffer_output_size' => 16 * 1024 * 1024,
        'socket_buffer_size' => 128 * 1024 * 1024,
        'package_max_length' => 4 * 1024 * 1024,
        'reload_async'       => true,
        'max_wait_time'      => 60,
        'enable_reuse_port'  => true,
        'enable_coroutine'   => false,

        /**
         * More settings of Swoole
         * @see https://wiki.swoole.com/wiki/page/274.html  Chinese
         * @see https://www.swoole.co.uk/docs/modules/swoole-server/configuration  English
         */
    ],
];
