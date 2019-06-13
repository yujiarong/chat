<?php
/**
 * All route names are prefixed with 'admin.access'.
 */
Route::group([
    'prefix'     => 'chat',
    'as'         => 'chat.',
    'namespace'  => 'Chat',
    'middleware' => ['permission']
], function () {


    Route::group([], function () {
        Route::get('/user/index', 'UserController@index')->name('user.index');
        //For DataTables
        Route::post('/user/tableGet', 'UserController@tableGet')->name('user.tableGet');
    });

    Route::group([], function () {
        Route::get('/room/index', 'RoomController@index')->name('room.index');
        //For DataTables
        Route::post('/room/tableGet', 'RoomController@tableGet')->name('room.tableGet');
        Route::post('/room/store', 'RoomController@store')->name('room.store');
    });

});


?>