<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::get('login', 'AuthController/login', 'GET');

Route::post('login', 'AuthController/doLogin', 'POST');

Route::get('logout', 'AuthController/logout', 'GET');

Route::get('dashboard', 'DashboardController/index', 'GET');



// 规则匹配检测的时候默认只是对URL从头开始匹配，只要URL地址开头包含了定义的路由规则就会匹配成功，如果希望URL进行完全匹配，可以在路由表达式最后使用$符号
Route::get('sysuser$', 'SysUserManagerController/index', 'GET');

Route::any('sysuser/list', 'SysUserManagerController/list',);
// 变量用[ ]包含起来后就表示该变量是路由匹配的可选变量。
Route::get('sysuser/addOrEditSysUserIndex/[:id]', 'SysUserManagerController/addOrEditSysUserIndex');

Route::post('sysuser/addOrEditSysUser', 'SysUserManagerController/addOrEditSysUser');

// customer
Route::get('customer$', 'CustomerManagerController/index', 'GET');

Route::any('customer/list', 'CustomerManagerController/list');

Route::get('customer/addOrEditCustomerIndex/[:customerId]', 'CustomerManagerController/addOrEditCustomerIndex');

Route::post('customer/addOrEditCustomer', 'CustomerManagerController/addOrEditCustomer');


// product
Route::get('product$', 'ProductManagerController/index', 'GET');

Route::any('product/list', 'ProductManagerController/list');

Route::get('product/addOrEditProductIndex/[:productId]', 'ProductManagerController/addOrEditProductIndex', 'GET');

Route::post('product/addOrEditProduct', 'ProductManagerController/addOrEditProduct', 'POST');


// order
Route::get('order$', 'OrderManagerController/index', 'GET');

Route::any('order/list', 'OrderManagerController/list');

Route::get('order/addOrEditOrderIndex/[:orderId]', 'OrderManagerController/addOrEditOrderIndex', 'GET');

Route::post('order/addOrEditOrder', 'OrderManagerController/addOrEditOrder', 'POST');

// role
Route::get('role$', 'SysRoleManagerController/index', 'GET');

Route::any('role/list', 'SysRoleManagerController/list');

Route::get('role/addOrEditRoleIndex/[:roleId]', 'SysRoleManagerController/addOrEditRoleIndex', 'GET');

Route::post('role/addOrEditRole', 'SysRoleManagerController/addOrEditRole', 'POST');

// permission
Route::get('permission$', 'SysPermissionManagerController/index', 'GET');

Route::any('permission/list', 'SysPermissionManagerController/list');

Route::get('permission/addOrEditPermission/[:roleId]', 'SysPermissionManagerController/addOrEditPermissionIndex', 'GET');

Route::post('permission/addOrEditPermission', 'SysPermissionManagerController/addOrEditPermission', 'POST');

Route::get('permission/getTree', 'SysPermissionManagerController/getTree', 'GET');
