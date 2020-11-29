<?php

namespace app\admin\service;

use app\model\CustomerInfoModel;
use app\model\CustomerReceiveModel;
use app\model\OrderInfoModel;
use app\model\OrderDetailModel;
use app\model\ProductInfoModel;

class OrderService
{

    /**
     * 获取订单信息
     */
    public function getOrderDetail($orderId)
    {
        $orderInfo = OrderInfoModel::find($orderId);
        $customerInfo = CustomerInfoModel::find($orderInfo['customer_id']);
        // 一个订单下,可以有多个商品
        $orderDetailList =  OrderDetailModel::where('order_number', $orderInfo['order_number'])->select()->toArray();
        // dump($orderDetailList);
        return ['orderInfo' => $orderInfo, 'orderDetailList' => $orderDetailList, 'customerInfo' => $customerInfo];
    }

    /**
     * 添加或编辑订单信息,涉及到两张表的操作
     */
    public function saveOrEditOrder($orderInfo)
    {
        $order_number = $orderInfo['order_number'];
        $orderInfoModel = new OrderInfoModel();
        $product_number_arr =  explode(',', $orderInfo['product_number']);
        // 最后一个参数表示输出为数字格式
        $orderInfo['product_number'] = json_encode($product_number_arr, JSON_NUMERIC_CHECK);
        if (empty($order_number)) {
            // 自动生成订单编号
            $orderInfo['order_number'] = get_sn();
            // 插入order_info 表
            $orderInfoModel->save($orderInfo);
        } else {
            // 更新order_info表
            $order = $orderInfoModel->find($orderInfo);
            $order->save($orderInfo);
        }
        // dump($orderInfo['order_number']);
        // 获得插入的数据的id
        $orderId =  $orderInfoModel->id;

        // 删除订单详细信息
        OrderDetailModel::where('order_number', $orderInfo['order_number'])->delete();

        // 多个产品的订单详细备份
        foreach ($product_number_arr as $product_number) {

            $productInfo = ProductInfoModel::where('product_number', $product_number)->find();
            $receive_id = $orderInfo['receive_id'];
            $receiveInfo = CustomerReceiveModel::find($receive_id);
            $orderDetail = [
                'order_number' => $orderInfo['order_number'],
                'product_number' => $product_number,
                'product_info' => json_encode($productInfo, JSON_UNESCAPED_UNICODE),
                'receive_info' => json_encode($receiveInfo, JSON_UNESCAPED_UNICODE),
            ];
            $orderDetailModel = new OrderDetailModel;
            $orderDetailModel->save($orderDetail);
        }
    }
}
