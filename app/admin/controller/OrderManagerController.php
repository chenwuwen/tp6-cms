<?php
namespace app\admin\controller;
use app\BaseController;
use think\facade\View;

class OrderManagerController extends BaseController{

    public function index()
    {
        # code...
        return View::fetch("order/index");
    }

    public function list()
    {
        # code...
    }

}