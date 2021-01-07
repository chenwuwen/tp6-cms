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

//返回登陆页面
Route::get('login', 'AuthController/login', 'GET');

//登陆
Route::post('login', 'AuthController/doLogin', 'POST');

//注销
Route::get('logout', 'AuthController/logout', 'GET');

//返回仪表面板
Route::get('dashboard', 'DashboardController/index', 'GET');


// sysuser
// 规则匹配检测的时候默认只是对URL从头开始匹配，只要URL地址开头包含了定义的路由规则就会匹配成功，如果希望URL进行完全匹配，可以在路由表达式最后使用$符号
Route::get('sysuser$', 'SysUserManagerController/index', 'GET');

Route::any('sysuser/list', 'SysUserManagerController/list', 'GET');
// 变量用[ ]包含起来后就表示该变量是路由匹配的可选变量。
Route::get('sysuser/addOrEditSysUserIndex/[:id]', 'SysUserManagerController/addOrEditSysUserIndex');

Route::post('sysuser/addOrEditSysUser', 'SysUserManagerController/addOrEditSysUser')->token();

Route::post('sysuser/updatePassword', 'SysUserManagerController/updatePassword')->token();

// 直接返回模板
Route::view('sysuser/updatePassword', 'password');
// ids类型的参数,如果是多个不能以逗号和中横线分隔,否则只会读取第一个
Route::get('sysuser/delete/:ids', 'SysUserManagerController/deleteSysUser');


// customer
Route::get('customer$', 'CustomerManagerController/index', 'GET');

Route::any('customer/list', 'CustomerManagerController/list');

Route::get('customer/addOrEditCustomerIndex/[:customerId]', 'CustomerManagerController/addOrEditCustomerIndex');

Route::post('customer/addOrEditCustomer', 'CustomerManagerController/addOrEditCustomer')->token();

Route::get('customer/delete/:ids', 'CustomerManagerController/deleteCustomer', 'GET');

Route::get('customer/receive$', 'ReceiveManagerController/index', 'GET');

Route::get('customer/receive/list/:customerId', 'ReceiveManagerController/list', 'GET');

Route::post('customer/receive/addOrEditCustomerReceive', 'ReceiveManagerController/addOrEditCustomerReceive', 'POST')->token();

Route::post('customer/receive/delete/:ids', 'ReceiveManagerController/deleteCustomerReceive', 'GET');


// product
Route::get('product$', 'ProductManagerController/index', 'GET');

Route::any('product/list', 'ProductManagerController/list');

Route::get('product/addOrEditProductIndex/[:productId]', 'ProductManagerController/addOrEditProductIndex', 'GET');

Route::post('product/addOrEditProduct', 'ProductManagerController/addOrEditProduct', 'POST')->token();

Route::get('product/delete/:ids', 'ProductManagerController/deleteProduct', 'GET');


// order
Route::get('order$', 'OrderManagerController/index', 'GET');

Route::any('order/list', 'OrderManagerController/list');

Route::get('order/addOrEditOrderIndex/[:orderId]', 'OrderManagerController/addOrEditOrderIndex', 'GET');

Route::post('order/addOrEditOrder', 'OrderManagerController/addOrEditOrder', 'POST')->token();

Route::get('order/delete/:ids', 'OrderManagerController/deleteOrder', 'GET');

Route::get('order/viewOrderDetail/:id', 'OrderManagerController/viewOrderDetail', 'GET');

// role
Route::get('role$', 'SysRoleManagerController/index', 'GET');

Route::any('role/list', 'SysRoleManagerController/list');

Route::get('role/addOrEditRoleIndex/[:roleId]', 'SysRoleManagerController/addOrEditRoleIndex', 'GET');

Route::post('role/addOrEditRole', 'SysRoleManagerController/addOrEditRole', 'POST')->token();

Route::get('role/delete/:ids', 'SysRoleManagerController/deleteRole', 'GET');

// permission
Route::get('permission$', 'SysPermissionManagerController/index', 'GET');

Route::any('permission/list', 'SysPermissionManagerController/list');

Route::get('permission/addOrEditPermission/[:roleId]', 'SysPermissionManagerController/addOrEditPermissionIndex', 'GET');

Route::post('permission/addOrEditPermission', 'SysPermissionManagerController/addOrEditPermission', 'POST')->token();

Route::get('permission/getTree', 'SysPermissionManagerController/getTree', 'GET');

// site setting
Route::get('site$', 'SiteSettingController/index', 'GET');

Route::post('site/save', 'SiteSettingController/save', 'POST');


// notice
Route::get('notice', 'NoticeController/index', 'GET');