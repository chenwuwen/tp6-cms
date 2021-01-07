<?php
namespace app\admin\controller;
use app\BaseController;
use app\model\CustomerInfoModel;
use app\model\OrderInfoModel;
use app\model\ProductInfoModel;
use think\facade\View;

class NoticeController extends BaseController{

    public function index(){
        return "暂无提醒";
    }
}