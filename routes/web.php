<?php

// 需要登录凭证
Route::group([
    'namespace' => 'Admin',
    'middleware'=> ['web', 'lang', 'verifyLogin']
], function() {
    Route::get('/', 'IndexController@getIndex');// 框架主体
    Route::get('welcome', 'IndexController@getWelcome');// 欢迎页面



    // 角色操作
    Route::get('role', 'RoleController@getRole');// 角色列表
    Route::any('add-role', 'RoleController@add');// 添加
    Route::any('edit-role', 'RoleController@edit');// 修改
    Route::get('role-on-off', 'RoleController@onOff');// 修改状态
    Route::any('role-access', 'RoleController@roleAccess');// 角色权限


    // 节点操作
    Route::get('node', 'NodeController@getNode');// 节点列表
    Route::any('add-node', 'NodeController@add');// 添加
    Route::any('edit-node', 'NodeController@edit');// 修改
    Route::get('del-node', 'NodeController@delNode');// 删除


    // 管理员操作
    Route::get('manager', 'ManagerController@getManager');  // 管理员列表
    Route::any('add-manager', 'ManagerController@add');     // 添加管理员
    Route::any('edit-manager', 'ManagerController@edit');   // 修改管理员
    Route::get('manager-on-off', 'ManagerController@onOff');// 修改状态
    Route::any('update-password-manager', 'ManagerController@updatePassword'); // 修改管理员密码
    Route::any('role-manager', 'ManagerController@role');// 角色修改
});





// 不需要登录凭证
Route::group([
    'namespace' => 'Admin',
    'middleware'=> ['web', 'lang']
], function() {
    Route::any('login', 'LoginController@getIndex');// 登录
    Route::get('logout', 'LoginController@logout');// 退出登录
});





