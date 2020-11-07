<?php
namespace app\admin\controller;
use app\BaseController;
use think\facade\View;

class DashboardController extends BaseController{

    public function index(){

        View::assign('viewCount',999);
        // 默认访问的模板页面是dashboard_controller,因为模板文件是直接放在了view下,所以,需要写成/dashboard
        return View::fetch('/dashboard');
    }
}