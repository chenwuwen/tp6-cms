<?php

namespace app\admin\controller;

use app\BaseController;
use app\lib\ResponseResult;
use app\model\OrderInfoModel;
use app\model\ProductInfoModel;
use think\facade\Log;
use think\facade\View;
use think\facade\Config;

class OrderManagerController extends BaseController
{

    public function index()
    {
        # code...
        return View::fetch("order/index");
    }

    public function list()
    {
        $orderInfoModel = new OrderInfoModel;
        // $_POST函数获取值,需要取到key存在,否则会报错:未定义数组索引:xxx
        $productNumber = isset($_POST["product_number"]) ? $_POST["product_number"] : '';

        // 以下的两个where是AND的的关系
        if (is_numeric($productNumber)) {
            Log::debug("订单查询,productNumber" . $productNumber);
            $orderInfoModel = $orderInfoModel->where('product_number', 'LIKE', '%' . $productNumber . '%');
        }

        $count = $orderInfoModel->count();
        $list = $orderInfoModel->page($_POST["page"], $_POST["limit"])->select();
        return ResponseResult::Success($list, $count);
    }

    public function addOrEditOrderIndex()
    {
        $orderId = request()->param('orderId');
        // dump( $orderId);
        $orderInfo = null;
        // $productList = ProductInfoModel::column('product_number', 'product_name', 'product_model');
        $productList = ProductInfoModel::select()->toArray();
        if (!empty($orderId)) {
            $orderInfo =  OrderInfoModel::find($orderId);
        }
        // dump( $orderInfo);
        // View::assign方法赋值属于全局变量赋值，如果需要单次赋值的话，可以直接在fetch方法中传入,或使用view()助手函数
        return view('order/order', ['orderInfo' => $orderInfo, 'productList' => $productList]);
    }

    public function addOrEditOrder()
    {
        $order = request()->param();
        $product_number = $order['product_number'];
        $order_number = $order['order_number'];
        // 先查看产品编号是否存在
        $product = ProductInfoModel::where('product_number', $product_number)->find();
        if (empty($product)) {
            return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'), '产品信息不存在!');
        }
        if (empty($order_number)) {
            // 自动生成订单编号
            $order['order_number'] = get_sn();
        }
        $orderInfoModel = new OrderInfoModel();
        // dump($order);
        $result = $orderInfoModel->save($order);
        if ($result) {
            return ResponseResult::Success();
        }
        return ResponseResult::Error();
    }

    public function deleteOrder()
    {
        $idStr = request()->param("ids");
        $ids = explode('_', $idStr);
        // 这里的删除是使用了Tp的软删除功能,在模型中配置的
        OrderInfoModel::destroy($ids);
        return ResponseResult::Success();
    }

    /**
     * 查看订单明细
     */
    public function viewOrderDetail()
    {
        $id = request()->param("id");

        return view('order/order_detail');
    }
}
