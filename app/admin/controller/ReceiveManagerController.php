<?php

namespace app\admin\controller;

use app\BaseController;
use app\lib\ResponseResult;
use app\model\CustomerReceiveModel;

/**
 * 接收地址管理(跟客户是关联的,多对一的关系)
 */
class ReceiveManagerController extends BaseController
{
    public function index()
    {
        $customerId =  request()->param("customer_id");
        return view("customer/receive", ['customerId' => $customerId]);
    }

    public function list()
    {
        $customerId =  request()->param("customerId");
        $receiveList = CustomerReceiveModel::where('customer_id', $customerId)->select();
        // $count = CustomerReceiveModel::where('customer_id', $customerId)->count();
        return ResponseResult::Success($receiveList, 1);
    }

    public function addOrEditCustomerReceive()
    {
        $param = request()->param();
        $receiveModel =  new CustomerReceiveModel;
        if (empty($param['id'])) {
            $receiveModel->save($param);
        } else {
            $recevie = $receiveModel->find($param['id']);
            $recevie->save($param);
        }
        return ResponseResult::Success();
    }

    public function deleteCustomerReceive()
    {
        $idStr = request()->param('ids');
        $ids = explode('_', $idStr);
        CustomerReceiveModel::destroy($ids);
        return ResponseResult::Success();
    }
}
