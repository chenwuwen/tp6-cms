<?php

namespace app\admin\controller;

use app\BaseController;
use app\lib\ResponseResult;
use app\model\CustomerInfoModel;
use think\facade\View;
use think\facade\Config;

class CustomerManagerController extends BaseController
{


    public function index()
    {
        return View::fetch('/customer/index');
    }

    public function list()
    {
        $customerInfoModel =  new CustomerInfoModel;
        $count = CustomerInfoModel::count();
        $list = $customerInfoModel->select();
        return ResponseResult::Success($list, $count);
    }

    public function addOrEditCustomerIndex()
    {
        // 获取路由动态参数
        $customerId = request()->param('customerId');
        View::assign('customer', null);
        if (!empty($customerId)) {
            $customerInfo = CustomerInfoModel::find($customerId);
            View::assign('customer',  $customerInfo);
        }
        return View::fetch('/customer/customer');
    }

    public function addOrEditCustomer()
    {
        $customer = request()->param();
        // \dump($customer);

        try {
            $customerInfoModel =  new CustomerInfoModel;
            $result = $customerInfoModel->save($customer);
            if ($result) {
                return ResponseResult::Success();
            } else {
                return ResponseResult::Error(Config::get('ResponseResultStatus.validate_error_code'), "操作失败!");
            }
        } catch (\Exception $e) {
            return ResponseResult::Error(null, $e->getMessage());
        }
    }
}
