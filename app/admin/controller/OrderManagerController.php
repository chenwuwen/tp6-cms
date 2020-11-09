<?php

namespace app\admin\controller;

use app\BaseController;
use app\lib\ResponseResult;
use app\model\OrderInfoModel;
use think\facade\View;

class OrderManagerController extends BaseController
{

    public function index()
    {
        # code...
        return View::fetch("order/index");
    }

    public function list()
    {
        $orderInfo = new OrderInfoModel();
        $list = $orderInfo->select();
        $count = $orderInfo->count();
        return ResponseResult::Success($list, $count);
    }

    public function addOrEditOrderIndex()
    {
        $orderId = request()->param('orderId');
        // dump( $orderId);
        $orderInfo = null;
        if (!empty($orderId)) {
            $orderInfo =  OrderInfoModel::find($orderId);
        }
        // dump( $orderInfo);
        // View::assign方法赋值属于全局变量赋值，如果需要单次赋值的话，可以直接在fetch方法中传入,或使用view()助手函数
        return view('order/order', ['orderInfo' => $orderInfo]);
    }

    public function addOrEditOrder()
    {
        $order = request()->param();
        $orderInfoModel = new OrderInfoModel();
        // dump($order);
        $result = $orderInfoModel->save($order);
        if ($result) {
            return ResponseResult::Success();
        }
        return ResponseResult::Error();
    }
}
