<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        session('ff',"sadwq");
        // 设置模板变量
        View::assign('sysUser',session(ADMIN_SESSION_KEY));
        // 不带任何参数 自动定位当前操作的模板文件
        return View::fetch();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
