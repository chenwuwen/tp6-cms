<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        // Session信息中保存了,用户ID/用户名/用户角色/用户所有权限
        $userDetail = session(ADMIN_SESSION_KEY);
        // dump($userDetail);
        // 设置模板变量
        View::assign('permissionList',$userDetail['permission']);
        // 不带任何参数 自动定位当前操作的模板文件
        return View::fetch();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
