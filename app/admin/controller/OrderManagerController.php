<?php

namespace app\admin\controller;

use app\admin\service\OrderService;
use app\BaseController;
use app\lib\ResponseResult;
use app\model\CustomerInfoModel;
use app\model\CustomerReceiveModel;
use app\model\OrderInfoModel;
use app\model\ProductInfoModel;
use think\facade\Log;
use think\facade\View;
use think\facade\Config;
use think\annotation\Route;
use \think\facade\Db;

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

    /**
     * 返回添加/编辑订单页面
     */
    public function addOrEditOrderIndex()
    {
        $orderId = request()->param('orderId');
        // dump( $orderId);
        $orderInfo = null;
        $receiveList = [];
        // $productList = ProductInfoModel::column('product_number', 'product_name', 'product_model');
        $productList = json_encode(ProductInfoModel::select()->toArray(), JSON_UNESCAPED_UNICODE);
        // dump( $productList );
        $customerList = CustomerInfoModel::select()->toArray();
        if (!empty($orderId)) {
            $orderInfo =  OrderInfoModel::find($orderId);
            $receiveList = CustomerReceiveModel::where('customer_id', $orderInfo['customer_id'])->select()->toArray();
        }
        // dump( $orderInfo);
        // View::assign方法赋值属于全局变量赋值，如果需要单次赋值的话，可以直接在fetch方法中传入,或使用view()助手函数
        return view('order/order', ['orderInfo' => $orderInfo, 'productList' => $productList, 'customerList' => $customerList, 'receiveList' => $receiveList]);
    }

    /**
     * 添加或编辑订单
     */
    public function addOrEditOrder()
    {
        $order = request()->param();
        // 订单编号可能是多个
        $product_number = $order['product_number'];
        // 先查看产品编号是否存在
        $productList = ProductInfoModel::where('product_number', 'in', $product_number)->select();
        if (empty($productList)) {
            return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'), '产品信息不存在!');
        }
        $orderService = new OrderService;
        // dump($order);
        try {
            $orderService->saveOrEditOrder($order);
            return ResponseResult::Success();
        } catch (\Exception $e) {
            return ResponseResult::Error(null, $e->getMessage());
        }
        return ResponseResult::Error();
    }

    /**
     * 删除订单信息
     */
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
        $orderService = new OrderService;
        $orderDetail = $orderService->getOrderDetail($id);
        // dump($orderDetail);
        return view('order/order_detail', $orderDetail);
    }


    /**
     * 导出数据到Excel,使用注解路由
     * @Route("order/export")
     */
    public function export()
    {
        $sql = <<<sql
        SELECT
        a.order_number,
        a.product_number,
        b.logistics,
        b.inspection_report,
        b.rceceipt_confirm,
        b.rceceipt_date,
        b.invoice_date,
        b.invoice_code,
        b.invoice_number,
        b.invoice_follow,
        b.express,
        b.express_number,
        b.ticket_confirm,
        b.acceptance,
        b.recovery_of_balance,
        b.send_date,
        c.customer_name,
        c.customer_address,
        c.phone,
        c.contacts,
        JSON_UNQUOTE(JSON_EXTRACT(a.product_info,'$.product_name')) as product_name,
        JSON_UNQUOTE(JSON_EXTRACT(a.product_info,'$.product_specs')) as product_specs,
        JSON_UNQUOTE(JSON_EXTRACT(a.product_info,'$.product_model')) as product_model,
        JSON_UNQUOTE(JSON_EXTRACT(a.product_info,'$.special_request')) as special_request,
        JSON_UNQUOTE(JSON_EXTRACT(a.receive_info,'$.recipient_company')) as recipient_company,
        JSON_UNQUOTE(JSON_EXTRACT(a.receive_info,'$.recipient')) as recipient,
        JSON_UNQUOTE(JSON_EXTRACT(a.receive_info,'$.recipient_phone')) as recipient_phone,
        JSON_UNQUOTE(JSON_EXTRACT(a.receive_info,'$.recipient_address')) as recipient_address,
        JSON_UNQUOTE(JSON_EXTRACT(a.receive_info,'$.ticket')) as ticket,
        JSON_UNQUOTE(JSON_EXTRACT(a.receive_info,'$.ticket_phone')) as ticket_phone,
        JSON_UNQUOTE(JSON_EXTRACT(a.receive_info,'$.ticket_address')) as ticket_address
        FROM
            `order_detail` a
            LEFT JOIN `order_info` b ON a.order_number = b.order_number LEFT JOIN customer_info c ON b.customer_id=c.id;
        sql;


        $exportOrder = Db::query($sql);
        return ResponseResult::Success($exportOrder);
    }
}
