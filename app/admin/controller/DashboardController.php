<?php
namespace app\admin\controller;
use app\BaseController;
use app\model\CustomerInfoModel;
use app\model\OrderInfoModel;
use app\model\ProductInfoModel;
use think\facade\View;

class DashboardController extends BaseController{

    public function index(){
        $orderTotal = OrderInfoModel::count();
        $customerTotal = CustomerInfoModel::count();
        $productTotal = ProductInfoModel::count();
        View::assign('orderTotal',$orderTotal);
        View::assign('customerTotal',$customerTotal);
        View::assign('productTotal',$productTotal);
        View::assign('viewCount',9999);
        // 默认访问的模板页面是dashboard_controller,因为模板文件是直接放在了view下,所以,需要写成/dashboard
        return View::fetch('/dashboard');
    }
}